<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    protected $fillable = [
        'level_nama',
        'level_kode'
    ];

    public function user()
    {
        return $this->hasMany(UserModel::class, 'level_id');
    }
}
