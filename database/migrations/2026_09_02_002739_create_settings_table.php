<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Sillon & Bûche');
            $table->string('logo')->nullable();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_twitter')->nullable();
            $table->decimal('tax_rate', 5, 4)->default(0.2);
            $table->decimal('free_shipping_threshold', 10, 2)->default(50);
            $table->decimal('international_shipping_fee', 8, 2)->default(15);
            $table->string('currency', 3)->default('EUR');
            $table->timestamp('sale_ends_at')->nullable();
            $table->string('announcement_text')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('bank_bic')->nullable();
            $table->boolean('notify_new_orders')->default(true);
            $table->string('notification_email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
