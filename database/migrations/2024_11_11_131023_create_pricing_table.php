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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->foreignId('account_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->double('price')->default(0);
            $table->unique(['product_id', 'account_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_prices', function (Blueprint $table) {
            //
        });
    }
};
