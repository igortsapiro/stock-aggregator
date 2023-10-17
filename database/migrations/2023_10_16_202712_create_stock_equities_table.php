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
        Schema::create('stock_equities', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->float('percentage_stage');
            $table->float('open');
            $table->float('high');
            $table->float('low');
            $table->float('close');
            $table->integer('volume');
            $table->timestamp('refreshed_at');

            $table->index('symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_equities');
    }
};
