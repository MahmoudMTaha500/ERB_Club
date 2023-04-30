<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentSubscriptionsRequest extends FormRequest
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
            "tournament_id"=>"required",
            'player_id' => 'required',


        ];
    }

    public function messages()
    {
        return [
            'tournament_id.required'=>'المسابقه مطلوبه  ',
            'player_id.required'=>'يرجي اختيار لاعب واحد علي الاقل ف المسابقه  ',

        ];
    }
}
