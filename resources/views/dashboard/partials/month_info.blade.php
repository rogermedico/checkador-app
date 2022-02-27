<div class="card">
    <div class="card-body">
        <div class="container">
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
