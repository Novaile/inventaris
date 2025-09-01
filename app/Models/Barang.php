<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang'; // bukan 'barangs' kalau kamu buat manual

    protected $fillable = [
        'nama',
        'stok',
        'kategori_id',
        'kode_barang',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    protected static function boot()
{
    parent::boot();

    static::saving(function ($model) {
        if ($model->stok < 0) {
            throw new \Exception('Stok tidak boleh kurang dari 0');
        }
    });
}
}

