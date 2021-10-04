<?php


namespace App\Requests\Auth;


use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username'          => 'required',
            'password'          => 'required|min:6'
        ];
    }
}
