<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {

            $table->string('ip_address');
            $table->string('ioflg');
            $table->boolean('approved');
            $table->string('description');
            $table->string('serialno')->nullable();
            $table->string('pushver')->nullable();
            $table->datetime('lastactivity')->nullable();
            $table->string('usercount')->nullable();
            $table->string('fingerCount')->nullable();
            $table->string('transactions')->nullable();
            $table->string('fpVersion')->nullable();
            $table->string('faceVersion')->nullable();
            $table->string('faceReg')->nullable();
            $table->string('faceCount')->nullable();
            $table->string('stamp')->nullable();
            $table->string('opstamp')->nullable();

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
        Schema::dropIfExists('terminals');
    }
}
