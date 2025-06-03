<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa';

protected $primaryKey = 'nim';
public $incrementing = false; // Memberitahu Laravel bahwa primary key tidak auto-incrementing
// protected $keyType = 'int'; // Tidak perlu jika default int sudah benar

    protected $fillable = [
        'nim',
        'user_id',
        'prodi_id',
        'dosen_id',
        'ipk',
        'prefrensi_lomba',
        'angkatan',
    ];
    public function prestasi()
    {
        return $this->hasMany(AchievementModel::class, 'nim');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id');
    }
    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'dosen_id', 'nidn');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'prefrensi_lomba', 'kategori_id');
    }
}
