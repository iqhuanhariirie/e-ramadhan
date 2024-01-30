<?php

namespace App\Http\Requests\Events;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', new Event);
    }

    public function rules()
    {
        return [
            'event_name' => ['required', 'max:255'],
            'date' => ['required', 'date_format:Y-m-d'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'event_description' => ['nullable', 'max:255'],
            'audience_code' => ['required', 'max:15'],
        ];
    }

    public function save()
    {
        $newEvent = $this->validated();
        $newEvent['creator_id'] = auth()->id();

        return Event::create($newEvent);
    }
}
