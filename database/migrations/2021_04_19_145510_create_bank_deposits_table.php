<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_deposits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bank_account_id');
            $table->date('date_of_deposit');
            $table->string('mode_of_deposit');
            $table->string('deposited_by');
            $table->string('deposit_slip_number');
            $table->double('amount');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('bank_deposits');
    }
}
