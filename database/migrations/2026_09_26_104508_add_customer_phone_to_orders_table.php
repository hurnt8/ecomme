<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A phone number to reach the customer, collected at checkout step 2 (shipping address)
 * alongside the rest of the delivery details — needed for the carrier to call ahead before
 * delivering firewood or heavy machinery. Nullable so existing orders placed before this
 * column existed keep rendering without one.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_phone')->nullable()->after('customer_email');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('customer_phone');
        });
    }
};
