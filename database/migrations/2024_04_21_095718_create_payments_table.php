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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('invoice_id');
            $table->double('payment_amount', 20, 2)->default(0);
            $table->double('paid', 20, 2)->default(0);
            $table->double('due', 20, 2)->default(0);
            $table->string('date');
            $table->string('month');
            $table->integer('year');
            $table->string('valid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
