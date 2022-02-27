<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventType;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class EventService
{

    public function timeSpentWorkingByDay($events)
    {
        if ($events->isEmpty()) {
            return collect([]);
        }

        $user = User::find($events->first()->user_id);

        return $events->groupBy('date')
            ->map(function ($dayEvents) use ($user) {
                $dayEvents = $dayEvents->sortBy('time');

                $firstDayEvent = $dayEvents->first();

                if ($firstDayEvent->event_type_id === EventType::HOLIDAY) {
                    return $user->working_time_per_day;
                }

                if($firstDayEvent->event_type_id === EventType::OUT) {
                    $dayEvents->prepend(Event::make([
                        'time' => '00:00:00',
                    ]));
                }

                $lastDayEvent = $dayEvents->last();
                if($lastDayEvent->event_type_id === EventType::IN) {
                    $dayEvents->push(Event::make([
                        'time' => '23:59:00',
                    ]));
                }

                $workedTime = 0;

                for($i=0; $i<count($dayEvents); $i=$i+2) {
                    $workedTime += Carbon::parse($dayEvents[$i]->time)->diffInSeconds(Carbon::parse($dayEvents[$i + 1]->time));
                }

                return $workedTime;
            });
    }

    public function monthProgress($currentMonth, $events)
    {
        if ($events->isEmpty()) {
            return 0;
        }

        $user = User::find($events->first()->user_id);

        $monthWorkingDays = (clone $currentMonth)->startOfMonth()->diffInDaysFiltered(function (Carbon $day) {
            return $day->isWeekday();
        }, (clone$currentMonth)->endOfMonth());

        $monthWorkingTime = $user->working_time_per_day * $monthWorkingDays;

        $monthWorkedTime = array_sum($this->timeSpentWorkingByDay($events)->toArray());

        return (int) ($monthWorkedTime / $monthWorkingTime * 100);
    }

    public function holidaysSpent($user, $year)
    {
        return Event::with('eventType')
            ->where('user_id', $user->id)
            ->where('event_type_id', EventType::HOLIDAY)
            ->whereYear('date', $year)
            ->count();
    }

    public function personalBusinessDaysSpent($user, $year)
    {
        return Event::with('eventType')
            ->where('user_id', $user->id)
            ->where('event_type_id', EventType::PERSONAL_BUSINESS)
            ->whereYear('date', $year)
            ->count();
    }

    public function timeSpentWorkingByWeek($currentMonth, $events)
    {
        $timeSpentWorkingPerWeek = [];

        for ($i = 1; $i <= (clone $currentMonth)->endOfMonth()->weekNumberInMonth; $i++) {
            $timeSpentWorkingPerWeek[$i] = [
                'weekDays' => 0,
                'timeWorkedThatWeek' => 0,
                'overWorkThatWeek' => 0,
            ];
        }

        for($day = clone $currentMonth->startOfMonth(); $day <= clone $currentMonth->endOfMonth(); $day->addDay()) {
            $timeSpentWorkingPerWeek[$day->weekNumberInMonth]['weekDays'] += (int) $day->isWeekday();
        }

        if ($events->isEmpty()) {
            return $timeSpentWorkingPerWeek;
        }

        $user = User::find($events->first()->user_id);

        $timeSpentWorkingByDay = $this->timeSpentWorkingByDay($events);

        foreach($timeSpentWorkingByDay as $day => $timeWorked) {
            $week = Carbon::createFromDate($day)->weekNumberInMonth;

            $timeSpentWorkingPerWeek[$week]['timeWorkedThatWeek'] += $timeWorked;

            $overwork = $timeSpentWorkingPerWeek[$week]['timeWorkedThatWeek'] - ($user->working_time_per_day * $timeSpentWorkingPerWeek[$week]['weekDays']);

            $timeSpentWorkingPerWeek[$week]['overWorkThatWeek'] = max($overwork, 0);
        };

        return $timeSpentWorkingPerWeek;
    }
}
