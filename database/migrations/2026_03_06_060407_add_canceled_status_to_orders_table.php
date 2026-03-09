<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // تغيير enum ليضيف 'canceled'
            $table->enum('status', ['pending','assigned','delivered','received','canceled'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // الرجوع للوضع السابق بدون 'canceled'
            $table->enum('status', ['pending','assigned','delivered','received'])
                  ->default('pending')
                  ->change();
        });
    }
};