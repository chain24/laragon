<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19.5.24
 * Time: 15:21
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ImpersonateUserRequest extends FormRequest
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

        return [
            'id' => 'required|numeric|exists:users,id'
        ];
    }
}
