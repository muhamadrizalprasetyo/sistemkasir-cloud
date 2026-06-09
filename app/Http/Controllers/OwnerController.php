<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Order;
use App\Models\Expense;
use Illuminate\Support\Carbon;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403);
        }

        $query = Shift::with('user', 'payments')->orderBy('started_at', 'desc');

        // optional date filters
        if ($request->filled('from')) {
            $query->where('started_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->where('ended_at', '<=', $request->input('to'));
        }

        $shifts = $query->paginate(20)->appends($request->query());

        // compute summary fields for display
        foreach ($shifts as $shift) {
            $start = $shift->started_at;
            $end = $shift->ended_at ?? now();

            $ordersQuery = Order::where('user_id', $shift->user_id)
                ->whereBetween('created_at', [$start, $end]);

            $shift->orders_count = $ordersQuery->count();
            $shift->unique_customers = $ordersQuery->distinct('customer_id')->count('customer_id');
            $shift->expenses_total = Expense::where('user_id', $shift->user_id)
                ->whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
                ->sum('amount');
            $shift->payments_total = $shift->payments()->sum('amount');
        }

        return view('owner.shifts', compact('shifts'));
    }

    public function exportCsv(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403);
        }

        $shifts = Shift::with('user', 'payments')->orderBy('started_at', 'desc')->get();

        $filename = 'shifts_export_' . now()->format('Ymd_His') . '.csv';

        $columns = [
            'Shift ID',
            'Cashier',
            'Started At',
            'Ended At',
            'Gross Total',
            'Cash Total',
            'Non Cash Total',
            'Orders Count',
            'Unique Customers',
            'Expenses Total',
            'Payments Total',
            'Notes',
        ];

        $callback = function () use ($shifts, $columns) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, $columns);

            foreach ($shifts as $shift) {
                $start = $shift->started_at;
                $end = $shift->ended_at ?? now();

                $ordersQuery = Order::where('user_id', $shift->user_id)
                    ->whereBetween('created_at', [$start, $end]);

                $ordersCount = $ordersQuery->count();
                $uniqueCustomers = $ordersQuery->distinct('customer_id')->count('customer_id');

                $expensesTotal = Expense::where('user_id', $shift->user_id)
                    ->whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
                    ->sum('amount');

                $paymentsTotal = $shift->payments()->sum('amount');

                $row = [
                    $shift->id,
                    $shift->user->name ?? '-',
                    $start->toDateTimeString(),
                    $shift->ended_at ? $end->toDateTimeString() : '-',
                    $shift->gross_total,
                    $shift->cash_total,
                    $shift->non_cash_total,
                    $ordersCount,
                    $uniqueCustomers,
                    $expensesTotal,
                    $paymentsTotal,
                    $shift->notes ?? '',
                ];

                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403);
        }

        $shifts = Shift::with('user', 'payments')->orderBy('started_at', 'desc')->get();

        $filename = 'shifts_export_' . now()->format('Ymd_His') . '.xlsx';

        // Build data array
        $data = [];
        $data[] = [
            'Shift ID',
            'Cashier',
            'Started At',
            'Ended At',
            'Gross Total',
            'Cash Total',
            'Non Cash Total',
            'Orders Count',
            'Unique Customers',
            'Expenses Total',
            'Payments Total',
            'Notes',
        ];

        foreach ($shifts as $shift) {
            $start = $shift->started_at;
            $end = $shift->ended_at ?? now();

            $ordersQuery = Order::where('user_id', $shift->user_id)
                ->whereBetween('created_at', [$start, $end]);

            $ordersCount = $ordersQuery->count();
            $uniqueCustomers = $ordersQuery->distinct('customer_id')->count('customer_id');

            $expensesTotal = Expense::where('user_id', $shift->user_id)
                ->whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
                ->sum('amount');

            $paymentsTotal = $shift->payments()->sum('amount');

            $data[] = [
                $shift->id,
                $shift->user->name ?? '-',
                $start->toDateTimeString(),
                $shift->ended_at ? $end->toDateTimeString() : '-',
                $shift->gross_total,
                $shift->cash_total,
                $shift->non_cash_total,
                $ordersCount,
                $uniqueCustomers,
                $expensesTotal,
                $paymentsTotal,
                $shift->notes ?? '',
            ];
        }

        // Convert to XML Excel format (SpreadsheetML)
        $callback = function () use ($data) {
            echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">' . PHP_EOL;
            echo '<Worksheet ss:Name="Shifts">' . PHP_EOL;
            echo '<Table>' . PHP_EOL;

            foreach ($data as $row) {
                echo '<Row>' . PHP_EOL;
                foreach ($row as $cell) {
                    $value = htmlspecialchars($cell, ENT_QUOTES, 'UTF-8');
                    echo "<Cell><Data ss:Type=\"String\">$value</Data></Cell>" . PHP_EOL;
                }
                echo '</Row>' . PHP_EOL;
            }

            echo '</Table>' . PHP_EOL;
            echo '</Worksheet>' . PHP_EOL;
            echo '</Workbook>' . PHP_EOL;
        };

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream($callback, 200, $headers);
    }
}
