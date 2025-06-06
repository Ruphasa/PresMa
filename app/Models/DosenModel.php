<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    use HasFactory;

    protected $table = 'm_dosen';
    protected $primaryKey = 'nidn';

    protected $fillable = [
        'nidn',
        'user_id',
        'username',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaModel::class, 'dosen_id', 'nidn');
    }
}
