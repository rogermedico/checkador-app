@extends('main')

@section('main-content')
        <h1 class="offset-lg-2 col-lg-4 serif">{{__('dashboard')}}</h1>
        <x-messages :message="$message ?? null" />
        <x-errors/>
        <div class="d-xl-flex flex-xl-row flex-gap">
            <section class="col-xl-4 px-xl-1">
                <h2 class="text-xl-center">{{__('calendar')}}</h2>
                <div>
                    @include('dashboard.partials.calendar')
                </div>
            </section>
            <section class="col-xl-4 px-xl-1">
                <h2 class="text-xl-center">{{__('register event')}}</h2>
                <div>
                    @include('event.partials.create_form')
                </div>
            </section>
            <section class="col-xl-4 px-xl-1">
                <h2 class="text-xl-center">{{__('actual week')}}</h2>
                <div>
{{--                    @include('event.partials.month_info.partials.info')--}}
                </div>
            </section>
        </div>
@endsection

