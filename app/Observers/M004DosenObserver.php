<?php

namespace App\Observers;

use App\Models\M004Dosen;
use App\Models\User;

class M004DosenObserver
{
    /**
     * Handle the M004Dosen "created" event.
     */
    public function created(M004Dosen $m004Dosen): void
    {
        $dosen = User::firstOrCreate([
            "name" => $m004Dosen->nama,
            "email" => $m004Dosen->nidn."@lecturer.dev",
            "username" => $m004Dosen->nidn,
            "password" => $m004Dosen->nidn,
            "dosen_id" => $m004Dosen->id,
         ]);

         $dosen->assignRole('dosen');
    }

    /**
     * Handle the M004Dosen "updated" event.
     */
    public function updated(M004Dosen $m004Dosen): void
    {
        //
    }

    /**
     * Handle the M004Dosen "deleted" event.
     */
    public function deleted(M004Dosen $m004Dosen): void
    {
        //
    }

    /**
     * Handle the M004Dosen "restored" event.
     */
    public function restored(M004Dosen $m004Dosen): void
    {
        //
    }

    /**
     * Handle the M004Dosen "force deleted" event.
     */
    public function forceDeleted(M004Dosen $m004Dosen): void
    {
        //
    }
}
