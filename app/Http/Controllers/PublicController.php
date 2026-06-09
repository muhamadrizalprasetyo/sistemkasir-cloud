<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function track(Request $request)
    {
        $search = $request->input('search');

        $order = Order::with(['customer', 'orderDetails.service'])
            ->where('invoice_number', $search)
            ->orWhereHas('customer', function ($query) use ($search) {
                $query->where('phone', $search);
            })
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan. Periksa kembali Nomor Nota atau No WA Anda.');
        }

        return view('landing', compact('order'));
    }
}
