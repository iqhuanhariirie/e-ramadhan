<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicScheduleEventController extends Controller
{
    public function today(Request $request)
    {
        $eventQuery = Event::query();
        $eventQuery->where('date', Carbon::today()->format('d-m-Y'));
        $eventQuery->orderBy('date')->orderBy('start_time');
        $events = $eventQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules_event.index', compact('events', 'audienceCodes'));
    }

    public function tomorrow(Request $request)
    {
        $eventQuery = Event::query();
        $eventQuery->where('date', Carbon::tomorrow()->format('d-m-Y'));
        $eventQuery->orderBy('date')->orderBy('start_time');
        $events = $eventQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules_event.index', compact('events', 'audienceCodes'));
    }

    public function thisWeek(Request $request)
    {
        $eventQuery = Event::query();
        $monday = Carbon::now()->startOfWeek()->format('d-m-Y');
        $sunday = Carbon::now()->endOfWeek()->format('d-m-Y');
        $eventQuery->whereBetween('date', [$monday, $sunday]);
        $eventQuery->orderBy('date')->orderBy('start_time');
        $events = $eventQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules_event.index', compact('events', 'audienceCodes'));
    }

    public function nextWeek(Request $request)
    {
        $eventQuery = Event::query();
        $monday = Carbon::now()->addWeek()->startOfWeek()->format('d-m-Y');
        $sunday = Carbon::now()->addWeek()->endOfWeek()->format('d-m-Y');
        $eventQuery->whereBetween('date', [$monday, $sunday]);
        $eventQuery->orderBy('date')->orderBy('start_time');
        $events = $eventQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules_event.index', compact('events', 'audienceCodes'));
    }
}
