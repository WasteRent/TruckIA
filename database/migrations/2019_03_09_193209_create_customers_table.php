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
            $table->unsignedBigInteger('fleet_id');
            $table->unsignedBigInteger('enterprise_group_id');
            $table->string('name');
            $table->string('cif');
            $table->string('notifications_email')->nullable();
            $table->string('contact1')->nullable();
            $table->string('email1')->nullable();
            $table->string('phone1')->nullable();
            $table->string('contact2')->nullable();
            $table->string('email2')->nullable();
            $table->string('phone2')->nullable();
            $table->string('contact3')->nullable();
            $table->string('email3')->nullable();
            $table->string('phone3')->nullable();
            $table->string('contact4')->nullable();
            $table->string('email4')->nullable();
            $table->string('phone4')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('enterprise_group_id')->references('id')->on('enterprise_groups');
            $table->foreign('fleet_id')->references('id')->on('fleets');
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
