@extends('main')

@section('main-content')
    <div class="offset-lg-2 col-lg-8 ">
        <h1 class="serif">{{__('create event')}}</h1>
        <x-messages :message="$message ?? null" />
        <x-errors/>
        @include('event.partials.create_form')
    </div>
@endsection
