<div class="card">
    <div class="card-body">
        @if(auth()->user()->isAdmin())
            <div class="mb-3 needs-validation">
                <div class="d-flex flex-row">
                    <div class="flex-grow-1 me-3">
                        <select
                            class="form-select"
                            name="user_id"
                            id="select-user"
                            onchange="changeUserOnSelectChange()"
                            required
                        >
                            @foreach(\App\Models\User::all() as $u)
                                <option
                                    value="{{$u->id}}"
                                    {{ ($user->id ?? auth()->user()->id) === $u->id ? 'selected="selected"' : '' }}
                                >
                                    {{ $u->name_surname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <a id="change-user" class="btn btn-primary" href="{{route('event.calendar', [
                                    $user->id ?? auth()->user()->id
                                ])}}">
                            {{ __('Change user')}}
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <div class="container">
            <div class="row mb-3">
                <div class="col text-start">
                    <a class="btn btn-outline-primary" href="{{route('event.calendar', [
                        $user,
                        $previousMonth->month,
                        $previousMonth->year,
                    ])}}">
                        <i class="far fa-calendar-minus"></i> {{__('previous month')}}
                    </a>
                </div>
                <div class="col text-center fw-bold">
                    <button class="btn btn-outline-success disabled opacity-100">
                        <i class="far fa-calendar-check"></i> {{$currentMonth->monthName . ' ' . $currentMonth->year}}
                    </button>
                </div>
                <div class="col text-end">
                    <a class="btn btn-outline-primary" href="{{route('event.calendar', [
                        $user,
                        $nextMonth->month,
                        $nextMonth->year,
                    ])}}">
                        <i class="far fa-calendar-plus"></i> {{__('next month')}}
                    </a>
                </div>
            </div>
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
                        <div class="col text-center text-muted">
                            {{$i->day}}
                        </div>
                    @endfor
                @endif
                {{-- current month --}}
                @for(
                    $i = clone $currentMonth->startOfMonth();
                    $i<= $currentMonth->endOfMonth();
                    $i->addDay()
                )
                    <div class="col text-center">
                        @if($events->contains('date', $i->toDateString()))
                            <a href="{{route('event.index', [
                                $user,
                                $i->day,
                                $i->month,
                                $i->year,
                            ])}}">
                                {{$i->day}}
                            </a>
                        @else
                        {{$i->day}}
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
                        <div class="col text-center text-muted">
                            {{$i->day}}
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </div>
</div>
