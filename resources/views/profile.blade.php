@extends('layouts.user_panel')

@section('content')

    @php

    @endphp

    @guest
        @php
        Session::put('url.intended', URL::full());
        $favButton = 'href=' . route('login');
        $followButton = "onclick=location.href='" . route('login') . "'";
        $is_following = false;
        $is_fav = false;
        @endphp
    @else
        @php
        $is_following =
            Auth::check() &&
            $user
                ->followers()
                ->where('follow_id', Auth::user()->id)
                ->first() == null
                ? false
                : true;
        $favButton = '';
        $followButton = '';
        $is_fav =
            Auth::user()
                ->favourites()
                ->where('card_id', $card->id)
                ->first() == null
                ? false
                : true;
        @endphp
    @endguest

    <script>
        var card = {!! $card->id !!};
    </script>

    <style>
        :root {
            --background: #343A40;
            --primary: #00C292;
            --highlight-text: #015677;
        }

        .pimg {
            width: 85px;
            height: 85px;
        }

        .card-upper-part {
            height: 150px;
            background-color: var(--background);
        }

        .fixed-height {
            height: 125px;
        }

        .star {
            cursor: pointer;
            height: 25px;
            width: 25px;
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
            color: grey;
        }

        .star-selected {
            background-color: #00C292;
            color: #00C292;
        }

        .h2,
        h2 {
            font-size: 1.2rem;
        }

        .profile-name-holder {
            margin-top: 10px;
        }

        @media only screen and (max-width: 400px) {

            .h2,
            h2 {
                font-size: 1rem;
            }

            .pimg {
                height: 60px;
                width: 60px;
            }

            p {
                font-size: 0.8rem;
                font-family: "Open Sans", sans-serif;
                font-weight: 400;
                /* line-height: 24px; */
                color: #878787;
            }

            .card-upper-part {
                height: 125px;
            }

            body {
                display: table;
                font-family: "Open Sans", sans-serif;
                font-size: 0.8rem;
                width: 100%;
            }

            .fixed-height {
                height: 100px;
            }

            .star {
                cursor: pointer;
                height: 20px;
                width: 20px;
                margin: 0px;
                background-color: grey;
                clip-path: polygon(50% 0%, 63% 38%, 100% 38%, 69% 59%, 82% 100%, 50% 75%, 18% 100%, 31% 59%, 0% 38%, 37% 38%);
                color: grey;
            }

            .star-selected {
                background-color: #00C292;
                color: #00C292;
            }

            .profile-name-holder {
                margin-top: 0px;
            }

        }

        .background {
            background-color: var(--background);
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

        .my-toast {
            z-index: 1;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }



        @media only screen and (max-width: 992px) {
            .fixed-height1 {
                height: auto;
                padding-top: 10px;
            }
        }

    </style>

    @php
    $providerMap = \App\Models\Variable::where('name', 'provider_map')
        ->get()
        ->first()->value;

    $providerMap = json_decode($providerMap, true);

    $ratings = $user->ratings();
    $rating = $ratings->avg('rating');
    $rating = $rating == null ? 0 : $rating;
    $review = $ratings->count();
    $company = [];
    if (isset($card->permissions['job']) && $card->permissions['job'] == 'custom') {
        $company = $card->permissions['company'] == null ? null : $card->permissions['company'];
        $company['logo'] = [
            'name' => $company['logo']??null,
        ];
    } else {
        $company = null;
    }

    $position = isset($card->permissions['company']['position']) ? $card->permissions['company']['position'] : 'Not set';
    $social_permissions = isset($card->permissions['social']) ? $card->permissions['social'] : null;
    if (isset($card->permissions['rating']) && $card->permissions['rating'] == 'hide') {
        $rating = 0;
    }

    @endphp

    <script>
        var defaultRating = {!! $rating !!};
        var favRoute = "{!! route('user.make.favourite', ['id' => $user->id, 'card' => $card->id]) !!}";
    </script>

    <div class="content">
        <div class="row ">
            <div class="col-sm-12 col-lg-6" style="">
                <section class="card shadow">
                    <div class="col-12 p-0">
                        <div class="card-header text-white" style="background-color: var(--background); ">
                            <strong class="card-title mb-1">{{ '@' . $user->username }}</strong>
                        </div>
                    </div>
                    <div class="position-relative d-flex align-items-center justify-content-start card-upper-part">
                        <div class="text-light" style="position: absolute; top: 3px; right: 20px; font-size: 30px;">
                            <a id="favBtn" {{ $favButton }} @if ($is_fav)
                                style="color:#00C292"
                            @else
                                style="color:white"
                                @endif > <i class="fa fa-heart cursor-pointer" title="Add to favorite"></i> </a>
                        </div>

                        <div class="text-light" style="position: absolute; bottom: 10px; right: 20px;">

                            @if ($social_permissions != null)


                                @foreach ($social_permissions as $key => $value)
                                    @php

                                        //echo $key . ' ' .$value ; //$providerMap[$key];
                                        $package = isset($providerMap[$key]) ? $providerMap[$key] : null;
                                        //if ($package == null)
                                        //echo "khshciosdhcvoisdhvo;"
                                        $href = '#';
                                        if (isset($package['provider']) && ($package['provider'] == 'Social' || $package['provider'] == 'User')) {
                                            if (is_null($package['href'])) {
                                                $href = $package['link'] . '/' . (\App\Models\Social::getSocialIdByProvider($user, $package['provider'], $key) ?? '##NULL##');
                                            } else {
                                                $href = $package['href'] . (\App\Models\Social::getSocialIdByProvider($user, $package['provider'], $key) ?? '##NULL##');
                                            }
                                        }

                                    @endphp

                                    @if ($package != null && $value != 'hide' && !str_contains($href, '##NULL##') && $href != '')
                                        <a @if (isset($package['provider']) && $package['provider'] == 'Social')
                                            target="_blank"
                                            @endif href="{{ $href }}"> <i
                                                class="fa  {{ $package['icon'] }} cursor-pointer mr-3"
                                                style="color: white"></i> </a>
                                    @endif
                                @endforeach
                            @endif


                        </div>

                        <div class="d-flex justify-content-start ml-3">
                            <a href="#">
                                <img class="pimg rounded-circle mr-3 fit" style="object-fit: cover;" alt="" @if ($user->profilePicture != null)
                                src="uploads/user/{{ $user->profilePicture->name }}"
                            @else
                                src="images/avatar.png" alt="User Avatar"
                                @endif
                                ></a>
                            <div class="profile-name-holder d-flex flex-column justify-content-center"
                                style="height: 85px;">
                                <h2 class="text-white display-6">{{ $user->fname . ' ' . $user->lname }}</h2>
                                <p class="text-light">{{ $position }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-around m-3">
                        <div class="d-flex flex-column justify-content-between fixed-height">
                            <div class="d-flex flex-column align-items-center p-1">
                                <h5>{{ $user->following()->count() }}</h5>
                                Following
                            </div>

                            <div class="d-flex flex-column align-items-center p-1">
                                @if (isset($card->permissions['rating']) && $card->permissions['rating'] != 'hide')
                                    <h5>{{ round($rating, 2) }} ({{ $review }})</h5>
                                @else
                                    <i style="color: var(--highlight-text)" class="fa fa-eye-slash"></i>
                                @endif


                                Rating
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-between fixed-height">
                            <div class="d-flex flex-column align-items-center p-1">
                                <h5>{{ $user->followers()->count() }}</h5>
                                Followers
                            </div>

                            <div class="d-flex flex-column align-items-center p-1">
                                <div class="d-flex justify-content-center">
                                    <span onclick="startModal(this)" id="star1" class="star"></span>
                                    <span onclick="startModal(this)" id="star2" class="star"></span>
                                    <span onclick="startModal(this)" id="star3" class="star"></span>
                                    <span onclick="startModal(this)" id="star4" class="star"></span>
                                    <span onclick="startModal(this)" id="star5" class="star"></span>
                                </div>
                                Rate me
                            </div>
                        </div>



                        <div class="d-flex flex-column justify-content-between fixed-height">
                            <div class="d-flex flex-column align-items-center p-1">
                                <h5>{{ $user->views }}</h5>
                                Views
                            </div>

                            <div class="d-flex flex-column align-items-center p-1">
                                <button @if (Auth::check())
                                    id = "followBtn"
                                    @endif {{ $followButton }} type="button" class="btn btn-dark">
                                    <i id="followBtni"
                                        class="{{ $is_following ? 'fa fa-hand-o-lefti' : 'fa fa-hand-o-right' }}"></i>
                                    <a id="followBtnt">{{ $is_following ? 'Following' : 'Follow' }}</a>
                                </button>
                            </div>
                        </div>
                    </div>

                </section>
            </div>

            <div class="col-lg-6" style=" margin:auto;">
                <aside class=" profile-nav alt shadow">
                    <section class="card shadow" style="border-radius: 20px;">
                        <div class="card-header text-white"
                            style="border-radius: 5px 5px 0 0; background-color: var(--background);">
                            <strong class="card-title mb-1">Information of Company</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa fa-globe"></i> Web Address <span class="pull-right">
                                    <address class="p-0 m-0"><a style="color: var(--highlight-text)"
                                            href="{{ isset($company['website']) ? \App\Http\Traits\NumberTrait::addhttp($company['website']) : 'Unknown' }}">
                                            {{ isset($company['website']) ? \App\Http\Traits\NumberTrait::addhttp($company['website']) : 'Unknown' }}
                                        </a></address>
                                </span>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-envelope-o"></i> Email <span class="pull-right"><a
                                        style="color: var(--highlight-text)"
                                        href="mailto:{{ isset($company['email']) ? $company['email'] : 'Unknown' }}">{{ isset($company['email']) ? $company['email'] : 'Unknown' }}</a></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-phone"></i> Phone <span class="pull-right"><a
                                        style="color: var(--highlight-text)"
                                        href="tel:{{ isset($company['phone']) ? $company['phone'] : 'phone' }}">
                                        {{ isset($company['phone']) ? $company['phone'] : 'phone' }}</a></span>
                            </li>
                            <li class="list-group-item">
                                <i class="ti ti-eye"></i> Views <span class="badge badge-dark pull-right"
                                    style="background-color: var(--background);">32</span>
                            </li>
                        </ul>

                        <div class="card-header user-header alt"
                            style="border-radius: 0 0 5px 5px; background-color: var(--background);">
                            <div class="media">
                                <a href="#">
                                    <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;"
                                        alt="" @if (isset($company['logo']['name']))
                                    src="{{ asset('uploads/company/' . $company['logo']['name']) }}"
                                @else
                                    src="{{ asset('uploads/company/default.png') }}"
                                    @endif>
                                </a>
                                <div class="d-flex flex-column justify-content-center" style="height: 85px;">
                                    <h4 class="text-white display-6">
                                        {{ isset($company['name']) ? $company['name'] : 'Name Unknown' }}</h4>
                                    <h6 class="text-light">
                                        {{ isset($company['position']) ? $company['position'] : 'Unknown' }}</h6>
                                </div>
                            </div>
                        </div>

                    </section>
                </aside>
            </div>

        </div>

        @php
            $count_comment = 0;
        @endphp

        <div class="row">

                @php
                    $status = $user->status;
                @endphp

        @foreach ($status as $item)
        <div class="col-12">

            <div class="card mt-4" style="max-width: 790px;margin:auto">
                <div class="card-header">

                    </br>

                    <div class="d-flex justify-content-start ml-3">
                        <a href="#">
                            <img style="height:50px;width:50px;" class="pimg rounded-circle mr-3 fit"
                                style="object-fit: cover;" alt=""
                                @if ($user->profilePicture != null) src="uploads/user/{{ $item->user->profilePicture->name }}"
                                @else
                                src="images/avatar.png" alt="User Avatar" @endif></a>
                        <div style="max-height: 40px"
                            class="profile-name-holder d-flex flex-column justify-content-center">
                            <h2 style="margin-top: -40px" class=" display-6">
                                </br>
                                <h6 class="pt-1">{{ $item->user->fname . ' ' . $item->user->lname }}</h6>
                                @if ($item->tags->count()!=0)
                                <span style="font-size: 13px">With
                                    @foreach ($item->tags as $tag)
                                        @if ($loop->index!=0)
                                        ,
                                        @endif
                                        <a href="{{route('user.profile',$tag->user->id)}}" >{{$tag->user->username}}</a>
                                    @endforeach
                                </span>
                                @endif

                                <span style="font-size: 11px">{{ $item->created_at }}</span>
                            </h2>

                        </div>
                    </div>
                    @auth
                        @if (auth::user()->id == $item->user->id)
                        <a class="pl-2 btn" href="" style="font-size: 12px; background-color:red; color:white; margin-top: 20px; padding: 0.375rem 0.75rem !important;"
                                            onclick="event.preventDefault();
                                            document.getElementById('comment-del-form-{{ $item->id }}').submit();">Delete</a>

                                        {{-- <a class="pl-4" href="" style="font-size: 12px; background-color:green; color:white; text-align:center; padding: 0.375rem 0.75rem !important;">Edit</a> --}}
                                        <a type="button" class="pl-2 btn" style="font-size: 12px; background-color:green; color:white; margin-top: 20px; padding: 0.375rem 0.75rem !important;" data-toggle="modal" data-target="#editModal{{$item->id}}">Edit</a>

                            <form id="comment-del-form-{{ $item->id }}"
                                action="{{ route('user.profile.status.delete') }}" method="POST" class="d-none">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            </form>
                        @else
                            <div class="p-2"></div>
                        @endif

                    @endauth
                </div>
                <div class="card-body d-flex flex-column" style="min-height: 150px">
                    <h4>{{ $item->body }}</h4>

                    @if (!is_null($item->image))
                    <img class="mt-3" id="profilePictureX" style="object-fit: contain;max-height:400px"
                    src="/uploads/status/{{$item->image->name}}" alt="Your Picture" width="100%" height="100%">
                    @endif

                </div>

                <div class="card-header">

                    @auth
                            <span><span class="p-0" style="font-weight: bold">{{$item->likes->count()}}</span>&nbsp;likes</span>
                            <a class="pl-3" href="" style="font-size: 14px; @if($item->isLikedBy(auth::user())!==0) color:#28a745 @else color:black @endif; font-weight:bold"
                                            onclick="event.preventDefault();
                                            document.getElementById('comment-like-form-{{ $item->id }}').submit();">@if($item->isLikedBy(auth::user())!==0)Liked @else Like @endif</a>

                            <form id="comment-like-form-{{ $item->id }}"
                                action="{{ route('user.profile.status.like') }}" method="POST" class="d-none">
                                @csrf
                                <input type="hidden" name="status_id" value="{{ $item->id }}">
                            </form>


                    @endauth
                            &nbsp;
                </div>

                <div class="card-body d-flex flex-column ">
                    @foreach ($item->comments as $comment)
                        <div class="p-2 mt-3" style="background-color: beige;">
                        <span style="font-size: 12px;color:blue; background-color: beige;">{{$comment->user->fname}}</span>
                        <span style="font-size: 12px;color:rgb(97, 97, 97); background-color: beige;">{{$comment->created_at}}</span>
                        <h5 style=" background-color: beige;">{{$comment->body}}</h5>
                        </div>
                    @endforeach
                </div>

                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <form method="post" action="{{ route('user.profile.status.comment.create') }}" class="w-100">
                        @csrf

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-laptop"></i>
                                </div>
                                <textarea name="body" type="text" class="form-control" placeholder="Write your comments" required></textarea>
                                <input type="hidden" name="status_id" value="{{$item->id}}"/>
                            </div>
                        </div>

                        <div class="form-actions form-group">
                            <button type="submit" class="btn btn-success btn-sm">
                                Comment It
                            </button>
                            <div class="position-relative display-none" id="contact">
                                <div class="position-absolute">
                                    <div class="p-2 bg-light text-dark">
                                        <span class="badge badge-success">
                                            Success
                                        </span>
                                        Your Information has been successfully uploaded
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>




                <!-- Modal -->
                <div id="editModal{{$item->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Status</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="max-width: 790px;margin:auto">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <form method="post" action="{{ route('user.profile.status.edit',$item->id) }}" enctype="multipart/form-data" class="w-100">
                                    @csrf

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-laptop"></i>
                                            </div>
                                            <textarea name="status" type="text" class="form-control" placeholder="Write your thoughts" required>{{$item->body}}</textarea>

                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="mx-auto d-block">
                                            <div class="position-relative mx-auto" >
                                                <div class="">
                                                    <label style="width:100%" for="image" class="icon-label justify-content-center">
                                                        <i class="fa fa-photo "></i>
                                                        Upload Photo
                                                    </label>
                                                    <input type="file" id="img" name="image" accept="image/*">
                                                </div>

                                                <div class="mt-2">
                                                    <label style="" for="rmv_img" class="icon-label justify-content-center">
                                                        <i class="fa fa-remove "></i>
                                                        Remove Image
                                                    </label>
                                                    <input type="checkbox" name="rmv_img">
                                                </div>


                                            </div>

                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="container p-0 input-group">
                                            <label style="width:500px%" for="ll-input" class="icon-label justify-content-center">
                                                <i class="fa fa-users "></i>
                                                Tag
                                            </label>
                                            <select style="width: 500px" class="basic-multiple" name="tags[]" multiple="multiple">
                                                @foreach ($item->tags as $tag)
                                                    <option selected value="{{$tag->user->id}}">{{$tag->user->username}}</option>
                                                @endforeach
                                                @foreach (\App\Models\User::all() as $user)
                                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-actions form-group mt-5">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Update Status
                                        </button>
                                        <div class="position-relative display-none" id="contact">
                                            <div class="position-absolute">
                                                <div class="p-2 bg-light text-dark">
                                                    <span class="badge badge-success">
                                                        Success
                                                    </span>
                                                    Your Information has been successfully uploaded
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>

                </div>
                </div>
            </div>

        </div>
        @endforeach

        </div>
    </div>

    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('user.profile.rateme', $user->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="star" id="star1Modal" onclick="startModal(this)">00</span>
                        <span class="star" id="star2Modal" onclick="startModal(this)">00</span>
                        <span class="star" id="star3Modal" onclick="startModal(this)">00</span>
                        <span class="star" id="star4Modal" onclick="startModal(this)">00</span>
                        <span class="star" id="star5Modal" onclick="startModal(this)">00</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input id="starRating" hidden name="rating" />
                    <div class="modal-body">
                        <label for="comment">Your Comment?</label>
                        <textarea name="comment" class="form-control w-100 h-100" rows="8" placeholder="Write your rating comment..."
                            id="comment"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="cancelStarRating()"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        cancelStarRating();
        const DELAYXX = 3000;

        var toast = document.getElementById("social");

        function startModal(star) {
            jQuery("#mediumModal").modal('show');

            markStars(star.id)

            toast.childNodes[1].childNodes[1].innerHTML = "You have clicked " + star.id;
        }

        function markStars(id) {
            switch (id) {
                case "star1":
                case "star1Modal":
                    addSelectedClassToStar("star1");
                    addSelectedClassToStar("star1Modal");

                    removeSelectedClassFromStar("star2");
                    removeSelectedClassFromStar("star3");
                    removeSelectedClassFromStar("star4");
                    removeSelectedClassFromStar("star5");
                    removeSelectedClassFromStar("star2Modal");
                    removeSelectedClassFromStar("star3Modal");
                    removeSelectedClassFromStar("star4Modal");
                    removeSelectedClassFromStar("star5Modal");
                    jQuery("#starRating").val(1);
                    break;
                case "star2":
                case "star2Modal":
                    addSelectedClassToStar("star1");
                    addSelectedClassToStar("star2");
                    addSelectedClassToStar("star1Modal");
                    addSelectedClassToStar("star2Modal");

                    removeSelectedClassFromStar("star3");
                    removeSelectedClassFromStar("star4");
                    removeSelectedClassFromStar("star5");
                    removeSelectedClassFromStar("star3Modal");
                    removeSelectedClassFromStar("star4Modal");
                    removeSelectedClassFromStar("star5Modal");
                    jQuery("#starRating").val(2);
                    break;
                case "star3":
                case "star3Modal":
                    addSelectedClassToStar("star1");
                    addSelectedClassToStar("star2");
                    addSelectedClassToStar("star3");
                    addSelectedClassToStar("star1Modal");
                    addSelectedClassToStar("star2Modal");
                    addSelectedClassToStar("star3Modal");

                    removeSelectedClassFromStar("star4");
                    removeSelectedClassFromStar("star5");
                    removeSelectedClassFromStar("star4Modal");
                    removeSelectedClassFromStar("star5Modal");
                    jQuery("#starRating").val(3);
                    break;
                case "star4":
                case "star4Modal":
                    addSelectedClassToStar("star1");
                    addSelectedClassToStar("star2");
                    addSelectedClassToStar("star3");
                    addSelectedClassToStar("star4");
                    addSelectedClassToStar("star1Modal");
                    addSelectedClassToStar("star2Modal");
                    addSelectedClassToStar("star3Modal");
                    addSelectedClassToStar("star4Modal");

                    removeSelectedClassFromStar("star5");
                    removeSelectedClassFromStar("star5Modal");
                    jQuery("#starRating").val(4);
                    break;
                case "star5":
                case "star5Modal":
                    addSelectedClassToStar("star1");
                    addSelectedClassToStar("star2");
                    addSelectedClassToStar("star3");
                    addSelectedClassToStar("star4");
                    addSelectedClassToStar("star5");
                    addSelectedClassToStar("star1Modal");
                    addSelectedClassToStar("star2Modal");
                    addSelectedClassToStar("star3Modal");
                    addSelectedClassToStar("star4Modal");
                    addSelectedClassToStar("star5Modal");
                    jQuery("#starRating").val(5);
                    break;
            }
        }

        function cancelStarRating() {
            if (defaultRating == 0) {
                removeSelectedClassFromStar("star1");
                removeSelectedClassFromStar("star1Modal");

                removeSelectedClassFromStar("star2");
                removeSelectedClassFromStar("star3");
                removeSelectedClassFromStar("star4");
                removeSelectedClassFromStar("star5");
                removeSelectedClassFromStar("star2Modal");
                removeSelectedClassFromStar("star3Modal");
                removeSelectedClassFromStar("star4Modal");
                removeSelectedClassFromStar("star5Modal");
                jQuery("#starRating").val(null);
            } else {
                markStars('star' + defaultRating)
                jQuery("#starRating").val(defaultRating);
            }
        }

        function addSelectedClassToStar(id) {
            document.getElementById(id).classList.add("star-selected");
        }

        function removeSelectedClassFromStar(id) {
            document.getElementById(id).classList.remove("star-selected");
        }

        function modalFunction() {
            jQuery('.modal-backdrop').hide();
            jQuery("#mediumModal").modal('hide');
        }

        function showToast() {
            toast.style.display = "block";

            setTimeout(function() {
                hideToast("social");
            }, DELAYXX);
        }

        function hideToast(id) {
            document.getElementById(id).style.display = "none";
        }

        jQuery('#mediumModal').on('hidden.bs.modal', function(e) {
            cancelStarRating();
        })
    </script>

    <script>
        jQuery(document).ready(function() {
            jQuery('.basic-multiple').select2();
        });
    </script>
@endsection

