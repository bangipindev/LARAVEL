<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['blogid','komentarid','username','email','komentar','disetujui','status','dibaca'];
}
