<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankModel extends Model
{
    use HasFactory;
    protected $table = 'rank'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key tabel
    protected $fillable = [
        'rank', // Nama juara
        'point', // Poin yang diberikan untuk juara tersebut
    ];
    public $timestamps = true; // Menggunakan timestamps untuk created_at dan updated_at
    protected $casts = [
        'point' => 'integer', // Cast point to integer
    ];
    public function achievements()
    {
        return $this->hasMany(AchievementModel::class, 'juara_ke', 'id');
    }
    public function competitions()
    {
        return $this->hasMany(CompetitionModel::class, 'juara_ke', 'id');
    }
}
