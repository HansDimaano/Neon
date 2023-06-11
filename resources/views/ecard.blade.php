<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $user->name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/ecard.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>

<body>
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="row center justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-12">
                    <div class="card user-card-full">
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-12 bg-c-lite-green user-profile">

                                <div class="card-block text-center text-white">
                                    <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png"
                                            class="img-radius" alt="User-Profile-Image"> </div>
                                    <h6 class="f-w-600">{{ $user->fname . ' ' . $user->lname }}</h6>
                                    <p>Web Designer</p>

                                    <!-- Edit button for authenticated user -->
                                    @if (Auth::check() && Auth::user()->id == $user->id)
                                        <a href="{{ route('home') }}" style="color: white; padding-right:2.5rem">
                                            <i class="far fa-edit fa-lg"></i>
                                        </a>
                                    @endif

                                    <!-- Favorite button -->
                                    <a @guest @php
                                        Session::put('url.intended', URL::full());
                                    @endphp href="{{ route('login') }}" @else id="favBtn"
                                    @endguest style="color: white">
                                    <i class="far fa-heart fa-lg"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400">{{ $user->email }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Phone</p>
                                        <h6 class="text-muted f-w-400"><a
                                                href="tel:{{ $user->phone }}">{{ $user->phone }}</a></h6>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Impressions</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Rating</p>
                                        <h6 class="text-muted f-w-400">
                                            {{ $user->rate_counter == 0 ? 0 : round($user->total_rating / $user->rate_counter, 1) }}/10
                                        </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Profile Views</p>
                                        <h6 class="text-muted f-w-400">
                                            {{ str_pad($user->views, 8, '0', STR_PAD_LEFT) }}</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Rating</p>
                                        <h6 class="text-muted f-w-400">
                                            {{ $user->rate_counter == 0 ? 0 : round($user->total_rating / $user->rate_counter, 1) }}/10
                                        </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Profile Views</p>
                                        <h6 class="text-muted f-w-400">
                                            {{ str_pad($user->views, 8, '0', STR_PAD_LEFT) }}</h6>
                                    </div>
                                </div>
                                <ul class="social-link list-unstyled m-t-40 m-b-10">
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                            data-original-title="facebook" data-abc="true"><i
                                                class="mdi mdi-facebook feather icon-facebook facebook"
                                                aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                            data-original-title="twitter" data-abc="true"><i
                                                class="mdi mdi-twitter feather icon-twitter twitter"
                                                aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                            data-original-title="instagram" data-abc="true"><i
                                                class="mdi mdi-instagram feather icon-instagram instagram"
                                                aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    // Handle favorite button click
    $("#favBtn").on('click', function() {
        loadData();
    });

    // Load data from the server
    function loadData() {
        $.get(
                window.location.href + "/makefav", {
                    paramOne: 1,
                    paramX: 'abc'
                },
                function(data, success) {
                    console.log(data);
                    console.log(success);
                    if (data == "1") {
                        $("#favBtn").css({
                            "color": "#007bff"
                        });
                    } else if (data == "0") {
                        $("#favBtn").css({
                            "color": "white"
                        });
                    }
                }
            )
            .fail(function(success) {
                console.log(success.status);
            });
    }
</script>

</body>

</html>
