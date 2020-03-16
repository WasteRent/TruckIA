<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');

            $table->string('contact1');
            $table->string('email1');
            $table->string('phone1');
            $table->string('contact2')->nullable();
            $table->string('email2')->nullable();
            $table->string('phone2')->nullable();
            $table->string('contact3')->nullable();
            $table->string('email3')->nullable();
            $table->string('phone3')->nullable();
            $table->string('contact4')->nullable();
            $table->string('email4')->nullable();
            $table->string('phone4')->nullable();

            $table->string('address');
            $table->string('state')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
