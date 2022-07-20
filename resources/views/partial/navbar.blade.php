<nav class="navbar navbar-expand-lg main-navbar" >
    {{-- search new --}}
    <form action="{{ request()->path() == 'tasks' ? '/task/search' : (request()->path() == '/' ? '/dashboard/search' : (request()->path() == 'users' ? '/user/search' : (request()->path() == 'roles' ? '/role/search':''))) }}" method="GET" role="search" class="form-inline mr-auto" style="margin-top: 10px">
        {{ csrf_field() }}
    <ul class="navbar-nav mr-3;" >
    <li><a href="" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars" style="color: black"></i></a></li>
    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
    {{-- search --}}


    <div class="search-element">
    <input type="text" class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250" method="GET" name="term" id="term">
    <button class="btn" type="submit"><i class="fas fa-search"></i></button>

    </div>
    </form>

    {{-- <img  id="preview-image-before-upload" src="{{ url('/image/'.Auth::user->image) }}"> --}}
            <li class="nav-item dropdown">
                {{-- <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> --}}
                <a style="color: #B9AAAE" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

             {{-- @if(!Auth::user()->image)
            <img style="width: 4vw;height: 10vh; padding: 5px; margin-right:4%; border-radius: 50%" id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif">
            @else --}}
            <img style="width: 3vw;height: 6vh; padding: 5px; margin-right:4%; border-radius: 100%" src="{{ url('/image/'.Auth::user()->image) }}">
             {{-- @endif --}}



    </ul>
    </div>
    </ul>
    </nav>


