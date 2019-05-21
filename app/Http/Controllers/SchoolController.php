<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Myclass;
use App\Models\School;
use App\Models\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        $classes = Myclass::all();
        $sections = Section::all();
        $teachers = User::join('departments', 'departments.id', '=', 'users.department_id')
            ->where('role', 'teacher')
            ->orderBy('name','ASC')
            ->where('active', 1)
            ->get();
        $departments = Department::where('school_id',Auth::user()->school_id)->get();
        return view('school.create-school', compact('schools', 'classes', 'sections', 'teachers', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_medium' => 'required',
            'school_about' => 'required',
            'school_established' => 'required',
        ]);
        $tb = new School;
        $tb->name = $request->school_name;
        $tb->established = $request->school_established;
        $tb->about = $request->school_about;
        $tb->medium = $request->school_medium;
        $tb->code = date("y").substr(number_format(time() * mt_rand(),0,'',''),0,6);
        $tb->theme = 'flatly';
        $tb->save();
        return back()->with('status', 'Created');
    }

    /**
     * @author wuzq
     * @param $school_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($school_id)
    {
        $admins = User::bySchool($school_id)->where('role','admin')->get();
        return view('school.admin-list',compact('admins'));
    }
}
