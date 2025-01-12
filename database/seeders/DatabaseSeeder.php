<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\M004Dosen;
use App\Models\M006Kelas;
use App\Models\M002Semester;
use App\Models\M005Mahasiswa;
use App\Models\M003MataKuliah;
use App\Models\M008KelasDosen;
use App\Models\M001TahunAjaran;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\M007KelasMahasiswa;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $roles = ["staf_tu", "mahasiswa", "dosen"];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }

        M001TahunAjaran::create([
            "tahun" => "2025/2026",
        ]);

        M002Semester::create([
            "tahun_ajaran_id" => 1,
            "nama" => "Semester I",
            "kode" => "202501",
            "aktif" => true,
            "penilaian" => true,
        ]);

        M003MataKuliah::create([
            "nama" => "Pengantar Kriptografi",
            "kode" => "IF01001",
            "SKS" => "2",
            "aktif" => true,
        ]);

        M004Dosen::create([
            "nidn" => "2020001",
            "nama" => "Dr. Lorem Ipsum",
            "aktif" => true,
        ]);

        M004Dosen::create([
            "nidn" => "2020002",
            "nama" => "Dr. Happy Valentine",
            "aktif" => true,
        ]);

        M005Mahasiswa::create([
            "npm" => "2501001",
            "nama" => "Dolor Amet",
            "aktif" => true,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501002",
            "nama" => "Lorem Ipsum",
            "aktif" => true,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501003",
            "nama" => "Consectetur Elit",
            "aktif" => false,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501004",
            "nama" => "Adipiscing Veniam",
            "aktif" => true,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501005",
            "nama" => "Tempor Incididunt",
            "aktif" => false,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501006",
            "nama" => "Labore Dolore",
            "aktif" => true,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501007",
            "nama" => "Magna Aliqua",
            "aktif" => true,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501008",
            "nama" => "Ut Enim",
            "aktif" => false,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501009",
            "nama" => "Minim Veniam",
            "aktif" => true,
        ]);
        
        M005Mahasiswa::create([
            "npm" => "2501010",
            "nama" => "Nostrud Exercitation",
            "aktif" => false,
        ]);

        M006Kelas::create([
            "nama" => "Pengantar Kriptografi - 2025",
            "kode" => "25001",
            "semester_id" => 1,
            "mata_kuliah_id" => 1,
        ]);

        M008KelasDosen::create([
            "kelas_id" => 1,
            "dosen_id" => 1,
        ]);

        M008KelasDosen::create([
            "kelas_id" => 1,
            "dosen_id" => 2,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 1,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 2,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 3,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 4,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 5,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 6,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 7,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 8,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 9,
        ]);

        M007KelasMahasiswa::create([
            "kelas_id" => 1,
            "mahasiswa_id" => 10,
        ]);
    }
}
