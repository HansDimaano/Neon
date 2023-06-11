@extends('layouts.user_panel')

@section('content')
    <div class="container">
        <div class="row justify-content-center " id="content" style="margin-top: 3rem">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="blankgg" style="height: 0;">&nbsp;
        </div>
    </div>
@endsection

@section('js')
    <script>
        var window_height = jQuery(window).height();
        var window_width = jQuery(window).width();
        var content_height = jQuery('#content').height();
        var header_height = jQuery('#header').height();
        setTimeout(setFooterDistance, 300);
        console.log(window_height);

        jQuery(window).resize(function() {
            window_height = jQuery(window).height();
            window_width = jQuery(window).width();
            content_height = jQuery('#content').height();
            header_height = jQuery('#header').height();
            setTimeout(setFooterDistance, 500);
        });

        jQuery(function() {
                jQuery('#blank').css('height', jQuery(window).height() - jQuery('html').height() + 'px');
            });
    </script>
@endsection
