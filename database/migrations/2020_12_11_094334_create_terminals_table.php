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
            $table->datetime('lastactivity')->nullable();

            $table->string('UserCount')->nullable();
            $table->string('FPCount')->nullable();
            $table->string('FaceCount')->nullable();

            $table->string('DeviceName')->nullable();
            $table->string('Platform')->nullable();
            $table->string('FWVersion')->nullable();
            $table->string('PushVersion')->nullable();
            $table->string('MAC')->nullable();
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
