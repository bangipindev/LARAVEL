<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFBpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_bpages', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('applicationid');
            $table->string('url');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->boolean('show_face')->default(false);
            $table->boolean('show_status')->default(false);
            $table->boolean('show_header_fb')->default(false);
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
        Schema::dropIfExists('f_bpages');
    }
}
