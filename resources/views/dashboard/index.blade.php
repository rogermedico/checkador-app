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
                    @include('event.partials.create_form')
                </div>
            </section>
            <section class="col-lg-4 px-lg-1">
                <h2 class="text-lg-center">{{__('actual week')}}</h2>
            </section>
        </div>
@endsection

