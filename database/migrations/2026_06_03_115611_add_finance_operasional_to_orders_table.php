<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah tipe data Enum menjadi String (Varchar) menggunakan raw query
        // Hal ini dilakukan agar tidak perlu me-require doctrine/dbal dan menghindari error.
        DB::statement("ALTER TABLE orders MODIFY payment_status VARCHAR(255) NOT NULL DEFAULT 'unpaid'");
        DB::statement("ALTER TABLE orders MODIFY order_status VARCHAR(255) NOT NULL DEFAULT 'Antrian'");

        // 2. Tambahkan kolom-kolom baru
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('total_amount');
            $table->integer('dp_amount')->default(0)->after('payment_method');
            $table->integer('discount_amount')->default(0)->after('dp_amount');
            $table->string('order_type')->default('drop')->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'dp_amount',
                'discount_amount',
                'order_type'
            ]);
        });

        // 3. Kembalikan kolom ke tipe Enum (opsional saat rollback)
        DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('Unpaid', 'Paid') NOT NULL DEFAULT 'Unpaid'");
        DB::statement("ALTER TABLE orders MODIFY order_status ENUM('Antrian', 'Dicuci', 'Dikeringkan', 'Siap Diambil', 'Selesai') NOT NULL DEFAULT 'Antrian'");
    }
};
