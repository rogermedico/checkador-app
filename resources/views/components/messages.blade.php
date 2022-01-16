@if(session('message') || isset($message))
    <div class='alert alert-success alert-dismissible fade show'>
        @if(session('message'))
            {{\Illuminate\Support\Facades\Session::pull('message')}}
        @endif
        @isset($message)
            {{ $message }}
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
