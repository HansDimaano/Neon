@extends('layouts.user_panel')

@section('content')

    <style>
        .fixed-height {
            height: 315px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .display-none {
            display: none;
        }

        .fit {
            object-fit: cover;
        }

        .camera-icon {
            position: absolute;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            bottom: 5px;
            right: 8px;
            background-color: white;
        }

        .icon-label {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media only screen and (max-width: 992px) {
            .fixed-height {
                height: auto;
            }
        }

    </style>

    <div class="content">
        <div class="row">

            <div class="col-lg-12 position-relative display-none mx-auto text-center" id="bioToast"
                style="z-index: 9; width: 90%;">
                <div class="position-absolute">
                    <div class="p-2 bg-light text-dark margin: auto">
                        <span class="badge badge-success">
                            Success
                        </span>
                        {{ $success }}
                    </div>
                </div>
            </div>

            <div class="col-lg-6">

                <div class="card">
                    <div class="card-header w-100">
                        <i class="fa fa-user d-inline"></i><strong class="card-title pl-2 d-inline">Your Profile</strong>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('user.profile.edit.submit') }}" enctype="multipart/form-data" method="POST"
                            class="w-100">
                            @csrf
                            <div class="form-group">
                                <div class="mx-auto d-block">
                                    <div class="position-relative mx-auto" style="width: 100px; height: 100px;">
                                        <img id="profilePicture" class="rounded-circle fit" @if (Auth::user()->profilePicture != null)
                                        src="uploads/user/{{ Auth::user()->profilePicture->name }}"
                                    @else
                                        src="images/avatar.png"
                                        @endif

                                        alt="Your Picture" width="100%" height="100%">
                                        <div class="camera-icon shadow">
                                            <label for="photo-input" class="icon-label">
                                                <i class="fa fa-camera cursor-pointer"></i>
                                            </label>
                                            <input name='image' onchange="setImage(event)" type="file" id="photo-input"
                                                hidden>
                                        </div>
                                    </div>
                                    <h5 class="text-center mt-2 mb-1">{{ Auth::user()->fname }}</h5>
                                    <div class="location text-center"><i class="fa fa-map-marker"></i> California, United
                                        States
                                    </div>
                                </div>
                                <hr>
                                <div class="input-group mx-auto" style="width: 70%;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Bio</span>
                                    </div>
                                    <input type="text" id="bio" value="{{ Auth::user()->bio }}" name="user[bio]"
                                        placeholder="Bio..." class="form-control" />
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-button btn btn-success btn-sm">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative display-none mx-auto text-center" id="bioToast"
                                style="z-index: 9; width: 90%;">
                                <div class="position-absolute">
                                    <div class="p-2 bg-light text-dark">
                                        <span class="badge badge-success">
                                            Success
                                        </span>
                                        Your Bio has been successfully uploaded
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class=" card fixed-height">
                    <div class="card-header">Necessary Information</div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <form action="{{ route('user.profile.edit.submit') }}" method="post" class="w-100">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" id="username" name="user[username]"
                                        value="{{ Auth::user()->username }}" placeholder="username"
                                        class="form-control" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            Username
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="ti-text"></i>
                                    </div>
                                    <input type="text" id="firstname" name="user[fname]" value="{{ Auth::user()->fname }}"
                                        placeholder="First Name..." class="form-control" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            First Name
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="ti-text"></i></div>
                                    <input type="text" id="lastname" value="{{ Auth::user()->lname }}" name="user[lname]"
                                        placeholder="Last Name.." class="form-control" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            Last Name
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Save
                                </button>
                                <div class="position-relative display-none" id="necessary">
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

            <div class="col-lg-6">
                <div class="card fixed-height">
                    <div class="card-header">Contact Information</div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <form method="post" action="{{ route('user.profile.edit.submit') }}" class="w-100">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="tel" class="form-control" value="{{ Auth::user()->phone }}"
                                        name="user[phone]" placeholder="Phone Number..">
                                    <a href="tel:{{ Auth::user()->phone }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                Phone Number
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input name="user[email]" type="email" class="form-control"
                                        value="{{ Auth::user()->email }}" placeholder="Email..">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            Email Number
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Save
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

            <div class="col-lg-6">
                <div class="card fixed-height">
                    <div class="card-header">Social Accounts</div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <form action="{{route('user.profile.edit.social.submit')}}" method="post" class="w-100" >
                            @php
                                $providerPackage = \App\Models\Variable::getProviderMap();
                            @endphp
                            @csrf
                            @foreach ($providerPackage as $key => $value)
                                @if ($value['provider'] == 'Social')
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa {{$value['icon']}}"></i>
                                            </div>
                                            <input name="socials[{{$key}}]" type="text"
                                            value="{{Auth::user()->socials($key)==NULL?'':Auth::user()->socials($key)->social_id}}"
                                            class="form-control" placeholder="{{$key}}">

                                        </div>
                                    </div>
                                @endif
                            @endforeach


                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Save
                                </button>
                                <div class="position-relative display-none" id="social">
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
        </div>
    </div>


    <script>
        //if (window.history.replaceState) {
        //    window.history.replaceState(null, null, window.location.href);
        //}

        const DELAYXX = 1500;

        function showToast(event, id) {
            //event.preventDefault();
            console.log(id);
            document.getElementById(id).style.display = "block";

            setTimeout(function() {
                hideToast(id);
            }, DELAYXX);
        }

        function hideToast(id) {
            document.getElementById(id).style.display = "none";
        }

        // Upload the image
        function setImage(event) {
            var target = event.target || window.event.srcElement;
            files = target.files;

            // FileReader Support
            if (FileReader && files && files.length) {
                var fileReader = new FileReader();

                fileReader.onload = function() {
                    document.getElementById("profilePicture").src = fileReader.result;
                }

                fileReader.readAsDataURL(files[0]);
            }
        }
    </script>

    @if ($success != null)
        <script>
            showToast(event, 'bioToast');
            console.log('has success');
        </script>
    @endif
@endsection
