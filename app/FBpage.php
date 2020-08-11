<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FBpage extends Model
{
    protected $fillable = ['applicationid','url','width','height','show_face','show_status','show_header_fb'];
}
