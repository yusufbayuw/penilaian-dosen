<?php

namespace App\Observers;

use App\Models\User;
use App\Models\M005Mahasiswa;

class M005MahasiswaObserver
{
    /**
     * Handle the M005Mahasiswa "created" event.
     */
    public function created(M005Mahasiswa $m005Mahasiswa): void
    {
        $mahasiswa = User::firstOrCreate([
            "name" => $m005Mahasiswa->nama,
            "email" => $m005Mahasiswa->npm."@student.dev",
            "username" => $m005Mahasiswa->npm,
            "password" => $m005Mahasiswa->npm,
            "mahasiswa_id" => $m005Mahasiswa->id,
         ]);

         $mahasiswa->assignRole("mahasiswa");
    }

    /**
     * Handle the M005Mahasiswa "updated" event.
     */
    public function updated(M005Mahasiswa $m005Mahasiswa): void
    {
        //
    }

    /**
     * Handle the M005Mahasiswa "deleted" event.
     */
    public function deleted(M005Mahasiswa $m005Mahasiswa): void
    {
        //
    }

    /**
     * Handle the M005Mahasiswa "restored" event.
     */
    public function restored(M005Mahasiswa $m005Mahasiswa): void
    {
        //
    }

    /**
     * Handle the M005Mahasiswa "force deleted" event.
     */
    public function forceDeleted(M005Mahasiswa $m005Mahasiswa): void
    {
        //
    }
}
