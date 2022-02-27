<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Services\EventService;
use Carbon\Carbon;
use Carbon\CarbonInterval;
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

        $monthProgress = $eventService->monthProgress($currentMonth, $events);

        $holidaysSpent = $eventService->holidaysSpent($user, $currentMonth->year);

        $personalBusinessDaysSpent = $eventService->personalBusinessDaysSpent($user, $currentMonth->year);

        $timeSpentWorkingByWeek = $eventService->timeSpentWorkingByWeek($currentMonth, $events);

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
        ]);

        return view('dashboard.index', compact(
            'user',
            'timeSpentWorkingByDay',
            'currentMonth',
            'previousMonth',
            'nextMonth',
            'monthProgress',
            'holidaysSpent',
            'personalBusinessDaysSpent',
            'timeSpentWorkingByWeek',
        ));
    }
}
