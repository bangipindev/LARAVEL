<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $primary_key  = 'id_kabkota';
    protected $fillable     =['id_propinsi','nama_kabkota'];

    public function province() {
        return $this->belongsTo('App\Province');
    }
    public function job()
    {
        return $this->hasMany('App\Job');
    }
}
