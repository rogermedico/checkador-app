<pre>
{{--{{$timeSpentWorkingByDay}}--}}
{{--{{$monthWorkingTime}}/{{$monthWorkedTime}}={{$monthWorkedTime/$monthWorkingTime}}}}--}}
    {{$monthProgress}}
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
                <div class="col-6 col-md-6 pe-0 text-end">
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
                Month progress:
                <div class="progress px-0">
                    <div class="progress-bar" role="progressbar" style="width: {{$monthProgress}}%" aria-valuenow="{{$monthProgress}}" aria-valuemin="0" aria-valuemax="100">
                        {{$monthProgress}}%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
