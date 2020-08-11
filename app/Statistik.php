<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistik extends Model
{
    
    protected $fillable   = ['ip','tanggal','hits','online','agents','referer'];
}
