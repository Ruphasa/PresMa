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
        'user_id',
        'lomba_tingkat',
        'lomba_tanggal',
        'lomba_nama',
        'lomba_detail',
        'status'
    ];
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
