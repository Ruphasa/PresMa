<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'm_prodi';
    protected $primaryKey = 'prodi_id';
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaModel::class, 'prodi_id');
    }
}
