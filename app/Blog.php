<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['judul','slug','kategori','konten','penulis','status','gambar','tag','meta_deksripsi','meta_keyword'];
}
