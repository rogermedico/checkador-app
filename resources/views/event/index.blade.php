@extends('main')

@section('main-content')
    <div class="offset-lg-2 col-lg-8 ">
        @if(auth()->user()->isAdmin() && $user && $user->id !== auth()->user()->id)
            <h1 class="serif">{{__('events (' . $user->name_surname) . ')'}}</h1>
        @else
            <h1 class="serif">{{__('events')}}</h1>
        @endif
        <x-messages :message="$message ?? null" />
        <x-errors/>
        <div class="d-flex flex-row mb-3">
            <div class="col-4 text-center">
                @if($dayBefore)
                    <a class="btn btn-outline-primary" href="{{route('event.index', [
                        $dayBefore->day,
                        $dayBefore->month,
                        $dayBefore->year,
                        $user
                    ])}}">
                        <i class="far fa-calendar-minus"></i> {{__('previous day')}}
                    </a>
                @else
                    <button class="btn btn-outline-primary disabled">
                        <i class="far fa-calendar-minus"></i> {{__('previous day')}}
                    </button>
                @endif
            </div>
            <div class="col-4 text-center  fs-5">
                <button class="btn btn-outline-success disabled opacity-100">
                    <i class="far fa-calendar-check"></i> {{$date->format('d/m/Y')}}
                </button>
            </div>
            <div class="col-4 text-center  fs-5">
                @if($dayAfter)
                    <a class="btn btn-outline-primary" href="{{route('event.index', [
                            $dayAfter->day,
                            $dayAfter->month,
                            $dayAfter->year,
                            $user
                        ])}}">
                        <i class="far fa-calendar-minus"></i> {{__('next day')}}
                    </a>
                @else
                    <button class="btn btn-outline-primary disabled">
                        <i class="far fa-calendar-minus"></i> {{__('next day')}}
                    </button>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if(auth()->user()->isAdmin())
                    <div class="mb-3 needs-validation">

                        <div class="d-flex flex-row">
                            <div class="flex-grow-1 me-3">
                                <select class="form-select" name="user_id" id="user_id" required>
                                    @foreach(\App\Models\User::all() as $u)
                                        <option
                                            value="{{$u->id}}"
                                            {{ $user->id ?? auth()->user()->id === $u->id ? 'selected' : '' }}
                                        >
                                            {{ $u->name_surname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <a class="btn btn-primary" href="{{route('event.index', [
                                    $date->day,
                                    $date->month,
                                    $date->year,
                                ])}}">
                                    {{ __('Change user')}}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                <ul class="list-group">
                    @foreach($events as $event)
                        <li class="list-group-item d-flex flex-row">
                            <div class="flex-grow-1 align-self-center">
                                {{strtoupper($event->eventType->name)}}
                                @
                                {{$event->time}}
                            </div>
                            <div class="flex-grow-1 d-flex flex-row justify-content-end">
                                <a class="btn btn-outline-success me-3" href="{{route('event.edit', $event)}}">{{__('Edit')}}</a>
                                <span>
                                    <form action="{{ route('event.destroy', $event) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">
                                            {{__('Delete')}}
                                        </button>
                                    </form>
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
