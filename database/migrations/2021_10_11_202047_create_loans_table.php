<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->default(0);
            $table->double('principal_amount')->default(0);
            $table->double('interest')->default(0);
            $table->double('daily_repayment_amount')->default(0);
            $table->double('weekly_repayment_amount')->default(0);
            $table->integer('duration')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('agent')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('loans');
    }
}
