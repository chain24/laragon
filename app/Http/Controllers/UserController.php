<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\Department;
use App\Models\Myclass;
use App\Models\Section;
use App\Service\UserService;
use App\User;
use Illuminate\Http\Request;

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
        try{
            $tb = $this->userService->storeAdmin($request);

        }catch(\Exception $exception){
            return back()->withErrors(['email' => trans('views.email_duplicate')])->withInput();
        }
        event(new UserRegistered($tb, $password));
        return redirect('/create-school');
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
}
