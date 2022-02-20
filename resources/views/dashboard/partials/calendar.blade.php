<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row border-bottom">
                <div class="col text-center">
                    {{__('Mon.')}}
                </div>
                <div class="col text-center">
                    {{__('Tu.')}}
                </div>
                <div class="col text-center">
                    {{__('Wed.')}}
                </div>
                <div class="col text-center">
                    {{__('Th.')}}
                </div>
                <div class="col text-center">
                    {{__('Fri.')}}
                </div>
                <div class="col text-center">
                    {{__('Sat.')}}
                </div>
                <div class="col text-center">
                    {{__('Sun.')}}
                </div>
            </div>
            <div class="row">
                {{-- previous month --}}
                @if(!$previousMonth->endOfMonth()->isSunday())
                    @for(
                        $i = \Carbon\Carbon::parse('last monday of' . $previousMonth );
                        $i <= $previousMonth->endOfMonth();
                        $i->addDay()
                    )
                        <div class="col py-2 py-xl-0">
                             <div class="d-flex justify-content-center align-items-center text-muted dashboard-calendar-cell">
                                {{$i->day}}
                            </div>
                        </div>
                    @endfor
                @endif
                {{-- current month --}}
                @for(
                    $i = clone $currentMonth->startOfMonth();
                    $i<= $currentMonth->endOfMonth();
                    $i->addDay()
                )
                    <div class="col py-2 py-xl-0 text-primary">
                        @if($timeSpentWorkingByDay->has($i->toDateString()))
                            <a class="text-decoration-none" href="{{route('event.index', [
                                $user,
                                $i->day,
                                $i->month,
                                $i->year,
                            ])}}">
                                <div @class(['d-flex', 'justify-content-center', 'align-items-center', 'dashboard-calendar-cell',
                                    'bg-danger' => $timeSpentWorkingByDay->has($i->toDateString()) && ($timeSpentWorkingByDay->get($i->toDateString()) < $user->working_time_per_day),
                                    'bg-success' => $timeSpentWorkingByDay->has($i->toDateString()) && ($timeSpentWorkingByDay->get($i->toDateString()) >= $user->working_time_per_day),
                                    'bg-opacity-25' => $timeSpentWorkingByDay->has($i->toDateString()),
                                    'rounded-3' => $timeSpentWorkingByDay->has($i->toDateString()),
                                ])>
                                    {{$i->day}}
                                </div>
                            </a>
                        @else
                            <div class="d-flex justify-content-center align-items-center dashboard-calendar-cell">
                                {{$i->day}}
                            </div>
                        @endif
                    </div>
                    @if($i->isSunday())
                        </div><div class="row">
                    @endif
                @endfor

                {{-- next month --}}
                @if(!$nextMonth->startOfMonth()->isMonday())
                    @for(
                        $i = $nextMonth->startOfMonth();
                        $i <= \Carbon\Carbon::parse('first sunday of' . $nextMonth );
                        $i->addDay()
                    )
                        <div class="col py-2 py-xl-0">
                            <div class="d-flex justify-content-center align-items-center text-muted dashboard-calendar-cell">
                                {{$i->day}}
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </div>
</div>
