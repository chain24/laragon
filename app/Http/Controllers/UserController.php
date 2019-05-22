<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Department;
use App\Models\Myclass;
use App\Models\Section;
use App\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function update(Request $request)
    {

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
