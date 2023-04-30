<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('type_of_amount', ['part', 'full'])->default('full')->nullable();

            $table->date('date_receipt');


            $table->integer('from');
            $table->integer('to');
            $table->string('type_of_from');
            $table->integer('amount');
            $table->integer('paid')->nullable();
            $table->longText('statement')->nullable();



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
        Schema::dropIfExists('receipts');
    }
}
