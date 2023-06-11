<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>
        @guest
            {{ config('app.name') }}
        @else
            {{ config('app.name') }} ({{ Auth::user()->fname }})
        @endguest
    </title>

    {{-- <meta property="og:image" content="{{isset($user)?asset('uploads/user/' . (is_null($user->profilePicture)?'avatar.png':$user->profilePicture->name)):asset('images/ecard_logo.png')}}" /> --}}
    <meta property="og:title" content="{{ isset($user) ? $user->fname . ' ' . $user->lname : 'Profile' }}" />
    <meta property="og:description"
        content="{{ isset($user) ? $user->bio : 'We provide the best social platform that will link all of your socials' }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/cs-skin-elastic.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet" type="text/css" />

    <style>
        :root {
            --background: #343A40;
        }

        .fixed-height {
            height: 125px;
        }

        .fixed-height1 {
            height: 355px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .display-none {
            display: none;
        }

        .star {
            cursor: pointer;
            height: 20px;
            width: 20px;
            margin: 2px;
            background-color: grey;
            clip-path: polygon(50% 0%,
                    63% 38%,
                    100% 38%,
                    69% 59%,
                    82% 100%,
                    50% 75%,
                    18% 100%,
                    31% 59%,
                    0% 38%,
                    37% 38%);
        }

        .star-selected {
            background-color: red;
        }

        @media only screen and (max-width: 992px) {
            .fixed-height1 {
                height: auto;
                padding-top: 10px;
            }
        }

        .ui-footer {
            position: absolute !important;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Left Panel -->
    <div id="app">
        @if (Auth::check())

            <aside id="left-panel" class="left-panel">
                <nav class="navbar navbar-expand-sm navbar-default">
                    <div id="main-menu" class="main-menu collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="menu-title">{{ Auth::user()->fname . ' ' . Auth::user()->lname }}</li>

                            @if (Route::currentRouteName() == 'user.dashbord')
                                <li class="active">
                                    <a href={{ route('user.dashbord') }}><i class="menu-icon fa fa-home"
                                            style="margin-top: 6px"></i>Home
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href={{ route('user.dashbord') }}><i class="menu-icon fa fa-home"
                                            style="margin-top: 6px"></i>Home
                                    </a>
                                </li>
                            @endif





                            @if (strpos(Route::currentRouteName(), 'user.profile.follow') !== false)
                                <li class="menu-item-has-children dropdown active show">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="true">
                                        <i class="menu-icon fa fa-users"></i>Follow</a>
                                    <ul class="sub-menu children dropdown-menu show">
                                    @else
                                        <li class="menu-item-has-children dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="menu-icon fa fa-users"></i>Follow</a>
                                            <ul class="sub-menu children dropdown-menu">
                            @endif
                            <li>
                                <i class="fa  fa-hand-o-left"></i><a
                                    @if (Route::currentRouteName() == 'user.profile.follow.following') style="color: #03a9f3;" @endif
                                    href="{{ route('user.profile.follow.following', 0) }}">Following</a>
                            </li>
                            <li>
                                <i class="fa  fa-hand-o-right"></i><a
                                    @if (Route::currentRouteName() == 'user.profile.follow.follower') style="color: #03a9f3;" @endif
                                    href="{{ route('user.profile.follow.follower', 0) }}">Followers</a>
                            </li>
                        </ul>
                        </li>


                        @if (Route::currentRouteName() == 'user.profile.favourite')
                            <li class=" dropdown active show">
                                <a href={{ route('user.profile.favourite', 0) }}><i class="menu-icon fa fa-heart"
                                        style="margin-top: 6px"></i>Favourites
                                </a>
                            </li>
                        @else
                            <li class=" dropdown">
                                <a href={{ route('user.profile.favourite', 0) }}><i class="menu-icon fa fa-heart"
                                        style="margin-top: 6px"></i>Favourites
                                </a>
                            </li>
                        @endif


                        <!-- /.menu-title -->
                        <li @if (Route::currentRouteName() == 'user.profile.card.edit') class="menu-item-has-children active dropdown show">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">
                            <i class="menu-icon fa fa-credit-card"></i>Security</a>
                        <ul class="sub-menu children dropdown-menu show">
                        @else
                            class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="menu-icon fa fa-credit-card"></i>Security</a>
                            <ul class="sub-menu children dropdown-menu"> @endif
                            {{-- <li>
                            <i class="fa  fa-plus-square-o"></i>
                            <a href="" onclick="return false;" data-toggle="modal" data-target="#mediumModalXXX">New Card
                            </a>
                        </li> --}}
                            @foreach (Auth::user()->card as $item)
                        @if ($item->card_name == 'public')
                        <li>
                            <i class="fa  fa-pencil-square"></i>
                            <a ___inline_directive_________________________________________3___ href="{{ route('user.profile.card.edit', $item->id) }}">{{ $item->card_name }}
                            </a>
                        </li>
                        @endif @endforeach
                            </ul>
                        </li>


                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </aside>
            <!-- /#left-panel -->
        @else
            <aside id="left-panel" class="left-panel">
                <nav class="navbar navbar-expand-sm navbar-default">
                    <div id="main-menu" class="main-menu collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="menu-title">Authenticate</li>
                            <!-- /.menu-title -->
                            <li class="menu-item-has-children active dropdown show">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="true">
                                    <i class="menu-icon fa  fa-user"></i>User</a>
                                <ul class="sub-menu children dropdown-menu show">
                                    <li>
                                        <i class="fa fa-sign-in"></i><a href="{{ route('login') }}">Login</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-plus-square"></i><a href="{{ route('register') }}">Register</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-lock"></i><a href="{{ route('password.request') }}">Forget
                                            Password</a>
                                    </li>
                                </ul>
                            </li>


                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </aside>
        @endif

        <!-- Left Panel -->

        <!-- Right Panel -->

        <div id="right-panel" class="right-panel">
            <!-- Header-->
            <header id="header" class="header">
                <div class="top-left">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            {{-- <img src="{{ asset('images/ecard_logo.png') }}" alt="Logo" /> --}}
                            <h2>{{config('app.name')}}</h2>
                        </a>
                        <a class="navbar-brand hidden" href="{{ route('home') }}"><img
                                src="{{ asset('images/ecard_logo.png') }}" alt="Logo" /></a>
                        <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
                <div class="top-right">
                    <div class="header-menu">
                        <div class="header-left">
                            <button class="search-trigger">
                                <i class="fa fa-search"></i>
                            </button>
                            <div class="form-inline">
                                <form id="searchFormId" action="{{ route('user.profile.search') }}" method="GET"
                                    class="search-form">
                                    <button id="my_submit" class="form-control" type="submit" hidden>
                                        <i class="fa fa-search"></i>
                                    </button>

                                    <input id="searchText" autocomplete="off" name="text"
                                        class="form-control mr-sm-2" type="text" placeholder="Search ..."
                                        aria-label="Search" />


                                    <button class="search-close" type="submillt"><i class="fa fa-close"></i></button>



                                    <script>
                                        console.log('in search');
                                        document.getElementById("searchText").addEventListener("keyup", function(event) {
                                            if (event.keyCode === 13) {
                                                event.preventDefault();
                                                document.getElementById("my_submit").click();
                                                console.log('clicked search');
                                            }
                                        });
                                    </script>
                                </form>
                            </div>

                            @if (Auth::check() && false)
                                <div class="dropdown for-notification">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="notification" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-bell"></i>
                                        <span class="count bg-danger">3</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="notification">
                                        <p class="red">You have 3 Notification</p>
                                        <a class="dropdown-item media" href="#">
                                            <i class="fa fa-check"></i>
                                            <p>Server #1 overloaded.</p>
                                        </a>
                                        <a class="dropdown-item media" href="#">
                                            <i class="fa fa-info"></i>
                                            <p>Server #2 overloaded.</p>
                                        </a>
                                        <a class="dropdown-item media" href="#">
                                            <i class="fa fa-warning"></i>
                                            <p>Server #3 overloaded.</p>
                                        </a>
                                    </div>
                                </div>
                            @endif


                        </div>

                        @if (Auth::check())
                            <div class="user-area dropdown float-right">
                                <a href="#" class="dropdown-toggle active" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <img class="user-avatar rounded-circle fit" style="object-fit: cover;"
                                        @if (Auth::check() && Auth::user()->profilePicture != null) src="{{ asset('uploads/user/' . Auth::user()->profilePicture->name) }}"
                            @else
                                src="{{ asset('images/avatar.png') }}" alt="User Avatar" @endif />
                                </a>

                                <div class="user-menu dropdown-menu">
                                    <a class="nav-link" href="{{ route('user.profile', Auth::user()->id) }}"><i
                                            class="fa fa-user"></i>View Profile</a>

                                    <a class="nav-link" href="{{ route('user.profile.edit') }}"><i
                                            class="fa  fa-edit"></i>Edit
                                        Profile</a>

                                    {{-- <a class="nav-link" href="#"><i class="fa fa-cog"></i>Settings</a> --}}


                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power-off"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </header>
            <!-- /header -->
            <!-- Header-->

            <main class="">
                @yield('content')
            </main>

            <!-- .content -->

            <div class=" clearfix"></div>

            @auth
                <div class="modal fade" id="mediumModalXXX" tabindex="-1" role="dialog"
                    aria-labelledby="mediumModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form action="{{ route('user.profile.card.create') }}" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mediumModalLabel">Create New E-Card</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        A user can create highest 3 cards in free version. In this case you have
                                        {{ 3 - Auth::user()->card->count() }} card/card's left.
                                    </p>
                                    <div class="row">

                                        @csrf
                                        <div class="form-group col-lg-6 col-md-12 col-sm-12"><label for="company"
                                                class=" form-control-label">Card Name</label><input type="text"
                                                id="company_card_new" name="new_card_name" placeholder="Enter card name"
                                                class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endauth

        </div>

        <!--footer class="site-footer  ui-footer" style="width: 100%">
        <div class="footer-inner bg-white" >
            <div class="row">
                <div class="col-sm-6">Copyright&copy; E-card</div>
                <div class="col-sm-6 text-right">
                    Designed by Woome
                </div>
            </div>
        </div>
    </footer-->
    </div>
    <!-- /#right-panel -->

    <!-- Right Panel -->

    <script>
        const DELAY = 3000;

        function showToast(event, id) {
            event.preventDefault();
            console.log(id);
            document.getElementById(id).style.display = "block";

            setTimeout(function() {
                hideToast(id);
            }, DELAY);
        }

        function hideToast(id) {
            document.getElementById(id).style.display = "none";
        }
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    @yield('js')

    <script>
        removeDropdown();
        jQuery(window).resize(function() {
            removeDropdown();
        });

        function removeDropdown() {
            if (jQuery(window).width() <= 960) {
                jQuery('.menu-item-has-children.dropdown').removeClass("show");
                jQuery('.sub-menu.children.dropdown-menu').removeClass("show");
            }
        }
    </script>

</body>

</html>
