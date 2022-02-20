<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(EventService $eventService)
    {
        $user = auth()->user();

        $currentMonth = Carbon::createFromDate(
            $year ?? now()->year,
            $month ?? now()->month,
            1
        );

        $previousMonth = clone $currentMonth;
        $previousMonth->subMonth();

        $nextMonth = clone $currentMonth;
        $nextMonth->addMonth();

        $events = Event::with('eventType')
            ->where('user_id', $user->id ?? auth()->user()->id)
            ->whereMonth('date', $currentMonth->month )
            ->whereYear('date', $currentMonth->year)
            ->get();

        $timeSpentWorkingByDay = $eventService->TimeSpentWorkingByDay($events);

        return view('dashboard.index', compact(
            'user',
            'timeSpentWorkingByDay',
            'currentMonth',
            'previousMonth',
            'nextMonth',
        ));
    }
}
