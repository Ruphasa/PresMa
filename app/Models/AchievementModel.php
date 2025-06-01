<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementModel extends Model
{
    use HasFactory;

    protected $table = 't_prestasi';

    protected $primaryKey = 'prestasi_id';
    protected $fillable = [
        'lomba_id',
        'mahasiswa_id',
        'tingkat_prestasi',
        'juara_ke',
        'status'
    ];
    public function lomba()
    {
        return $this->belongsTo(CompetitionModel::class, 'lomba_id');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'nim');
    }
}
