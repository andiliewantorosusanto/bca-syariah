<?php


namespace App\Requests\Auth;


use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'              => 'required|between:3,64',
            'email'             => 'unique:users|required|email',
            'nrp'               => 'unique:users|between:3,16',
            'password'          => 'required|min:6',
            're_password'       => 'required|same:password',
            'birth_date'        => 'required|date',
            'profile_image_url' => 'required'
        ];
    }

}
