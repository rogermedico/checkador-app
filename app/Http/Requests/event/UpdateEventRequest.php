<?php

namespace App\Http\Requests\event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
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
