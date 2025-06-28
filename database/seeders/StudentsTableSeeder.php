<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Student;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        Student::truncate();
        $file = database_path('data/diem_thi_thpt_2024.csv');
        if (!file_exists($file)) {
            $this->command->error('CSV file not found!');
            return;
        }
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);
        $batch = [];
        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            $batch[] = [
                'sbd' => $data['sbd'],
                'toan' => $data['toan'] !== '' ? $data['toan'] : null,
                'ngu_van' => $data['ngu_van'] !== '' ? $data['ngu_van'] : null,
                'ngoai_ngu' => $data['ngoai_ngu'] !== '' ? $data['ngoai_ngu'] : null,
                'vat_li' => $data['vat_li'] !== '' ? $data['vat_li'] : null,
                'hoa_hoc' => $data['hoa_hoc'] !== '' ? $data['hoa_hoc'] : null,
                'sinh_hoc' => $data['sinh_hoc'] !== '' ? $data['sinh_hoc'] : null,
                'lich_su' => $data['lich_su'] !== '' ? $data['lich_su'] : null,
                'dia_li' => $data['dia_li'] !== '' ? $data['dia_li'] : null,
                'gdcd' => $data['gdcd'] !== '' ? $data['gdcd'] : null,
                'ma_ngoai_ngu' => $data['ma_ngoai_ngu'] !== '' ? $data['ma_ngoai_ngu'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($batch) >= 1000) {
                DB::table('students')->insert($batch);
                $batch = [];
            }
        }
        if (count($batch)) {
            DB::table('students')->insert($batch);
        }
        fclose($handle);
    }
}
