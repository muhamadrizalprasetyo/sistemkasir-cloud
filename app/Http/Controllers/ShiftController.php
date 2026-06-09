<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    public function summary()
    {
        $payments = Payment::whereNull('shift_id')->get();

        $cashTotal = $payments->where('method', 'cash')->sum('amount');
        $nonCashTotal = $payments->whereIn('method', ['transfer', 'qris'])->sum('amount');
        $grossTotal = $cashTotal + $nonCashTotal;
        $firstPayment = $payments->sortBy('created_at')->first();

        return response()->json([
            'cash_total' => $cashTotal,
            'non_cash_total' => $nonCashTotal,
            'gross_total' => $grossTotal,
            'payment_count' => $payments->count(),
            'started_at' => $firstPayment ? $firstPayment->created_at->toDateTimeString() : now()->toDateTimeString(),
        ]);
    }

    public function endShift(Request $request)
    {
        return DB::transaction(function () {
            $payments = Payment::whereNull('shift_id')->get();

            $cashTotal = $payments->where('method', 'cash')->sum('amount');
            $nonCashTotal = $payments->whereIn('method', ['transfer', 'qris'])->sum('amount');
            $grossTotal = $cashTotal + $nonCashTotal;
            $firstPayment = $payments->sortBy('created_at')->first();
            $startedAt = $firstPayment ? $firstPayment->created_at : now();

            $shift = Shift::create([
                'user_id' => Auth::id(),
                'started_at' => $startedAt,
                'ended_at' => now(),
                'gross_total' => $grossTotal,
                'cash_total' => $cashTotal,
                'non_cash_total' => $nonCashTotal,
                'notes' => 'Shift ended by user ' . Auth::user()->name,
            ]);

            if ($payments->isNotEmpty()) {
                Payment::whereNull('shift_id')->update(['shift_id' => $shift->id]);
            }

            return response()->json([
                'success' => true,
                'shift_id' => $shift->id,
                'cash_total' => $cashTotal,
                'non_cash_total' => $nonCashTotal,
                'gross_total' => $grossTotal,
            ]);
        });
    }
}
