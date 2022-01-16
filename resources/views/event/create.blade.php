@extends('main')

@section('main-content')
    <div class="offset-lg-2 col-lg-8 ">
        <h1 class="serif">{{__('make reservation')}}</h1>
        <x-messages :message="$message ?? null" />
        <x-errors/>
        <form class="needs-validation" novalidate method="post" action="{{route('event.store')}}">
            @csrf
            <div class="card">
                <div class="card-body">
                    @if(auth()->user()->isAdmin())
                        <div class="mb-3">
                            <label class="form-label" for="user_id">{{__('User')}}</label>
                            <select class="form-select" name="user_id" id="user_id" required>
                                @foreach(\App\Models\User::all() as $user)
                                    <option
                                        value="{{$user->id}}"
                                        {{ auth()->user()->id == $user->id ? 'selected' : '' }}
                                    >
                                        {{$user->name . ' ' . $user->surname}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="text" value="{{auth()->user()->id}}" hidden>
                    @endif
                    <div class="mb-3">
                        <label class="form-label" for="event_datetime">{{ __('Datetime')}}</label>
                        <input
                            type="datetime-local"
                            class="form-control"
                            id="event_datetime"
                            name="event_datetime"
                            required
                            value="{{\Carbon\Carbon::now()->format('Y-m-d H:i')}}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="event_type">{{__('Event type')}}</label>
                        <select class="form-select" name="event_type" id="event_type" required>
                            <option selected value="">
                                {{__('Select event type')}}
                            </option>
                            @foreach($eventTypes as $eventType)
                                <option value="{{$eventType->id}}" >
                                    {{$eventType->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="me-3 mb-3 text-end">
                    <button type="submit" class="btn btn-primary">{{ __('Create event')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
