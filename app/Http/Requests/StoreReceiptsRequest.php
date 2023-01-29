<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptsRequest extends FormRequest
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
            "player_id"=>"required",
            "amount"=>"required",
            "date"=>"required",


        ];
    }

    public function messages()
    {
        return [
            'branch_id.required'=>'الفرع مطلوب ',
            'sport_id.required'=>' اللعبه مطلويه ',
            'name.required'=>' اسم اللاعب مطلوب  ',
            'date.required'=>' تاريخ الميلاد مطلوب  ',


        ];
    }
}
