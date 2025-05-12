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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_subcategory_id')->constrained('sub_subcategories', 'id')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('rates', 'id')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->double('price');
            $table->double('saleprice')->index();
            $table->string('availability');
            $table->integer('discount')->default(0);
            $table->integer('orders_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
