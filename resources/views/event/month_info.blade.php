@extends('main')

@section('main-content')
    <div class="offset-lg-2 col-lg-8 ">
        @if(auth()->user()->isAdmin() && $user && $user->id !== auth()->user()->id)
            <h1 class="serif">{{strtolower($currentMonth->monthName . ' ' . $currentMonth->year)}} {{__('(' . $user->name_surname) . ')'}}</h1>
        @else
            <h1 class="serif">{{strtolower($currentMonth->monthName . ' ' . $currentMonth->year)}}</h1>
        @endif
        <x-messages :message="$message ?? null" />
        <x-errors/>
        @include('event.partials.month_info')
    </div>
@endsection
