<?php

use App\Enums\ProductStatus;
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
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('name');
            $table->string('sku')->unique()->index();
            $table->string('barcode')->unique()->nullable();
            $table->longText('description')->nullable();
            $table->date('published_at')->nullable();
            $table->enum('status', array_column(ProductStatus::cases(), 'value'))->default(ProductStatus::PENDING->value);
            $table->double('price')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
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
