<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pekerjaan',255);
            $table->string('slug',255);
            $table->string('slugid',255);
            $table->text('deskripsi')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->string('id_kategori')->nullable();
            $table->tinyInteger('provinsi')->nullable();
            $table->mediumInteger('kota')->nullable();
            $table->float('gaji',10);
            $table->boolean('label')->default(true);
            $table->boolean('status')->default(true);
            $table->string('email',255)->nullable();
            $table->text('meta_deskripsi')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('pendidikan',255)->nullable();
            $table->string('gambar',255)->nullable();
            $table->string('perusahaan',255)->nullable();
            $table->date('batas_waktu')->nullable();
            $table->bigInteger('hits')->default(false);
            $table->boolean('expired')->default(false);
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
        Schema::dropIfExists('jobs');
    }
}
