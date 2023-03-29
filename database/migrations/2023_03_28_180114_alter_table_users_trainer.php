<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersTrainer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('personal_image',[0,1])->default(0)->nullable();
            $table->enum('national_image',[0,1])->default(0)->nullable();
            $table->enum('birth_certificate',[0,1])->default(0)->nullable();
            $table->enum('degree_certificate',[0,1])->default(0)->nullable();
            $table->enum('army_certificate',[0,1])->default(0)->nullable();
            $table->enum('feish',[0,1])->default(0)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
