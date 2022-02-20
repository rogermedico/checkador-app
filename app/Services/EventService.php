<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventType;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class EventService
{

    public function TimeSpentWorkingByDay($events)
    {
        return $events->groupBy('date')
            ->map(function ($dayEvents) {
                $dayEvents = $dayEvents->sortBy('time');

                $firstDayEvent = $dayEvents->first();
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
}
