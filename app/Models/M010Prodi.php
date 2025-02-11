<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class M010Prodi extends Model
{
    public function mata_kuliah(): HasMany
    {
        return $this->hasMany(M003MataKuliah::class, 'prodi_id');
    }
}
