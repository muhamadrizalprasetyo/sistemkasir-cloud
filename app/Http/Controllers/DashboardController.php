<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'kasir') {
            return redirect()->route('orders.index');
        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalOmzet = Order::where('payment_status', 'Paid')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');

        $totalExpenses = Expense::whereBetween('expense_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $labaBersih = $totalOmzet - $totalExpenses;

        $pesananAktif = Order::where('order_status', '!=', 'Selesai')->count();

        $recentOrders = Order::with('customer')->latest()->limit(5)->get();

        return view('dashboard.owner', compact(
            'totalOmzet',
            'totalExpenses',
            'labaBersih',
            'pesananAktif',
            'recentOrders'
        ));
    }
}
