<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
                        $table->string('checkoutid');

            $table->string('transaction_id');
            $table->string('transaction_code')->nullable();
            $table->string('merchant_code')->nullable();
            $table->float('amount')->nullable();
            $table->string('vat_amount')->nullable();
            $table->string('tip_amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('timestamp')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('entry_mode')->nullable();
            $table->string('installments_count')->nullable();
            $table->string('internal_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
