<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTrialBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_trial_balances', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('account_number');
            $table->string('description');
            $table->double('amount');
            $table->double('balance');
            $table->date('transaction_date');
            $table->integer('transaction_by');
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
        Schema::dropIfExists('account_trial_balances');
    }
}
