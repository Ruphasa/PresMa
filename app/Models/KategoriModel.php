<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';
    protected $fillable = [
        'kategori_kode',
        'kategori_nama',
        'kategori_keterangan'
    ];

    public function lomba()
    {
        return $this->hasMany(CompetitionModel::class, 'kategori_id');
    }

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaModel::class, 'prefrensi_lomba', 'kategori_id');
    }
}
