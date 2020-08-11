<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable =['judul','deskripsi','gambar','link','textlink','status','posisi','tipe'];
}
