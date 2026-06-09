<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'stamp_count')) {
                $table->integer('stamp_count')->default(0)->after('address');
            }
            if (!Schema::hasColumn('customers', 'total_rewards_claimed')) {
                $table->integer('total_rewards_claimed')->default(0)->after('stamp_count');
            }
            if (!Schema::hasColumn('customers', 'membership_type')) {
                $table->string('membership_type')->default('regular')->after('total_rewards_claimed');
            }
            if (!Schema::hasColumn('customers', 'member_code')) {
                $table->string('member_code')->unique()->nullable()->after('membership_type');
            }
            if (!Schema::hasColumn('customers', 'member_joined_at')) {
                $table->timestamp('member_joined_at')->nullable()->after('member_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['stamp_count', 'total_rewards_claimed', 'membership_type', 'member_code', 'member_joined_at']);
        });
    }
};
