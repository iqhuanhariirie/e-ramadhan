<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\CreateRequest;
use App\Http\Requests\Events\UpdateRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-any', new Event);

        $eventQuery = Event::query();
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $yearMonth = $this->getYearMonth();
        if ($request->get('q')) {
            $eventQuery->where('event_name', 'like', '%'.$request->get('q').'%');
        }
        $eventQuery->where('date', 'like', $yearMonth.'%');
        $eventQuery->orderBy('date')->orderBy('start_time');
        $events = $eventQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getEventAudienceCodeList();

        return view('events.index', compact('events', 'year', 'month', 'audienceCodes'));
    }

    public function create()
    {
        $this->authorize('create', new Event);

        $audienceCodes = [
            Event::AUDIENCE_PUBLIC => __('event.audience_'.Event::AUDIENCE_PUBLIC),
            Event::AUDIENCE_MUSLIMAH => __('event.audience_'.Event::AUDIENCE_MUSLIMAH),
        ];

        return view('events.create', compact('audienceCodes'));
    }

    public function store(CreateRequest $eventCreateForm)
    {
        $event = $eventCreateForm->save();
        flash(__('event.created'), 'success');

        return redirect()->route('events.show', $event);
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        // if (in_array($event->audience_code, [Event::AUDIENCE_FRIDAY])) {
        //     return redirect()->route('friday_lecturings.show', $event);
        // }

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $audienceCodes = [
            Event::AUDIENCE_PUBLIC => __('event.audience_'.Event::AUDIENCE_PUBLIC),
            Event::AUDIENCE_MUSLIMAH => __('event.audience_'.Event::AUDIENCE_MUSLIMAH),
        ];

        return view('events.edit', compact('event', 'audienceCodes'));
    }

    public function update(UpdateRequest $eventUpdateForm, Event $event)
    {
        $event->update($eventUpdateForm->validated());
        flash(__('event.updated'), 'success');

        return redirect()->route('events.show', $event);
    }

    public function destroy(Request $request, Event $event)
    {
        $this->authorize('delete', $event);

        $request->validate(['event_id' => 'required']);

        if ($request->get('event_id') == $event->id && $event->delete()) {
            flash(__('event.deleted'), 'success');
            return redirect()->route('events.index');
        }

        flash(__('event.undeleted'), 'error');

        return back();
    }
}
