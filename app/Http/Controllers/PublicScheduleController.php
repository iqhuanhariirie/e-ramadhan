<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lecturing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicScheduleController extends Controller
{
    public function today(Request $request)
    {
        $lecturingQuery = Lecturing::query();
        $lecturingQuery->where('date', Carbon::today()->format('d-m-Y'));
        $lecturingQuery->orderBy('date')->orderBy('start_time');
        $lecturings = $lecturingQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules.index', compact('lecturings', 'audienceCodes'));
    }

    public function tomorrow(Request $request)
    {
        $lecturingQuery = Lecturing::query();
        $lecturingQuery->where('date', Carbon::tomorrow()->format('d-m-Y'));
        $lecturingQuery->orderBy('date')->orderBy('start_time');
        $lecturings = $lecturingQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules.index', compact('lecturings', 'audienceCodes'));
    }

    public function thisWeek(Request $request)
    {
        $lecturingQuery = Lecturing::query();
        $monday = Carbon::now()->startOfWeek()->format('d-m-Y');
        $sunday = Carbon::now()->endOfWeek()->format('d-m-Y');
        $lecturingQuery->whereBetween('date', [$monday, $sunday]);
        $lecturingQuery->orderBy('date')->orderBy('start_time');
        $lecturings = $lecturingQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules.index', compact('lecturings', 'audienceCodes'));
    }

    public function nextWeek(Request $request)
    {
        $lecturingQuery = Lecturing::query();
        $monday = Carbon::now()->addWeek()->startOfWeek()->format('d-m-Y');
        $sunday = Carbon::now()->addWeek()->endOfWeek()->format('d-m-Y');
        $lecturingQuery->whereBetween('date', [$monday, $sunday]);
        $lecturingQuery->orderBy('date')->orderBy('start_time');
        $lecturings = $lecturingQuery->get()->groupBy('audience_code');
        $audienceCodes = $this->getAudienceCodeList();

        return view('public_schedules.index', compact('lecturings', 'audienceCodes'));
    }
}
