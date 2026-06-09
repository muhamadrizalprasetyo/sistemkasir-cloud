<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('delivery_method', ['Drop Off', 'Pick Up & Delivery'])->default('Drop Off');
            $table->enum('payment_status', ['Unpaid', 'Paid'])->default('Unpaid');
            $table->enum('order_status', ['Antrian', 'Dicuci', 'Dikeringkan', 'Siap Diambil', 'Selesai'])->default('Antrian');
            $table->integer('total_amount')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
