<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Transaction', function (Blueprint $table) {
            $table->string('transactionId', 50)->primary();
            $table->timestamps();
            $table->Integer('productId');
            $table->Integer('userId');
            $table->float('price', 10, 2);
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transaction');
    }
}
