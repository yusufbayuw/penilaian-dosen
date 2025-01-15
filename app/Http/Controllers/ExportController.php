<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function semester_export()
    {
        $semesterId = 2;

/*         $data = DB::select("
            SELECT 
                d.nama AS nama_dosen,
                mk.nama AS nama_mata_kuliah,
                k.nama AS nama_kelas,
                SUM(pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + 
                    pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + 
                    pd.q_11 + pd.q_12) AS total_nilai,
                COUNT(CASE WHEN pd.is_done = true THEN pd.id END) AS jumlah_penilaian,
                AVG((pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + 
                    pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + 
                    pd.q_11 + pd.q_12) / 12) AS rata_rata_nilai
            FROM 
                m006_kelas k
            JOIN 
                m002_semesters s ON k.semester_id = s.id AND s.id = :semester_id
            JOIN 
                m003_mata_kuliahs mk ON k.mata_kuliah_id = mk.id
            JOIN 
                m008_kelas_dosens kd ON kd.kelas_id = k.id
            JOIN 
                m004_dosens d ON kd.dosen_id = d.id
            JOIN 
                m007_kelas_mahasiswas km ON km.kelas_id = k.id
            JOIN 
                m009_penilaian_dosens pd ON pd.kelas_mahasiswa_id = km.id
            GROUP BY 
                d.nama, mk.nama, k.nama
            ORDER BY 
                d.nama, mk.nama, k.nama
        ", ['semester_id' => $semesterId]);
 */
        // Query untuk mengambil data penilaian berdasarkan semester
$query = "
SELECT 
    d.nama AS nama_dosen,
    mk.nama AS nama_mata_kuliah,
    k.nama AS nama_kelas,
    SUM(pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + pd.q_11 + pd.q_12) AS total_nilai,
    COUNT(CASE WHEN pd.is_done = 1 THEN 1 END) AS jumlah_penilai,
    CASE 
        WHEN COUNT(CASE WHEN pd.is_done = 1 THEN 1 END) > 0 THEN 
            SUM(pd.q_01 + pd.q_02 + pd.q_03 + pd.q_04 + pd.q_05 + pd.q_06 + pd.q_07 + pd.q_08 + pd.q_09 + pd.q_10 + pd.q_11 + pd.q_12) / 
            COUNT(CASE WHEN pd.is_done = 1 THEN 1 END)
        ELSE 0
    END AS rata_rata
FROM m009_penilaian_dosens pd
JOIN m008_kelas_dosens kd ON kd.id = pd.kelas_dosen_id
JOIN m006_kelas k ON k.id = kd.kelas_id
JOIN m004_dosens d ON d.id = kd.dosen_id
JOIN m003_mata_kuliahs mk ON mk.id = k.mata_kuliah_id
WHERE k.semester_id = :semesterId
GROUP BY d.id, mk.id, k.id
";

// Mengambil data berdasarkan semester
$data = DB::select($query, ['semesterId' => $semesterId]);

        return view('export.semester_export', ['data' => $data]);
    }
}
