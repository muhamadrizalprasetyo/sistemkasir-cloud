<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $order->invoice_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
            font-size: 12px;
            width: 300px;
            color: #000;
        }

        .container {
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .item-row {
            margin: 3px 0;
        }

        .highlight {
            background: #f0f0f0;
            padding: 4px;
            margin: 3px 0;
        }

        @media print {
            body {
                width: auto;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>LUXESOLE</h1>
            <p>Premium Shoe Care</p>
            <p>========================</p>
        </div>

        <div class="flex">
            <span>No:</span>
            <span>{{ $order->invoice_number }}</span>
        </div>
        <div class="flex">
            <span>Tgl:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex">
            <span>Kasir:</span>
            <span>{{ substr($order->user->name, 0, 12) }}</span>
        </div>
        <div class="flex">
            <span>Pelanggan:</span>
            <span>{{ substr($order->customer->name, 0, 14) }}</span>
        </div>
        <div class="flex">
            <span>WA:</span>
            <span>{{ $order->customer->phone ?? '-' }}</span>
        </div>
        <div class="flex">
            <span>Tipe:</span>
            <span>{{ strtoupper($order->order_type ?? 'DROP') }}</span>
        </div>
        <div class="flex">
            <span>Metode:</span>
            <span>{{ strtoupper($order->payment_method ?? 'CASH') }}</span>
        </div>

        <div class="divider"></div>
        <div class="bold">RINCIAN LAYANAN</div>
        <div class="divider"></div>

        @foreach($order->orderDetails as $detail)
            <div class="item-row">
                <div>{{ $detail->quantity }}x {{ $detail->service->name }}</div>
                <div class="flex">
                    <span>&nbsp;&nbsp;- {{ substr($detail->item_variant, 0, 14) }}</span>
                    <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <div class="divider"></div>

        @php
            // Subtotal sebelum diskon = total_amount + discount_amount
            $subtotalBefore = $order->total_amount + $order->discount_amount;
            // Grand total setelah diskon = total_amount (sudah disimpan di DB)
            $grandTotal = $order->total_amount;
            // Pembayaran dari tabel payments
            $dpBayar = $order->payments->where('type', 'dp')->sum('amount');
            $pelunasanBayar = $order->payments->where('type', 'pelunasan')->sum('amount');
            $totalDibayar = $dpBayar + $pelunasanBayar;
            $sisaTagihan = max(0, $grandTotal - $totalDibayar);
        @endphp

        @if($order->discount_amount > 0)
            <div class="flex">
                <span>Subtotal:</span>
                <span>Rp{{ number_format($subtotalBefore, 0, ',', '.') }}</span>
            </div>
            <div class="flex">
                <span>Diskon:</span>
                <span>-Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
            </div>
        @endif

        <div class="flex bold highlight" style="font-size: 14px;">
            <span>TOTAL TAGIHAN:</span>
            <span>Rp{{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>

        <div class="divider"></div>

        {{-- Bagian Pembayaran --}}
        <div class="flex pb-1">
            <span>DP / Bayar Awal:</span>
            <span>Rp{{ number_format($dpBayar, 0, ',', '.') }}</span>
        </div>

        @if($pelunasanBayar > 0)
            <div class="flex pb-1">
                <span>Pelunasan:</span>
                <span>Rp{{ number_format($pelunasanBayar, 0, ',', '.') }}</span>
            </div>
        @endif

        <div class="flex pb-1">
            <span>Total Dibayar:</span>
            <span>Rp{{ number_format($totalDibayar, 0, ',', '.') }}</span>
        </div>

        @if($order->cash_received > 0)
            <div class="flex pb-1">
                <span>Uang Diterima:</span>
                <span>Rp{{ number_format($order->cash_received, 0, ',', '.') }}</span>
            </div>
            @if($order->change_amount > 0)
                <div class="flex bold pb-1">
                    <span>Kembalian:</span>
                    <span>Rp{{ number_format($order->change_amount, 0, ',', '.') }}</span>
                </div>
            @endif
        @endif

        <div class="divider"></div>

        <div class="flex bold highlight">
            <span>SISA TAGIHAN:</span>
            <span>Rp{{ number_format($sisaTagihan, 0, ',', '.') }}</span>
        </div>
        <div class="flex bold pb-1">
            <span>STATUS BAYAR:</span>
            <span>{{ strtoupper($order->payment_status) }}</span>
        </div>

        <div class="divider"></div>
        <div class="text-center" style="margin-top: 12px;">
            @if($sisaTagihan > 0)
                <p class="bold">** HARAP LUNASI SAAT PENGAMBILAN **</p>
                <p>Sisa: Rp{{ number_format($sisaTagihan, 0, ',', '.') }}</p>
                <div class="divider"></div>
            @endif
            <p>Terima kasih telah mempercayakan</p>
            <p>perawatan koleksi Anda kepada kami.</p>
            <p class="bold" style="margin-top: 5px;">*Simpan struk ini untuk pengambilan*</p>
        </div>
    </div>
</body>

</html>