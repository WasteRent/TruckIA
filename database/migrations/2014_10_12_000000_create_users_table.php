<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'garage', 'fleet', 'customer']);
            $table->enum('job', ['mechanic', 'fleet_manager'])->nullable();
            $table->unsignedBigInteger('entity_relation_id')->nullable();
            $table->unsignedBigInteger('avatar_file_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id', 'entity_relation_id']);

            $table->foreign('avatar_file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
