<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

