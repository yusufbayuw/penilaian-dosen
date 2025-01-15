<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M006Kelas extends Model
{
    public function kelas_mahasiswa(): HasMany
    {
        return $this->hasMany(M007KelasMahasiswa::class, 'kelas_id');
    }

    public function kelas_dosen(): HasMany
    {
        return $this->hasMany(M008KelasDosen::class, 'kelas_id');
    }

    public function mata_kuliah(): BelongsTo
    {
        return $this->belongsTo(M003MataKuliah::class, 'mata_kuliah_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(M002Semester::class, 'semester_id');
    }
}
