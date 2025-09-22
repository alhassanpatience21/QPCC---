<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->string('first_name');
            $table->string('other_names')->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number_one')->nullable();
            $table->string('phone_number_two')->nullable();
            $table->string('house_number')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('gps')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('landmark')->nullable();
            $table->string('employer')->nullable();
            $table->string('photo')->nullable();
            $table->string('fullname_of_next_of_kin')->nullable();
            $table->string('phone_number_of_next_of_kin')->nullable();
            $table->double('payment_amount')->nullable();
            $table->boolean('sms_option')->default(0);
            $table->boolean('susu_account')->default(0);
            $table->boolean('savings_account')->default(0);
            $table->date('registration_date');
            $table->bigInteger('registered_by');
            $table->softDeletes();
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
        Schema::dropIfExists('accounts');
    }
}
