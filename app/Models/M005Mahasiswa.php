<?php

namespace App\Models;

use App\Observers\M005MahasiswaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(M005MahasiswaObserver::class)]
class M005Mahasiswa extends Model
{
    public function kelas_mahasiswa(): HasMany
    {
        return $this->hasMany(M007KelasMahasiswa::class, 'mahasiswa_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'mahasiswa_id');
    }
}
