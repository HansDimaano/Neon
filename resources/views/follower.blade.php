@extends('layouts.user_panel')

@section('content')
    @php
    // PHP code block within the template
    $card_list = Auth::user()->card;
    $follower = Auth::user()
        ->followers()
        ->skip($page * $take)
        ->take($take)
        ->get();

    @endphp
    <style>
        .profile-image-box {
            display: block;
            width: 100px;
            height: 118px;
            object-fit: cover;
        }

        .card {
            width: 500px;
            min-width: 300;
            border: none;
            border-radius: 10px;
            background-color: #fff
        }

        .card-holder {
            padding-left: 6px;
        }

        @media only screen and (max-width: 600px) {
            .card {
                width: 100%;
                border: none;
                border-radius: 10px;

            }

            .card-holder {
                padding: 0px;
            }

            .card h4 {
                font-size: 1.0rem;
            }

            body {
                display: table;
                font-family: "Open Sans", sans-serif;
                font-size: 0.9rem;
                width: 100%;
            }


        }

        @media only screen and (max-width: 400px) {
            .card h4 {
                font-size: 0.9rem;
            }

            body {
                display: table;
                font-family: "Open Sans", sans-serif;
                font-size: 0.8rem;
                width: 100%;
            }
        }

        .stats {
            background: #f2f5f8 !important;
            color: #000 !important
        }

        .articles {
            font-size: 10px;
            color: #a1aab9
        }

        .number1 {
            font-weight: 500
        }

        .followers {
            font-size: 10px;
            color: #a1aab9
        }

        .number2 {
            font-weight: 500
        }

        .rating {
            font-size: 10px;
            color: #a1aab9
        }

        .number3 {
            font-weight: 500
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 140px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -75px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

    </style>
    <div id="content" class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-7">
                    <strong class="card-title">Follower</strong>
                </div>
                <div class="col-1">

                </div>

                <div class="col-1">
                    @if ($page > 0)
                        <a href="{{ route('user.profile.follow.follower', $page - 1) }}"> <i
                                class="fa fa-lg fa-arrow-left"></i> </a>
                    @endif
                </div>
                <div class="col-1">
                    @if (($page + 1) * $take <
        Auth::user()->followers()->count())
                        <a href="{{ route('user.profile.follow.following', $page + 1) }}"> <i
                                class="fa fa-lg fa-arrow-right"></i> </a>
                    @endif
                </div>
            </div>

            <div class="row mt-3">

                @foreach ($follower as $item_f)
                    @php
                        $ratings = $item_f->user->ratings;
                        $rating = $ratings->avg('rating');
                        $rating = $rating == null ? 0 : $rating;
                    @endphp
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 card-holder">
                        <div class="col card p-3">
                            <div class="d-flex align-items-center">
                                <div class="img-fluid"> <img style="max-width: unset"
                                        src="{{ asset('uploads/user/' . ($item_f->user->profilePicture == null ? 'avatar.png' : $item_f->user->profilePicture->name)) }}"
                                        class="rounded profile-image-box"> </div>
                                <div class="ml-3 w-100">
                                    <h4 class="mb-0 mt-0">
                                        <strong
                                            class="user-name">{{ $item_f->user->fname . ' ' . $item_f->user->lname }}</strong>
                                    </h4> <span>{{ '@' . $item_f->user->username }}</span>
                                    <div
                                        class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                                        <div class="d-flex flex-column"> <span class="articles">Views</span> <span
                                                class="number1">{{ App\Http\Traits\NumberTrait::number_format_short($item_f->user->views) }}</span>
                                        </div>
                                        <div class="d-flex flex-column"> <span class="followers">Followers</span> <span
                                                class="number2">{{ App\Http\Traits\NumberTrait::number_format_short($item_f->user->followers()->count()) }}</span>
                                        </div>
                                        <div class="d-flex flex-column"> <span class="rating">Rating</span> <span
                                                class="number3">{{ $rating }}</span> </div>
                                    </div>
                                    <div class="row form-group button mt-2 d-flex flex-row align-items-center "
                                        style="padding-right: 1rem">

                                        <div class="col-6" style="padding-left: 1rem; padding-right: 1rem">
                                            <form method="POST" action="{{ route('user.profile.follow.change_card') }}">
                                                @csrf
                                                <input hidden name="old_card" value="{{ $item_f->card->id }}">
                                                <input hidden name="follower_id" value="{{ $item_f->follow_id }}">
                                                <select onchange="this.form.submit()" id="card_id" name="card_id"
                                                    class="form-control-sm form-control">

                                                    @foreach ($card_list as $card_item)
                                                        @if ($card_item->id == $item_f->card->id)
                                                            <option selected value="{{ $card_item->id }}">
                                                                {{ $card_item->card_name }}</option>
                                                        @else
                                                            <option value="{{ $card_item->id }}">
                                                                {{ $card_item->card_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach

                                                </select>
                                            </form>
                                        </div>

                                        <!--button
                                                        class="btn btn-sm btn-outline-primary w-100" disabled>{{ $card_item->card_name }}</button-->
                                        <a href="{{ route('user.profile', $item_f->user->id) }}"
                                            class="btn btn-sm btn-primary col-6 w-100">Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>


        <div id="blankgg">
        </div>

    </div><!-- .animated -->
@endsection

@section('js')
    <script>
        var window_height = jQuery(window).height();
        var window_width = jQuery(window).width();
        var content_height = jQuery('#content').height();
        setFooterDistance();
        //setTableWidth();
        console.log(window_height);

        jQuery(window).resize(function() {
            window_height = jQuery(window).height();
            window_width = jQuery(window).width();
            setFooterDistance();
            //setTableWidth();
            //jQuery("#table").css('transform', 'scale(2)');
        });

        function setFooterDistance() {
            jQuery('#blank').height(window_height - content_height - 200);
            console.log(window_height);
            console.log(window_width);
        }
    </script>
@endsection
