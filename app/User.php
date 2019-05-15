<?php

namespace App;

use App\Model;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract,AuthorizableContract,CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens, Notifiable, Impersonate, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'code', 'student_code', 'active', 'verified', 'school_id', 'section_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeStudent($q)
    {
        return $q->where('role', 'student');
    }
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }
    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }
    public function department()
    {
        return $this->belongsTo('App\Models\Department','department_id', 'id');
    }
    public function studentInfo(){
        return $this->hasOne('App\Models\StudentInfo','student_id');
    }
    public function studentBoardExam(){
        return $this->hasMany('App\Models\StudentBoardExam','student_id');
    }
    public function notifications(){
        return $this->hasMany('App\Models\Notification','student_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->role == $role ? true : false;
    }
}