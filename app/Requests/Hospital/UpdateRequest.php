<?php


namespace App\Requests\Hospital;


use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'         => 'required',
            'address'      => 'required',
            'latitude'     => 'required',
            'longitude'    => 'required'
        ];
    }
}
