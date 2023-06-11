@extends('layouts.user_panel') <!-- Extending the user_panel layout -->

@section('content') <!-- Start of content section -->

    <style> <!-- Inline CSS styles -->

        /* CSS styles for various classes */

        .cursor-pointer {
            cursor: pointer;
        }

        .fixed-height {
            height: 115px;
        }

        .fit {
            object-fit: cover;
        }

        .camera-icon {
            /* Styles for the camera icon */
            position: absolute;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            bottom: 5px;
            right: 8px;
            background-color: white;
        }

        .icon-label {
            /* Styles for the icon label */
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* CSS styles for smaller screens */
        @media only screen and (max-width: 1200px) {
            .fixed-height {
                height: auto;
            }
        }

    </style>

    <div class="content">
        <div class="card-header text-center text-white bg-dark border-bottom" style="margin-bottom: 2%">
            <h4>Manage Your Profile ({{ $card->card_name }})</h4>
        </div>

        <form action="{{ route('user.profile.card.edit.submit', $card->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf <!-- CSRF protection -->

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card-header text-center text-white bg-dark">
                        <h5>Necessary</h5>
                    </div>

                    <div class="shadow">
                        @php
                            $necessary = ['email', 'phone', 'job', 'rating']; // Array of necessary items
                        @endphp

                        <div class="row">
                            @foreach ($necessary as $item)
                                <div class="col-sm-12 col-lg-3 col-md-6 d-flex flex-column justify-content-between">
                                    <div class="align-items-start p-1">
                                        <h5 class="mb-1">{{ ucwords($item) }}</h5>
                                        <select id="{{ $item }}_idX"
                                            name="{{ $item == 'job' || $item == 'rating' ? $item : 'social[' . $item . ']' }}"
                                            class="form-control">

                                            @if ($item != 'job')
                                                @if (isset($card->permissions['social'][$item]) && $card->permissions['social'][$item] == 'visible')
                                                    <!-- If social item is set and visible, mark as selected -->
                                                    <option selected name="visible">visible</option>
                                                    <option name="hide">hide</option>
                                                @elseif($item=='rating' && isset($card->permissions[$item]) &&
                                                    $card->permissions[$item] == 'visible')
                                                    <!-- If rating is set and visible, mark as selected -->
                                                    <option selected name="visible">visible</option>
                                                    <option name="hide">hide</option>
                                                @else
                                                    <option name="visible">visible</option>
                                                    <option selected name="hide">hide</option>
                                                @endif
                                            @else
                                                <!-- Custom job option -->
                                                <option selected name="custom" value="custom">Custom Job</option>
                                                <option name="job1">Student</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="col-md-6" style="margin-bottom:1.5rem;">
                    <div class="card-header text-center text-white bg-dark">
                        <h5>Social</h5>
                    </div>

                    <div class="shadow">
                        <div class="container">
                            @php
                                $listSocials = \App\Models\Variable::getProviderMap(); // Get social providers
                            @endphp

                            <div class="row">
                                @foreach ($listSocials as $social_item => $value)
                                    @if (isset($value['provider']) && $value['provider'] == 'Social')
                                        <div class="col-sm-12 col-lg-3 col-md-6 d-flex flex-column justify-content-between">
                                            <div class="align-items-start p-1">
                                                <h5 class="mb-1">{{ ucwords($social_item) }}</h5>
                                                <select name="social[{{ $social_item }}]" class="form-control">

                                                    @if (isset($card->permissions['social'][$social_item]) && $card->permissions['social'][$social_item] == 'visible')
                                                        <!-- If social item is set and visible, mark as selected -->
                                                        <option selected name="visible">visible</option>
                                                        <option name="hide">hide</option>
                                                    @else
                                                        <option name="visible">visible</option>
                                                        <option selected name="hide">hide</option>
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <div id="customJob" class="col-12" style="display: none">
                    <div id="customJobInner">
                        <div class="card-header text-center text-white bg-dark w-100">
                            <h5>Customize Your Company</h5>
                        </div>

                        <div class="shadow">
                            <div class="row card-body card-block">
                                @php
                                    $company_arrr = ['name', 'position', 'logo', 'website', 'phone', 'email']; // Array of company fields
                                @endphp

                                <div class="mx-auto d-block col-lg-12 col-md-12 col-sm-12 ">
                                    <div class="position-relative mx-auto" style="width: 100px; height: 100px;margin-bottom:2rem">
                                        <img id="profilePicture" class="rounded-circle fit" @if (isset($card->permissions['company']['logo']))
                                            src="{{ asset('uploads/company/' . $card->permissions['company']['logo']) }}"
                                        @else
                                            src="{{ asset('uploads/company/default.png') }}"
                                        @endif
                                        alt="Your Picture" width="100%" height="100%">

                                        <div class="camera-icon shadow">
                                            <label for="photo-input" class="icon-label">
                                                <i class="fa fa-camera cursor-pointer"></i>
                                            </label>
                                            <input name='logo_company' onchange="setImage(event)" type="file" id="photo-input" hidden>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($company_arrr as $item)
                                    @if ($item == 'logo')
                                        @continue
                                    @endif
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label for="company" class=" form-control-label">Company {{ ucwords($item) }}</label>
                                        <input type="text" id="company_{{ $item }}" name="company[{{ $item }}]"
                                            @if (isset($card->permissions['company'][$item]))
                                                value="{{ $card->permissions['company'][$item] }}"
                                            @endif
                                            placeholder="Enter your company {{ $item }}" class="form-control">
                                    </div>
                                @endforeach

                                <h6 class="card-body card-block" style="margin-left: 1rem;margin-bottom: 1rem;color:red">
                                    *This customized company will show 'not-verified' to viewers
                                </h6>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <button style="margin-left:0rem;; margin-top:1rem; margin-right:1rem" type="submit"
                    class="btn btn-primary btn-lg btn-block">Submit Info</button>
            </div>
        </form>
    </div>

    @if (strtolower($card->card_name) != 'public')
        <div class="row mb-4">
            <form action="{{ route('user.profile.card.delete', $card->id) }}" method="POST">
                @csrf
                <div class="col-lg-12 col-sm-12">
                    <button style="margin-left:0rem;; margin-top:0rem; margin-right:1rem" type="submit"
                        class="btn btn-secondary btn-lg btn-block">Delete Card</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

@section('js')
<script>
    var customJobInner = jQuery('#customJobInner').clone(true);
    jQuery('#customJobInner').remove();
    showCustomJob();

    function showCustomJob() {
        var sel = jQuery('#job_idX').find(":selected").attr("name");
        console.log(sel);

        if (sel == "custom") {
            jQuery('#customJob').append(customJobInner);
            jQuery('#customJob').show();
        } else {
            jQuery('#customJobInner').remove();
        }
    }

    jQuery('#job_idX').on('change', function(e) {
        showCustomJob();
        console.log("Job Changed");
    });

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
@endsection
