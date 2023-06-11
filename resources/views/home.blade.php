@extends('layouts.user_panel')

@section('content')
    <style>
        #weatherWidget .currentDesc {
            color: #ffffff !important;
        }

        .traffic-chart {
            min-height: 335px;
        }

        #flotPie1 {
            height: 150px;
        }

        #flotPie1 td {
            padding: 3px;
        }

        #flotPie1 table {
            top: 20px !important;
            right: -10px !important;
        }

        .chart-container {
            display: table;
            min-width: 270px;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #flotLine5 {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }

        #cellPaiChart {
            height: 160px;
        }
    </style>

    @php
    // PHP code block within the template
        $user = Auth::user();
        $ratings = $user->ratings();
        $rating = $ratings->avg('rating');
        $rating = $rating == null ? 0 : $rating;
        $review = $ratings->count();
    @endphp

    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- Widgets  -->
            <div class="row justify-content-center">

                <div class="col-12">
                    <div class="row" style="max-width: 800px;margin:auto">
                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-1">
                                            <i class="fa fa-hand-o-right"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib"> <!-- Follower Count -->
                                                <div class="stat-text"><span class="count">{{ $user->followers()->count() }}</span></div>
                                                <div class="stat-heading">Follower</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-2">
                                            <i class="fa fa-hand-o-left"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib"><!-- Following Count -->
                                                <div class="stat-text"><span 
                                                        class="count">{{ $user->following()->count() }}</span></div>
                                                <div class="stat-heading">Following</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-3">
                                            <i class="pe-7s-browser"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib"><!-- Views Count -->
                                                <div class="stat-text"><span class="count">{{ $user->views }}</span></div>
                                                <div class="stat-heading">Views</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-4">
                                            <i class="fa fa-star-half-full"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib"><!-- Rating Count -->
                                                <div class="stat-text"><span class="">{{ $rating }}</span></div>
                                                <div class="stat-heading">Rating</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">

                    <div class="card" style="max-width: 790px;margin:auto">
                        <div class="card-header">Whats on your mind?</div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <form method="post" action="{{ route('user.profile.status.create') }}" enctype="multipart/form-data" class="w-100">
                                @csrf

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-laptop"></i>
                                        </div>
                                        <textarea name="status" type="text" class="form-control" placeholder="Write your thoughts" required></textarea>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="mx-auto d-block">
                                        <div class="mx-auto" style="height: 300px; margin-top: 40px">
                                                <label style="width:100%; height: 100%; display: flex; flex-direction: column" for="photo-input" class="icon-label justify-content-center">
                                                    <div style="margin-bottom: 10px"><i class="fa fa-photo" style="margin-right: 5px"></i>Upload Photo</div>
                                                    <img id="profilePicture" style="object-fit: contain"
                                                src="images/image_add.png" alt="Your Picture" height="100%">
                                                </label>
                                                <input class="w-100" style="margin:auto;border:2px" name='image' onchange="setImage(event)" type="file" id="photo-input"
                                                    hidden>

                                        </div>

                                    </div>

                                </div>
                                <div class="form-group">
                                <div class="container mt-5 input-group">
                                    <label style="width:100%" for="ll-input" class="icon-label justify-content-center">
                                        <i class="fa fa-users "></i>
                                        Tag
                                    </label>
                                    <select class="basic-multiple w-100" name="tags[]" multiple="multiple">

                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{$user->id}}">{{$user->username}}</option><!-- Username -->
                                        @endforeach
                                    </select>

                                </div>
                                </div>
                                <div class="form-actions form-group mt-5">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Upload Status
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


                @php
                    $status = \App\Models\Status::orderBy('id', 'desc')->get();
                @endphp

                @foreach ($status as $item)
                    <div class="col-12">

                        <div class="card mt-4" style="max-width: 790px;margin:auto">
                            <div class="card-header">

                                </br>

                                <div class="d-flex justify-content-start ml-3">
                                    <a href="#"><!-- User Profile Picture -->
                                        <img style="height:50px;width:50px;" class="pimg rounded-circle mr-3 fit"
                                            style="object-fit: cover;" alt=""
                                            @if ($user->profilePicture != null) src="uploads/user/{{ $item->user->profilePicture->name }}"
                                            @else
                                            src="images/avatar.png" alt="User Avatar" @endif></a>
                                    <div style="max-height: 40px"
                                        class="profile-name-holder d-flex flex-column justify-content-center">
                                        <h2 style="margin-top: -40px" class=" display-6">
                                            </br><!-- User First and Last Name -->
                                            <h6 class="pt-1" style="font-weight: 600">{{ $item->user->fname . ' ' . $item->user->lname }}</h6>
                                            @if ($item->tags->count()!=0)
                                            <span style="font-size: 13px">With
                                                @foreach ($item->tags as $tag)
                                                    @if ($loop->index!=0)
                                                    ,
                                                    @endif
                                                    <a href="{{route('user.profile',$tag->user->id)}}" >{{$tag->user->username}}</a> <!-- Tagged People -->
                                                @endforeach
                                            </span>
                                            @endif

                                            <span style="font-size: 11px">{{ $item->created_at }}</span> <!-- Creation Timestamp -->
                                        </h2>

                                    </div>
                                </div>
                                @auth
                                    @if (auth::user()->id == $item->user->id)
                                        <a class="pl-2 btn" href="" style="font-size: 12px; background-color:red; color:white; margin-top: 20px; padding: 0.375rem 0.75rem !important;"
                                            onclick="event.preventDefault();
                                            document.getElementById('comment-del-form-{{ $item->id }}').submit();">Delete</a> <!-- Delete Post -->

                                        {{-- <a class="pl-4" href="" style="font-size: 12px; background-color:green; color:white; text-align:center; padding: 0.375rem 0.75rem !important;">Edit</a> --}}
                                        <a type="button" class="pl-2 btn" style="font-size: 12px; background-color:green; color:white; margin-top: 20px; padding: 0.375rem 0.75rem !important;" data-toggle="modal" data-target="#editModal{{$item->id}}">Edit</a> <!-- Edit Post -->

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
                                        <span><span class="p-0" style="font-weight: bold">{{$item->likes->count()}}</span>&nbsp;likes</span> <!-- Like Count -->
                                        <a class="pl-3" href="" style="font-size: 14px; @if($item->isLikedBy(auth::user())!==0) color:#28a745 @else color:black @endif; font-weight:bold"
                                            onclick="event.preventDefault();
                                            document.getElementById('comment-like-form-{{ $item->id }}').submit();">@if($item->isLikedBy(auth::user())!==0)Liked @else Like @endif</a> <!-- Like Button -->

                                        <form id="comment-like-form-{{ $item->id }}"
                                            action="{{ route('user.profile.status.like') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="status_id" value="{{ $item->id }}">
                                        </form>


                                @endauth
                                        &nbsp;
                            </div>

                            <div class="card-body d-flex flex-column "><!-- Comments -->
                                @foreach ($item->comments as $comment)
                                    <div class="p-2 mt-3" style="background-color: #92f7ca; border-radius: 10px;">
                                    <span style="font-size: 15px; font-weight:600; color:black; background-color: #92f7ca; margin-right: 5px">{{$comment->user->fname}}</span> <!--Username of Comment -->
                                    <span style="font-size: 12px;color:rgb(97, 97, 97); background-color: #92f7ca">{{$comment->created_at}}</span> <!-- Comment Timestamp -->
                                    <h5 style=" background-color: #92f7ca; margin-top: 10px; margin-bottom: 5px">{{$comment->body}}</h5> <!-- Comment Text -->
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
                                                        <textarea name="status" type="text" class="form-control" placeholder="Share a colorful neon today!" required>{{$item->body}}</textarea>

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
                                </div>

                            </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </div>


    <script>


        // Define a constant variable for the delay duration
        const DELAYXX = 1500;

        // Function to show the toast with the given id
        function showToast(event, id) {
            // Display the toast element
            document.getElementById(id).style.display = "block";

            // Set a timeout to hide the toast after the specified delay
            setTimeout(function() {
                hideToast(id);
            }, DELAYXX);
        }

        // Function to hide the toast with the given id
        function hideToast(id) {
            // Hide the toast element
            document.getElementById(id).style.display = "none";
        }

        // Function to handle the image upload
        function setImage(event) {
            var target = event.target || window.event.srcElement;
            files = target.files;

            // Check if FileReader is supported and files are selected
            if (FileReader && files && files.length) {
                var fileReader = new FileReader();

                // When the FileReader has loaded the image, update the profile picture element with the image data
                fileReader.onload = function() {
                    document.getElementById("profilePicture").src = fileReader.result;
                }

                // Read the selected file as a data URL
                fileReader.readAsDataURL(files[0]);
            }
        }

    </script>


@endsection

@section('js')
    <script>
        jQuery(document).ready(function() {
            jQuery('.basic-multiple').select2();
        });
    </script>
@endsection
