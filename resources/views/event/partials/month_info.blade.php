<pre>
{{--    {{$timeSpentWorkingByDay}}--}}
{{--    {{var_dump($timeSpentWorkingByWeek)}}--}}
</pre>
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
                        <a id="change-user" class="btn btn-primary" href="{{route('event.monthInfo', [
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
                <div class="col-6 col-md-6 ps-0 text-start">
                    <a class="btn btn-outline-primary" href="{{route('event.monthInfo', [
                    $user,
                    $previousMonth->month,
                    $previousMonth->year,
                ])}}">
                        <i class="far fa-calendar-minus"></i>
                        <span class="">{{__('previous month')}}</span>
                    </a>
                </div>
                <div class="col-6 col-md-6 pe-0 pe-0 text-end">
                    <a class="btn btn-outline-primary" href="{{route('event.monthInfo', [
                    $user,
                    $nextMonth->month,
                    $nextMonth->year,
                ])}}">
                        <i class="far fa-calendar-plus"></i>
                        <span class="">{{__('next month')}}</span>
                    </a>
                </div>
            </div>
            <div class="row mb-3">
                <h3 class="px-0">Month Info:</h3>
                <div class="card px-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="card-title">Progress:</h5>
                            <div class="progress px-0 mb-1">
                                <div class="progress-bar" role="progressbar" style="width: {{$monthProgress}}%" aria-valuenow="{{$monthProgress}}" aria-valuemin="0" aria-valuemax="100">
                                    {{$monthProgress}}%
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Worked: {{\Carbon\CarbonInterval::seconds(array_sum(array_column($timeSpentWorkingByWeek, 'timeWorkedThatWeek')))->cascade()->forHumans(['short' => true, 'options' => 0])}}
                                </div>
                                @if(array_sum(array_column($timeSpentWorkingByWeek, 'overWorkThatWeek')) !== 0)
                                    <div class="col">
                                        Overwork done: {{\Carbon\CarbonInterval::seconds(array_sum(array_column($timeSpentWorkingByWeek, 'overWorkThatWeek')))->cascade()->forHumans(['short' => true, 'options' => 0])}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @foreach($timeSpentWorkingByWeek as $weekNumber => $weekInfo)
                            <div class="mb-3">
                                <h5 class="card-title">Week {{$weekNumber}}:</h5>
                                <div class="row">
                                    <div class="col">
                                        Worked: {{\Carbon\CarbonInterval::seconds($weekInfo['timeWorkedThatWeek'])->cascade()->forHumans(['short' => true, 'options' => 0])}}
                                    </div>
                                    @if($weekInfo['overWorkThatWeek'] !== 0)
                                        <div class="col">
                                            Overwork done: {{\Carbon\CarbonInterval::seconds($weekInfo['overWorkThatWeek'])->cascade()->forHumans(['short' => true, 'options' => 0])}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <h3 class="px-0">Year Info:</h3>
                <div class="card px-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="card-title">Holidays:</h5>
                            <div class="row">
                                <div class="col">
                                    Spent: {{$holidaysSpent}} days
                                </div>
                                <div class="col">
                                    Remaining: {{$user->holidays - $holidaysSpent}} days
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="card-title">Personal business days:</h5>
                            <div class="row">
                                <div class="col">
                                    Spent: {{$personalBusinessDaysSpent}} days
                                </div>
                                <div class="col">
                                    Remaining: {{$user->personal_business_days - $personalBusinessDaysSpent}} days
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
