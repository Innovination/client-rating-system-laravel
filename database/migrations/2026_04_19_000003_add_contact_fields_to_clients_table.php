<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('website');
            $table->string('address')->nullable()->after('phone');
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete()->after('address');
            $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete()->after('country_id');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete()->after('state_id');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Country::class);
            $table->dropForeignIdFor(\App\Models\State::class);
            $table->dropForeignIdFor(\App\Models\City::class);
            $table->dropColumn(['phone', 'address', 'country_id', 'state_id', 'city_id']);
        });
    }
};
