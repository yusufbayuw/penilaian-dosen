<?php

namespace App\Models;

use App\Observers\M004DosenObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(M004DosenObserver::class)]
class M004Dosen extends Model
{
    public function kelas_dosen(): HasMany
    {
        return $this->hasMany(M008KelasDosen::class, 'dosen_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'dosen_id');
    }
}
