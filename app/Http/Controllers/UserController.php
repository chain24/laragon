<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\Myclass;
use App\Models\Section;
use App\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @var UserService $userService
     */
    protected $userService;

    /**
     * @var User $user
     */
    protected $user;

    public function __construct(UserService $userService, User $user){
        $this->userService = $userService;
        $this->user = $user;
    }

    public function storeAdmin(Request $request)
    {
        $password = $request->password;
        $tb = $this->userService->storeAdmin($request);
        $responseData = $tb->getData();
        if ($responseData->code == 9){
            return back()->withErrors([$responseData->data => $responseData->msg])->withInput();
        }else{
            event(new UserRegistered($tb, $password));
            return redirect('/create-school');
        }

    }

    /**
     * 激活管理员账号
     * @author wuzq
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateAdmin($id)
    {
        $admin = $this->user->find($id);
        if ($admin->active !== 0) {
            $admin->active = 0;
        } else {
            $admin->active = 1;
        }
        $admin->save();
        return back()->with('status', trans('views.user-activateAdmin-saved'));
    }

    /**
     * 解除管理员账号
     * @author wuzq
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deActivateAdmin($id)
    {
        $admin = $this->user->find($id);
        if ($admin->active !== 1) {
            $admin->active = 1;
        } else {
            $admin->active = 0;
        }
        $admin->save();
        return back()->with('status', trans('views.user-deActivateAdmin-saved'));
    }

    /**
     * 编辑页面
     * @author wuzq
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $classes = $classes = Myclass::query()
            ->bySchool(\Auth::user()->school_id)
            ->pluck('id')
            ->toArray();

        $sections = Section::query()
            ->whereIn('class_id', $classes)
            ->get();

        $departments = Department::bySchool(\Auth::user()->school_id)
            ->get();

        return view('profile.edit', [
            'user' => $user,
            'sections' => $sections,
            'departments' => $departments,
        ]);
    }

    public function update(UpdateUserRequest $request)
    {
        \DB::transaction(function () use ($request) {
            $tb = $this->user->find($request->user_id);
            $tb->name = $request->name;
            $tb->email = (!empty($request->email)) ? $request->email : '';
            $tb->nationality = (!empty($request->nationality)) ? $request->nationality : '';
            $tb->phone_number = $request->phone_number;
            $tb->address = (!empty($request->address)) ? $request->address : '';
            $tb->about = (!empty($request->about)) ? $request->about : '';
            $tb->pic_path = (!empty($request->pic_path)) ? $request->pic_path : '';
            if ($request->user_role == 'teacher') {
                $tb->department_id = $request->department_id;
                $tb->section_id = $request->class_teacher_section_id;
            }
            if ($tb->save()) {
                if ($request->user_role == 'student') {

                    try{
                        // Fire event to store Student information
                        event(new StudentInfoUpdateRequested($request,$tb->id));
                    } catch(\Exception $ex) {
                        Log::info('Failed to update Student information, Id: '.$tb->id. 'err:'.$ex->getMessage());
                    }
                }
            }
        });
        return back()->with('status',trans('views.edit_update_Saved'));
    }

    /**
     * 修改密码页面
     * @author wuzq
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePasswordGet()
    {
        return view('profile.change-password');
    }

    public function changePasswordPost(ChangePasswordRequest $request)
    {
        if (Hash::check($request->old_password, \Auth::user()->password)) {
            $request->user()->fill([
                'password' => Hash::make($request->new_password),
            ])->save();
            \Auth::logout();
            return redirect('login');
        }
        return back()->with('error-status', trans('views.change-password-notmatch'));
    }

    public function resetPasswordGet()
    {
        return view('auth.passwords.reset');
    }

}
