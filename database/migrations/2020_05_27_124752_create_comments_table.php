<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('blogid')->unsigned()->default(false);
            $table->integer('komentarid')->default(false);
            $table->string('username');
            $table->string('email');
            $table->text('komentar');
            $table->boolean('disetujui')->unsigned()->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('dibaca')->default(false);
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
        Schema::dropIfExists('comments');
    }
}
