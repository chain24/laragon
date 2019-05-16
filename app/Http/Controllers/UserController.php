<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $user;
    public function __construct(UserService $userService, User $user){
        $this->userService = $userService;
        $this->user = $user;
    }

    public function createAdmin(Request $request)
    {
        $data = [];
        $data['code'] = $request->route('code');
        $data['school_id'] = $request->route('id');
        $data['student_code'] = substr(time(),-1,7);
        return view('create_admin',['data' => $data]);
    }

    public function storeAdmin(Request $request)
    {
        $password = $request->password;
        $tb = $this->userService->storeAdmin($request);
        try {
            // Fire event to send welcome email
            // event(new userRegistered($userObject, $plain_password)); // $plain_password(optional)
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }
        return back()->with('status', 'Saved');
    }
}
