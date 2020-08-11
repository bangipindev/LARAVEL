<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable =['pekerjaan','slug','slugid','deskripsi','deskripsi_singkat','id_kategori','provinsi','kota','gaji','label','status','email','meta_deskripsi','meta_keyword','pendidikan','perusahaan','gambar','batas_waktu','hits','expired'];
    
}
