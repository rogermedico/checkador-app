<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        @auth
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNrsTheater" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNrsTheater">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('dashboard.index')}}">{{__('Dashboard')}}</a>
                    </li>
                    @if(auth()->user()->hasEvents())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('event.index')}}">{{__('Events')}}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.edit',auth()->user())}}">{{__('Profile')}}</a>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{__('Admin')}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{route('user.index')}}">{{__('Manage users')}}</a></li>
                                <li><a class="dropdown-item" href="{{route('event.index')}}">{{__('Manage events')}}</a></li>
                            </ul>
                        </li>
                    @endif

            </ul>
        </div>
        @endauth
        <div class="d-flex ms-auto">
            @auth
                <span class="navbar-brand d-none d-md-inline">
                    {{auth()->user()->name}} {{auth()->user()->surname}} ({{auth()->user()->email}})
                </span>
                <span class="navbar-brand d-md-none">
                    {{auth()->user()->name}} {{auth()->user()->surname}}
                </span>
                <a class="btn btn-outline-danger" href="{{route('user.logout')}}">{{__('Logout')}}</a>
            @endauth
            @guest
                <a class="btn btn-outline-success me-3" href="{{route('user.create')}}">{{__('Register')}}</a>
                <a class="btn btn-success" href="{{route('user.login.show')}}">{{__('Login')}}</a>
            @endguest

        </div>
    </div>
</nav>
