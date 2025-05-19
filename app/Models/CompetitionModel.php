<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionModel extends Model
{
    use HasFactory;

    protected $table = 'm_lomba';

    protected $primaryKey = 'lomba_id';

    protected $fillable = [
        'kategori_id',
        'lomba_tingkat',
        'lomba_tanggal',
        'lomba_nama',
        'lomba_detail'
    ];
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }
}
