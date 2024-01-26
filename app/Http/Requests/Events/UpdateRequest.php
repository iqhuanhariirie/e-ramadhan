<?php

namespace App\Http\Requests\Events;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('event'));
    }

    public function rules()
    {
        return [
            'event_name' => ['required', 'max:255'],
            'date' => ['required', 'date_format:d-m-Y'],
            'start_time' => ['required', 'date_format:H:i:s'],
            'end_time' => ['nullable', 'date_format:H:i:s'],
            'event_description' => ['required', 'max:255'],
        ];
    }
}
