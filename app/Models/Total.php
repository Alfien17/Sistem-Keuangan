<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    protected $table = "total";
    protected $fillable = ['akun_id','kd_akun','total'];   
}
