<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLombaModel extends Model
{
    use HasFactory;
    protected $table = 'm_kategori_lomba';
    protected $fillable = [
        'kl_kode',
        'kl_nama',
        'kl_keterangan'
    ];
    
    public function lomba()
    {
        return $this->hasMany(LombaModel::class, 'kategori_id');
    }
}
