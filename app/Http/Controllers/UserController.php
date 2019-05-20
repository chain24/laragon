<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        try{
            $tb = $this->userService->storeAdmin($request);

        }catch(\Exception $exception){
            return back()->withErrors(['email' => trans('views.email_duplicate')])->withInput();
        }
        event(new UserRegistered($tb, $password));
        return redirect('/create-school');
    }
}
