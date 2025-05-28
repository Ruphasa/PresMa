<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiModel extends Model
{
    use HasFactory;

    protected $table = 't_rekomendasi';
    protected $primaryKey = 'rekomendasi_id';
    protected $fillable = [
        'lomba_id',
        'nim',
    ];

    public function lomba()
    {
        return $this->belongsTo(CompetitionModel::class, 'lomba_id', 'lomba_id');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }
}
