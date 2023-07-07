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
        Schema::create('user_cryptos', function (Blueprint $table) {
            $table->id();
            $table->string('crypto_id');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('account_id')->constrained();
            $table->string('name');
            $table->string('symbol');
            $table->string('logo');
            $table->string('currency');
            $table->decimal('amount', 20, 10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cryptos');
    }
};
