<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A second, non-registered place of business (e.g. a German branch of a French-registered
 * company) to print on the Impressum below the registered head office. Distinct from
 * `registered_address` — legally that one stays the siège social — this is just an additional
 * address the business wants disclosed. Both columns are nullable; an empty branch_address
 * prints nothing, so existing installs are unaffected until filled in from /admin/reglages.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('branch_label')->nullable()->after('publication_director');
            $table->string('branch_address')->nullable()->after('branch_label');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['branch_label', 'branch_address']);
        });
    }
};
