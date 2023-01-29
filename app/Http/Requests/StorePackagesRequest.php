<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackagesRequest extends FormRequest
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
            "name"=>"required",
            "sport_id"=>"required",
            "price"=>"required",
            "number_of_training"=>"required",
            "total_of_training"=>"required",
            "total_price"=>"required",


        ];
    }

    public function messages()
    {
        return [
            'sport_id.required'=>' اللعبه مطلويه ',
            'name.required'=>' اسم اللاعب مطلوب  ',
            'price.required'=>'  السعر مطلوب  ',
            'number_of_training.required'=>'  عدد المرات مطلوب  ',
            'total_of_training.required'=>'  اجمالي المبلغ ف الفئه مطلوب  ',
            'total_price.required'=>'  اجمالي سعر الباكدج  مطلوب  ',


        ];
    }
}
