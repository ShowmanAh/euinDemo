<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'image' => 'required_without:id|mimes:jpeg,jpg,png',
            'name' => 'required|string|min:3|max:50',
            'description' => 'required',
            'width' => 'required',
            'height' => 'required'
        ];
    }
}
