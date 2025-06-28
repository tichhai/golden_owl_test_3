<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

// API tra cứu điểm theo số báo danh
Route::get('/api/search', [StudentController::class, 'search']);
// API thống kê số lượng học sinh theo 4 mức điểm cho từng môn
Route::get('/api/subject-stats', [StudentController::class, 'subjectStats']);
// API top 10 học sinh khối A
Route::get('/api/top-a', [StudentController::class, 'topA']);
// API báo cáo phân loại học sinh
Route::get('/api/report', [StudentController::class, 'report']);
