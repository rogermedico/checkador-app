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
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" colspan="7">
                        {{$currentMonth->monthName . ' ' . $currentMonth->year}}
                    </th>
                </tr>
                <tr>
                    <td>
                        {{__('Mon.')}}
                    </td>
                    <td>
                        {{__('Tu.')}}
                    </td>
                    <td>
                        {{__('Wed.')}}
                    </td>
                    <td>
                        {{__('Th.')}}
                    </td>
                    <td>
                        {{__('Fri.')}}
                    </td>
                    <td>
                        {{__('Sat.')}}
                    </td>
                    <td>
                        {{__('Sun.')}}
                    </td>
                </tr>
            </thead>
            <tbody>
                {{-- previous month --}}
                <tr>
                    @for(
                        $i = \Carbon\Carbon::parse('last monday of' . $previousMonth );
                        $i <= $previousMonth->endOfMonth();
                        $i->addDay()
                    )
                        <td class="text-muted">
                            {{$i->day}}
                        </td>
                    @endfor

                    {{-- current month --}}
                    @for(
                        $i = clone $currentMonth->startOfMonth();
                        $i<= $currentMonth->endOfMonth();
                        $i->addDay()
                    )
                        <td>
                            {{$i->day}}
                        </td>
                        @if($i->isSunday())
                            </tr><tr>
                        @endif
                    @endfor

                    {{-- next month --}}
                    @for(
                        $i = $nextMonth->startOfMonth();
                        $i <= \Carbon\Carbon::parse('first sunday of' . $nextMonth );
                        $i->addDay()
                    )
                        <td class="text-muted">
                            {{$i->day}}
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>
