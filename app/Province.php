<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $primary_key = 'id_propinsi';
    protected $fillable     =['id_propinsi','nama_propinsi'];

    public function city(){
        return $this->hasMany('App\City');
    }
}
