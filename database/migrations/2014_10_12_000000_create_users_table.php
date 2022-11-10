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
            $table->id();
            $table->string('uuid', 50)->nullable();
            $table->boolean('suspended')->default(0);
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('email', 50)->unique();
            $table->string('phone', 30)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->string('city', 30)->nullable();
            $table->string('state', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('pics', 50)->nullable();
            $table->string('files', 200)->nullable();
            $table->string('verified')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index(['uuid', 'email', 'phone', 'password', 'city', 'state', 'suspended']);
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
