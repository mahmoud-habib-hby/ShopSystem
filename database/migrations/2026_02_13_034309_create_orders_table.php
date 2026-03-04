<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
$table->id();
$table->foreignId('customer_id')->constrained('users');
$table->foreignId('delivery_id')->nullable()->constrained('users');
$table->decimal('total_price', 10, 2);
$table->enum('status', ['pending','assigned','delivered','received'])->default('pending');
$table->enum('payment_status', ['unpaid','collected','settled'])->default('unpaid');
$table->text('address')->nullable();
$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
