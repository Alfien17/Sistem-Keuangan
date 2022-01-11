<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAkun extends Model
{
    protected $table = "kategori_akun";
    protected $fillable = ['akun', 'kode'];

    public function akun()
    {
        return $this->hasOne('App\Models\Akun');
    }
}
