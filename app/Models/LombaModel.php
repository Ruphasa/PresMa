<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LombaModel extends Model
{
    use HasFactory;

    protected $table = 'lomba';
    protected $fillable = [
        'kategori_id',
        'lomba_tingkat',
        'lomba_tanggal',
        'lomba_nama',
        'lomba_detail'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLombaModel::class, 'kategori_id');
    }
}
