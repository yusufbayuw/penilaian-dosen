<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\M008KelasDosenObserver;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([M008KelasDosenObserver::class])]
class M008KelasDosen extends Model
{
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(M004Dosen::class, 'dosen_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(M006Kelas::class, 'kelas_id');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(M009PenilaianDosen::class, 'kelas_dosen_id');
    }
}
