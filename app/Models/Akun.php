<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = "akun";
    protected $fillable = ['nama_akun', 'kd_akun'];

    public function keuangan()
    {
        return $this->hasMany('App\Models\Keuangan');
    }
    
}
