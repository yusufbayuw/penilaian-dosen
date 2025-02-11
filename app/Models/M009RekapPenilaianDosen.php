<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M009RekapPenilaianDosen extends Model
{
    protected $table = 'm002_semesters';

    public function tahun_ajaran(): BelongsTo
    {
        return $this->belongsTo(M001TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(M006Kelas::class, 'semester_id');
    }
}
