<?php

namespace App\Http\Requests\event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'event_datetime' => [
                'required',
                'date'
            ],
            'event_type' => [
                'required',
                'exists:event_types,id'
            ],
        ];
    }
}
