<?php

namespace App\Http\Controllers;

use App\exports\StudentExports;
use App\exports\TeacherExports;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function export(Request $request)
    {
        if ($request->type == 'student'){
            return Excel::download(new StudentExports($request->year),date('Y').'-students.xlsx');
        }elseif ($request->type == 'teacher'){
            return Excel::download(new TeacherExports($request->year),date('Y').'-teachers.xlsx');
        }
    }
}
