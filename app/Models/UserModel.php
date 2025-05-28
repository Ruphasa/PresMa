<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'nama',
        'password',
        'level_id',
        'email',
        'img'
    ];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    public function mahasiswa()
    {
        return $this->hasOne(MahasiswaModel::class, 'user_id');
    }
    public function dosen()
    {
        return $this->hasOne(DosenModel::class, 'user_id');
    }
    public function admin()
    {
        return $this->hasOne(AdminModel::class, 'user_id');
    }

    public function getRoleName(): string {
        return $this->level->level_nama;
    }

    public function hasRole($role):bool {
        return $this->level->level_kode == $role;
    }
}
