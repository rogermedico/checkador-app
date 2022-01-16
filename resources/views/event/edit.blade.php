@extends('main')

@section('main-content')
    <div class="offset-lg-2 col-lg-8 ">
        @if(auth()->user()->isAdmin() && $user->id !== auth()->user()->id)
            <h1 class="serif">{{__('update event of ' . $user->name_surname)}}</h1>
        @else
            <h1 class="serif">{{__('update event')}}</h1>
        @endif
        <x-messages :message="$message ?? null" />
        <x-errors/>
        <form class="needs-validation" novalidate method="post" action="{{route('event.update', $event)}}">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="event_datetime">{{ __('Datetime')}}</label>
                        <input
                            type="datetime-local"
                            class="form-control"
                            id="event_datetime"
                            name="event_datetime"
                            required
                            value="{{\Carbon\Carbon::parse($event->date.$event->time)}}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="event_type">{{__('Event type')}}</label>
                        <select class="form-select" name="event_type" id="event_type" required>
                            @foreach(\App\Models\EventType::all() as $eventType)
                                <option
                                    value="{{$eventType->id}}"
                                    {{ $event->event_type_id === $eventType->id ? 'selected' : '' }}
                                >
                                    {{$eventType->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="me-3 mb-3 text-end">
                    <button type="submit" class="btn btn-primary">{{ __('Update event')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
