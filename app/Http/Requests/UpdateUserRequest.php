<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19.5.22
 * Time: 11:34
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'email' => 'required|email|max:255|' . Rule::unique('users')->ignore($this->get('user_id')),
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|' . Rule::unique('users')->ignore($this->get('user_id')),
        ];
        if ($this->get('user_role') == 'teacher') {
            $rules['department_id'] = 'required|numeric';
        }
        if ($this->get('user_role') == 'student') {
               $rules['session'] = 'required|numeric';//学年
               $rules['version'] = 'required|string';//使用的教材语言
               $rules['birthday'] = 'required|string';
               $rules['religion'] = 'required|string';
               $rules['father_name'] = 'required|string';
               $rules['mother_name'] = 'required|string';
        }

        return $rules;
    }
}
