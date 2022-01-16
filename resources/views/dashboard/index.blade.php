@extends('main')

@section('main-content')
        <h1 class="offset-lg-2 col-lg-4 serif">{{__('dashboard')}}</h1>
        <x-messages :message="$message ?? null" />
        <x-errors/>
        <div class="d-lg-flex flex-lg-row flex-gap">
            <section class="col-lg-4 px-lg-1">
                <h2 class="text-lg-center">{{__('calendar')}}</h2>
            </section>
            <section class="col-lg-4 px-lg-1">
                <h2 class="text-lg-center">{{__('register event')}}</h2>
                <div>
                    <form class="needs-validation" novalidate method="post" action="{{route('event.store')}}">
                        @csrf
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
            </section>
            <section class="col-lg-4 px-lg-1">
                <h2 class="text-lg-center">{{__('actual week')}}</h2>
            </section>
        </div>
@endsection

