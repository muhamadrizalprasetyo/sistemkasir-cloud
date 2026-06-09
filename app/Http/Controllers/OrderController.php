<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'user'])->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $services = Service::with('category')->orderBy('category_id')->orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        return view('orders.create', compact('services', 'customers'));
    }

    public function store(Request $request)
    {
        // CRITICAL: Convert 'new' to null so validation doesn't fail on exists:customers,id
        if ($request->customer_id === 'new') {
            $request->merge(['customer_id' => null]);
        }

        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'new_customer_phone' => 'required_without:customer_id|nullable|string|max:20',
            'new_customer_name' => 'required_without:customer_id|nullable|string|max:255',
            'order_type' => 'required|in:drop,pickup,delivery',
            'payment_method' => 'required|in:cash,transfer,qris',
            'dp_amount' => 'nullable|numeric|min:0',
            'cash_received' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.item_variant' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Resolve customer: existing or create new
            if ($request->customer_id) {
                $customer = Customer::findOrFail($request->customer_id);
            } else {
                // If phone exists, reuse the existing customer record
                // If not, create a brand new customer
                $phone = $this->sanitizeWhatsapp($request->new_customer_phone);
                $customer = Customer::firstOrCreate(
                    ['phone' => $phone],
                    ['name' => $request->new_customer_name, 'membership_type' => 'regular']
                );
            }

            // Calculate total price first
            $totalPrice = 0;
            $itemsData = [];
            foreach ($request->items as $item) {
                $service = Service::find($item['service_id']);
                $subtotal = $service->price * $item['quantity'];
                $totalPrice += $subtotal;

                $itemsData[] = [
                    'service_id' => $service->id,
                    'item_variant' => $item['item_variant'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }

            // Calculate discount based on membership or loyalty stamps
            $discountAmount = 0;
            $redeemedLoyalty = false;

            if ($customer->membership_type === 'more_running_club') {
                $discountAmount = $totalPrice * 0.10;
            } elseif ($customer->stamp_count >= 10) {
                $discountAmount = 35000;
                $redeemedLoyalty = true;
            }

            $grandTotal = max(0, $totalPrice - $discountAmount);

            $dpValidator = Validator::make($request->all(), [
                'dp_amount' => ['nullable','numeric','min:0','lte:'.$grandTotal],
            ], [
                'dp_amount.lte' => 'Nominal DP tidak boleh lebih besar dari Total Tagihan.',
            ]);

            if ($dpValidator->fails()) {
                return back()->withErrors($dpValidator)->withInput();
            }

            // Limit DP so it doesn't exceed grand total
            $dpAmount = min($request->dp_amount ?: 0, max(0, $grandTotal));
            $cashReceived = $request->cash_received ?: 0;

            // Determine payment_status
            if ($grandTotal <= 0) {
                $paymentStatus = 'Paid';
            } elseif ($dpAmount <= 0) {
                $paymentStatus = 'Unpaid';
            } elseif ($dpAmount < $grandTotal) {
                $paymentStatus = 'DP';
            } else {
                $paymentStatus = 'Paid';
            }

            // Calculate change
            $changeAmount = max(0, $cashReceived - $dpAmount);

            $invoiceNumber = $this->generateInvoiceNumber();

            $order = Order::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $customer->id,
                'user_id' => Auth::id(),
                'delivery_method' => 'Drop Off',
                'order_type' => $request->order_type,
                'payment_status' => $paymentStatus,
                'payment_method' => $request->payment_method,
                'dp_amount' => $dpAmount,
                'discount_amount' => $discountAmount,
                'cash_received' => $cashReceived,
                'change_amount' => $changeAmount,
                'order_status' => 'Antrian',
                'total_amount' => $grandTotal,
                'notes' => $request->notes,
            ]);

            foreach ($itemsData as $data) {
                OrderDetail::create(array_merge($data, ['order_id' => $order->id]));
            }

            if ($dpAmount > 0) {
                Payment::create([
                    'order_id' => $order->id,
                    'shift_id' => null,
                    'amount' => $dpAmount,
                    'method' => $request->payment_method,
                    'type' => 'dp',
                ]);
            }

            if ($redeemedLoyalty) {
                $customer->update(['stamp_count' => 0]);
            }

            DB::commit();

            return redirect()->route('orders.index')->with('success', "Pesanan berhasil diproses! Invoice: $invoiceNumber | Kembalian: Rp" . number_format($changeAmount, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'user', 'orderDetails.service']);
        return view('orders.show', compact('order'));
    }

    protected function sanitizeWhatsapp(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        $clean = preg_replace('/[^0-9+]/', '', $phone);

        if (str_starts_with($clean, '+62')) {
            $clean = substr($clean, 1);
        } elseif (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }

        return $clean;
    }

    protected function generateInvoiceNumber(): string
    {
        do {
            $timestamp = now()->format('YmdHisv');
            $randomPart = strtoupper(Str::random(3));
            $invoiceNumber = 'INV-' . $timestamp . '-' . $randomPart;
        } while (Order::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:Antrian,Dicuci,Dikeringkan,Siap Diambil,Selesai',
        ]);

        $oldStatus = $order->order_status;
        $newStatus = $request->order_status;

        DB::transaction(function () use ($order, $oldStatus, $newStatus) {
            $order->update(['order_status' => $newStatus]);

            // Loyalty logic: Add 1 stamp when status changed to 'Selesai' for the first time
            if ($newStatus === 'Selesai' && $oldStatus !== 'Selesai') {
                $order->customer->increment('stamp_count');
            }
            // Optional: Decrement if changed back from Selesai (prevent abuse)
            if ($oldStatus === 'Selesai' && $newStatus !== 'Selesai') {
                $order->customer->decrement('stamp_count');
            }
        });

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui menjadi "' . $newStatus . '".');
    }

    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer,qris',
        ]);

        $sisaPelunasan = max(0, $order->total_amount - ($order->dp_amount ?? 0));

        if ($sisaPelunasan <= 0) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Pesanan sudah lunas atau tidak memiliki sisa pelunasan.');
        }

        DB::transaction(function () use ($order, $request, $sisaPelunasan) {
            Payment::create([
                'order_id' => $order->id,
                'shift_id' => null,
                'amount' => $sisaPelunasan,
                'method' => $request->payment_method,
                'type' => 'pelunasan',
            ]);

            $order->update(['payment_status' => 'Paid']);
        });

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pelunasan berhasil dicatat. Status: LUNAS ✓');
    }

    public function edit($id)
    {
        // Placeholder
    }

    public function update(Request $request, $id)
    {
        // Placeholder
    }

    public function destroy($id)
    {
        // Placeholder
    }

    public function printReceipt($id)
    {
        $order = Order::with(['customer', 'orderDetails.service', 'payments'])->findOrFail($id);
        return view('orders.receipt', compact('order'));
    }
}
