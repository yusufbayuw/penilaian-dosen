<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M003MataKuliah extends Model
{
    public function kelas(): HasMany
    {
        return $this->hasMany(M006Kelas::class, 'mata_kuliah_id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(M010Prodi::class, 'prodi_id');
    }
}
