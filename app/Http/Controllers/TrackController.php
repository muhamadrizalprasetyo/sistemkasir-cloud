<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        return view('track');
    }

    public function search(Request $request)
    {
        $keyword = trim($request->input('keyword'));
        $orders = collect(); // Default empty collection

        if (empty($keyword)) {
            return view('track', compact('orders'))->with('error', 'Silakan masukkan Nomor Invoice atau No WhatsApp.');
        }

        // Jika keyword dimulai dengan "INV-" (case-insensitive)
        if (stripos($keyword, 'INV-') === 0) {
            $order = Order::with(['customer', 'orderDetails.service'])
                ->where('invoice_number', $keyword)
                ->first();

            if ($order) {
                $orders->push($order);
            }
        }
        // Jika bukan Invoice, asumsikan Nomor WA
        else {
            $customer = Customer::where('phone', $keyword)->first();

            if ($customer) {
                // Ambil relasi semua pesanan milik pelanggan tersebut
                $orders = Order::with(['customer', 'orderDetails.service'])
                    ->where('customer_id', $customer->id)
                    ->latest()
                    ->get();
            }
        }

        return view('track', compact('orders', 'keyword'));
    }
}
