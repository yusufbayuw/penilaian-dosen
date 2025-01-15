<?php

namespace App\Models;

use App\Observers\M007KelasMahasiswaObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([M007KelasMahasiswaObserver::class])]
class M007KelasMahasiswa extends Model
{
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(M005Mahasiswa::class, 'mahasiswa_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(M006Kelas::class, 'kelas_id');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(M009PenilaianDosen::class, 'kelas_mahasiswa_id');
    }
}
