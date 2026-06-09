<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('address')->nullable();

            // Loyalty Fields
            $table->integer('stamp_count')->default(0);
            $table->integer('total_rewards_claimed')->default(0);

            // Membership Fields
            $table->enum('membership_type', ['regular', 'more_running_club'])->default('regular');
            $table->string('member_code')->unique()->nullable();
            $table->timestamp('member_joined_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
