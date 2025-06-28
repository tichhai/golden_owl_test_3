<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // Tra cứu điểm theo số báo danh
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sbd' => 'required|string|exists:students,sbd',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        $student = Student::where('sbd', $request->sbd)->first();
        return response()->json($student);
    }

    // Thống kê số lượng học sinh theo 4 mức điểm cho từng môn
    public function subjectStats()
    {
        $subjects = ['toan','ngu_van','ngoai_ngu','vat_li','hoa_hoc','sinh_hoc','lich_su','dia_li','gdcd'];
        $levels = [
            '>=8' => [8, 10],
            '6-8' => [6, 8],
            '4-6' => [4, 6],
            '<4' => [0, 4],
        ];
        $result = [];
        foreach ($subjects as $subject) {
            $data = [];
            foreach ($levels as $label => [$min, $max]) {
                if ($label === '>=8') {
                    $count = DB::table('students')->where($subject, '>=', 8)->count();
                } elseif ($label === '<4') {
                    $count = DB::table('students')->where($subject, '<', 4)->count();
                } else {
                    $count = DB::table('students')->where($subject, '>=', $min)->where($subject, '<', $max)->count();
                }
                $data[$label] = $count;
            }
            $result[$subject] = $data;
        }
        return response()->json($result);
    }

    // Top 10 học sinh khối A (Toán, Lý, Hóa)
    public function topA()
    {
        $students = DB::table('students')
            ->select('sbd', 'toan', 'vat_li', 'hoa_hoc',
                DB::raw('COALESCE(toan,0)+COALESCE(vat_li,0)+COALESCE(hoa_hoc,0) as total_a'))
            ->whereNotNull('toan')
            ->whereNotNull('vat_li')
            ->whereNotNull('hoa_hoc')
            ->orderByDesc('total_a')
            ->limit(10)
            ->get();
        return response()->json($students);
    }

    // Báo cáo phân loại học sinh theo 4 mức điểm (tổng điểm các môn)
    public function report()
    {
        $result = [
            '>=8' => 0,
            '6-8' => 0,
            '4-6' => 0,
            '<4' => 0,
        ];
        DB::table('students')->select(
            DB::raw('COALESCE(toan,0)+COALESCE(ngu_van,0)+COALESCE(ngoai_ngu,0)+COALESCE(vat_li,0)+COALESCE(hoa_hoc,0)+COALESCE(sinh_hoc,0)+COALESCE(lich_su,0)+COALESCE(dia_li,0)+COALESCE(gdcd,0) as total')
        )->orderBy('sbd')->chunk(1000, function($students) use (&$result) {
            foreach ($students as $s) {
                $total = $s->total;
                if ($total >= 8) $result['>=8']++;
                elseif ($total >= 6) $result['6-8']++;
                elseif ($total >= 4) $result['4-6']++;
                else $result['<4']++;
            }
        });
        return response()->json($result);
    }
}
