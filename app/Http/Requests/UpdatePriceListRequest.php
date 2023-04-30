<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceListRequest extends FormRequest
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
            "price"=>"required",
            "sport_id"=>"required",
            "desc"=>"required",

        ];
    }

    public function messages()
    {
        return [
            'price.required'=>'السعر مطلوب ',
            'sport_id.required'=>' اللعبه مطلويه ',
            'desc.required'=>' الوصف مطلوب ',


        ];
    }
}
