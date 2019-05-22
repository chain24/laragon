<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Exam;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\Syllabus;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (Auth::user()->role == 'master'){
            //管理员用户登录
            return view('master-home');
        }else{
            $minutes = 1440;// 24 hours = 1440 minutes
            $school_id = \Auth::user()->school->id;
            $classes = \Cache::remember('classes-'.$school_id, $minutes, function () use($school_id) {
                return Myclass::bySchool($school_id)
                    ->pluck('id')
                    ->toArray();
            });
            $totalStudents = \Cache::remember('totalStudents-'.$school_id, $minutes, function () use($school_id) {
                return User::bySchool($school_id)
                    ->where('role','student')
                    ->where('active', 1)
                    ->count();
            });
            $totalTeachers = \Cache::remember('totalTeachers-'.$school_id, $minutes, function () use($school_id) {
                return User::bySchool($school_id)
                    ->where('role','teacher')
                    ->where('active', 1)
                    ->count();
            });
            $totalBooks = \Cache::remember('totalBooks-'.$school_id, $minutes, function () use($school_id) {
                return Book::bySchool($school_id)->count();
            });
            $totalClasses = \Cache::remember('totalClasses-'.$school_id, $minutes, function () use($school_id) {
                return Myclass::bySchool($school_id)->count();
            });
            $totalSections = \Cache::remember('totalSections-'.$school_id, $minutes, function () use ($classes) {
                return Section::whereIn('class_id', $classes)->count();
            });
            $notices = \Cache::remember('notices-'.$school_id, $minutes, function () use($school_id) {
                return \App\Notice::bySchool($school_id)
                    ->where('active',1)
                    ->get();
            });
            $events = \Cache::remember('events-'.$school_id, $minutes, function () use($school_id) {
                return \App\Event::bySchool($school_id)
                    ->where('active',1)
                    ->get();
            });
            $routines = \Cache::remember('routines-'.$school_id, $minutes, function () use($school_id) {
                return \App\Routine::bySchool($school_id)
                    ->where('active',1)
                    ->get();
            });
            $syllabuses = \Cache::remember('syllabuses-'.$school_id, $minutes, function () use($school_id) {
                return Syllabus::bySchool($school_id)
                    ->where('active',1)
                    ->get();
            });
            $exams = \Cache::remember('exams-'.$school_id, $minutes, function () use($school_id) {
                return Exam::bySchool($school_id)
                    ->where('active',1)
                    ->get();
            });
            // if(\Auth::user()->role == 'student')
            //   $messageCount = \App\Notification::where('student_id',\Auth::user()->id)->count();
            // else
            //   $messageCount = 0;
            return view('home',[
                'totalStudents'=>$totalStudents,
                'totalTeachers'=>$totalTeachers,
                'totalBooks'=>$totalBooks,
                'totalClasses'=>$totalClasses,
                'totalSections'=>$totalSections,
                'notices'=>$notices,
                'events'=>$events,
                'routines'=>$routines,
                'syllabuses'=>$syllabuses,
                'exams'=>$exams,
                //'messageCount'=>$messageCount,
            ]);
        }
    }
}
