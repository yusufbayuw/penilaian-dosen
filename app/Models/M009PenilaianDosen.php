<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M009PenilaianDosen extends Model
{
    public function kelas_dosen(): BelongsTo
    {
        return $this->belongsTo(M008KelasDosen::class, 'kelas_dosen_id');
    }

    public function kelas_mahasiswa(): BelongsTo
    {
        return $this->belongsTo(M007KelasMahasiswa::class, 'kelas_mahasiswa_id');
    }
}
