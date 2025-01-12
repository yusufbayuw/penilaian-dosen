<?php

namespace App\Observers;

use App\Models\M007KelasMahasiswa;
use App\Models\M008KelasDosen;
use App\Models\M009PenilaianDosen;

class M007KelasMahasiswaObserver
{
    /**
     * Handle the M007KelasMahasiswa "created" event.
     */
    public function created(M007KelasMahasiswa $m007KelasMahasiswa): void
    {
        $kelasDosenList = M008KelasDosen::where('kelas_id', $m007KelasMahasiswa->kelas_id)->get();

        if ($kelasDosenList) {
            foreach ($kelasDosenList as $kelasDosen) {
                M009PenilaianDosen::firstOrCreate([
                    'kelas_dosen_id' => $kelasDosen->id,
                    'kelas_mahasiswa_id' => $m007KelasMahasiswa->id,
                ]);
            }
        }
    }

    /**
     * Handle the M007KelasMahasiswa "updated" event.
     */
    public function updated(M007KelasMahasiswa $m007KelasMahasiswa): void
    {
        //
    }

    /**
     * Handle the M007KelasMahasiswa "deleted" event.
     */
    public function deleted(M007KelasMahasiswa $m007KelasMahasiswa): void
    {
        //
    }

    /**
     * Handle the M007KelasMahasiswa "restored" event.
     */
    public function restored(M007KelasMahasiswa $m007KelasMahasiswa): void
    {
        //
    }

    /**
     * Handle the M007KelasMahasiswa "force deleted" event.
     */
    public function forceDeleted(M007KelasMahasiswa $m007KelasMahasiswa): void
    {
        //
    }
}
