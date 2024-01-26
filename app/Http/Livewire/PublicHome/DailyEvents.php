<?php

namespace App\Http\Livewire\PublicHome;

use App\Models\Event;
use Livewire\Component;

class DailyEvents extends Component
{
    public $date;
    public $dayTitle;
    public $eventName;
    public $events = [];

    public function getEventName(): array
    {
        return [
            Event::AUDIENCE_PUBLIC => __('event.event_name'),
            Event::AUDIENCE_MUSLIMAH => __('event.event_name'),
        ];
    }

    public function mount()
    {
        $eventQuery = Event::query();
        $eventQuery->where('date', $this->date->format('d-m-Y'));
        $eventQuery->orderBy('date')->orderBy('start_time');
        $this->events = $eventQuery->get();
        $this->eventName = $this->getEventName();
    }

    public function render()
    {
        return view('livewire.public_home.daily_events');
    }
}
