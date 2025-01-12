<?php

namespace App\Observers;

use App\Models\M008KelasDosen;
use App\Models\M007KelasMahasiswa;
use App\Models\M009PenilaianDosen;

class M008KelasDosenObserver
{
    /**
     * Handle the M008KelasDosen "created" event.
     */
    public function created(M008KelasDosen $m008KelasDosen): void
    {
        $kelasMahasiswaList = M007KelasMahasiswa::where('kelas_id', $m008KelasDosen->kelas_id)->get();

        if ($kelasMahasiswaList) {
            foreach ($kelasMahasiswaList as $kelasMahasiswa) {
                M009PenilaianDosen::firstOrCreate([
                    'kelas_dosen_id' => $m008KelasDosen->id,
                    'kelas_mahasiswa_id' => $kelasMahasiswa->id,
                ]);
            }
        }
    }

    /**
     * Handle the M008KelasDosen "updated" event.
     */
    public function updated(M008KelasDosen $m008KelasDosen): void
    {
        //
    }

    /**
     * Handle the M008KelasDosen "deleted" event.
     */
    public function deleted(M008KelasDosen $m008KelasDosen): void
    {
        //
    }

    /**
     * Handle the M008KelasDosen "restored" event.
     */
    public function restored(M008KelasDosen $m008KelasDosen): void
    {
        //
    }

    /**
     * Handle the M008KelasDosen "force deleted" event.
     */
    public function forceDeleted(M008KelasDosen $m008KelasDosen): void
    {
        //
    }
}
