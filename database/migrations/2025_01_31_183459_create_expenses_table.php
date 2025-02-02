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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('accountingCode');
            $table->string('account');
            $table->string('category');
            $table->string('subCategory');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('service');
            $table->string('description');
            $table->enum('type', ['active', 'passive']);
            $table->string('balance');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
