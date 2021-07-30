<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\Illuminate\Support\Facades\Schema;
use SMTP2GOWPPlugin\Illuminate\Database\Schema\Blueprint;
use SMTP2GOWPPlugin\Illuminate\Database\Migrations\Migration;
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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
\class_alias('SMTP2GOWPPlugin\\CreateUsersTable', 'CreateUsersTable', \false);
