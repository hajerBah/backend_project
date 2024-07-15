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
        Schema::create('category_supplier', function (Blueprint $table) {
            $table->foreignUuid('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignUuid('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->primary(['supplier_id', 'category_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_supplier');
    }
};
