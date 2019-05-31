<?php

namespace App\Http\Controllers;

use App\exports\StudentExports;
use App\exports\TeacherExports;
use App\Models\Event;
use App\Models\Notice;
use App\Models\Routine;
use App\Models\Syllabus;
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

    public function upload(Request $request)
    {
        $request->validate([
            'upload_type' => 'required',
            'file' => 'required|max:10000|mimes:doc,docx,png,jpeg,pdf,xlsx,xls,ppt,pptx,txt'
        ]);

        $upload_dir = 'school-'.auth()->user()->school_id.'/'.date("Y").'/'.$request->upload_type;
        $path = \Storage::disk('public')->putFile($upload_dir, $request->file('file'));//$request->file('file')->store($upload_dir);

        if($request->upload_type == 'notice'){
            $request->validate([
                'title' => 'required|string',
            ]);

            $tb = new Notice();
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = auth()->user()->school_id;
            $tb->user_id = auth()->user()->id;
            $tb->save();
        }else if($request->upload_type == 'event'){
            $request->validate([
                'title' => 'required|string',
            ]);
            $tb = new Event();
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = auth()->user()->school_id;
            $tb->user_id = auth()->user()->id;
            $tb->save();
        } else if($request->upload_type == 'routine'){
            $request->validate([
                'title' => 'required|string',
            ]);
            $tb = new Routine();
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = auth()->user()->school_id;
            $tb->user_id = auth()->user()->id;
            $tb->save();
        } else if($request->upload_type == 'syllabus'){
            $request->validate([
                'title' => 'required|string',
            ]);
            $tb = new Syllabus();
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = auth()->user()->school_id;
            $tb->user_id = auth()->user()->id;
            $tb->save();
        } else if($request->upload_type == 'profile' && $request->user_id > 0){
            $tb = \App\User::find($request->user_id);
            $tb->pic_path = 'storage/'.$path;
            $tb->save();
        }
        return ($path)?response()->json([
            'imgUrlpath' => url('storage/'.$path),
            'path' => 'storage/'.$path,
            'error' => false
        ]):response()->json([
            'imgUrlpath' => null,
            'path' => null,
            'error' => true
        ]);
        // $options = ['upload_dir'=>'','upload_url'=>''];
        // new UploadHandler($options);
    }
}
