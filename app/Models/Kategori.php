<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori'; // pastikan ini bukan 'kategoris' atau lainnya

    protected $fillable = ['nama'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
