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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('PlaceIssue')->nullable();
            $table->string('order')->nullable();
            $table->string('bill_order')->nullable();
            $table->date('date');
            $table->enum('typeDelivery', ['home', 'p2p', 'other']);
            $table->enum('typePayment', ['cash', 'creditCard', 'debitCard', 'transfer', 'payMovil']);
            $table->string('bank')->nullable();
            $table->string('deliveryNote')->nullable();
            $table->date('deliveryDate')->nullable();
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('amount')->nullable();
            $table->string('amount_bs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
