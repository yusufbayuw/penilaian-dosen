<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class M001TahunAjaran extends Model
{
    public function semester(): HasMany
    {
        return $this->hasMany(M002Semester::class, 'tahun_ajaran_id');
    }
}
