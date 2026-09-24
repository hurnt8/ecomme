<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Legal identity of the operating business, as registered at the RNE.
 *
 * These belong on the settings row rather than in the Blade templates: the mentions légales,
 * the CGV and the invoice footer are all legally required to carry them, and all three already
 * read their identity from $settings. Hard-coding them in one view would have left the other
 * two silently wrong.
 *
 * All columns are nullable so an existing install keeps working until the values are filled in
 * from /admin/reglages — an empty SIREN prints nothing rather than an empty label.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('legal_name')->nullable()->after('site_name');
            $table->string('legal_form')->nullable()->after('legal_name');
            $table->string('siren', 20)->nullable()->after('legal_form');
            $table->string('siret', 20)->nullable()->after('siren');
            $table->string('vat_number', 20)->nullable()->after('siret');
            $table->string('naf_code', 10)->nullable()->after('vat_number');
            $table->string('naf_label')->nullable()->after('naf_code');
            $table->string('registered_address')->nullable()->after('naf_label');
            $table->string('publication_director')->nullable()->after('registered_address');
            $table->string('host_details')->nullable()->after('publication_director');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'legal_name',
                'legal_form',
                'siren',
                'siret',
                'vat_number',
                'naf_code',
                'naf_label',
                'registered_address',
                'publication_director',
                'host_details',
            ]);
        });
    }
};
