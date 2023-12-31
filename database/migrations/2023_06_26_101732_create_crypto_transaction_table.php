<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('account_id')->constrained();
            $table->foreignId('user_crypto_id');
            $table->string('crypto_id');
            $table->enum('type', ['buy', 'sell']);
            $table->string('account_number');
            $table->string('currency');
            $table->string('crypto_name');
            $table->decimal('amount', 27, 18);
            $table->decimal('crypto_price', 27, 18);
            $table->decimal('total', 36, 18);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_transaction');
    }
};
