<!DOCTYPE html>
<html class="loading" lang="{{ LaravelLocalization::getCurrentLocale() }}">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{ $system->name }} </title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @include('site.layouts.common.css_links')
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("{{ asset('fonts/Cairo.ttf') }}");
        }

        body,
        html {
            font-family: 'Cairo' !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span {
            font-family: 'Cairo' !important;
        }

        .dropdown-item {
            font-size: 14px !important;
        }

        @media screen and (max-width: 992px) {
            .loginBtnAni {
                min-width: 125px !important;
            }

            .partSpan {
                width: 42% !important;
            }

            .fadeBottom {
                width: 186% !important;
            }

            .footer-top {
                display: block !important;
            }

            ul.social-icons {
                display: flex !important;
                justify-content: center !important;
            }

            ul.links {
                display: flex;
                justify-content: center;
            }

            .footer-bottom .left {
                margin-bottom: 25px;
                margin-right: 13%;
                font-size: 14px;
            }
        }

        .registerBtn {
            border: 1px solid white;
            border-radius: 5px;
            padding: 5px 12px !important;
        }

        .loginBtn {
            border: 1px solid #E0A93D;
            border-radius: 5px;
            padding: 5px 12px !important;
            background: #E0A93D;
            transition: all 0.2s ease-in-out;
        }

        .subscribNow {
            border: 1px solid #E0A93D;
            color: #E0A93D !important;
            border-radius: 5px;
            padding: 5px 12px !important;
            background: none;
        }

        @if (LaravelLocalization::getCurrentLocale() == 'ar')

        @else
            .subscribNow {
                float: left;
            }
        @endif
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-206753129-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-206753129-1');
    </script>
    <meta name="facebook-domain-verification" content="zlq809za71vnn8lrol6xpfyif2ge02" />

    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '4421747707915385');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=4421747707915385&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->

</head>

<body
    @if (LaravelLocalization::getCurrentLocale() == 'ar') style="direction:rtl;text-align:right"
    @else style="direction:ltr;text-align:left" @endif>

    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>




    <div class="overlay"></div>
    <a href="#0" class="scrollToTop pt-2">
        <i class="fa fa-angle-up" style="font-size: 26px;"></i>
    </a>


    <header class="header-section" style="background: rgba(0, 0, 0, 0.055);">

        <div class="header-wrapper pr-5 pl-5" style="@if (LaravelLocalization::getCurrentLocale() == 'en') direction: ltr; @endif">
            <div class="logo text-center">
                <a class="text-center" href="{{ route('index') }}">
                    @if (empty($system->profile->profile_pic))
                        <img style="height: 65px;margin-top: 10px; margin-bottom: 10px;"
                            src="{{ asset('images/soft.png') }}" alt="logo">
                    @else
                        <img style="height: 55px;margin-top: 10px; margin-bottom: 10px;"
                            src="{{ asset($system->profile->profile_pic) }}" alt="logo">
                    @endif
                </a>
                <br>
            </div>

            <!--pages list -home -contact ... -->
            <ul style="@if (LaravelLocalization::getCurrentLocale() == 'en') direction: ltr; @endif" class="menu">
                <li>
                    <a class="active" href="{{ route('index') }}">
                        {{ __('main.home') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}">
                        {{ __('main.features') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('index') }}">
                        {{ __('main.einvoice') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('contact') }}">
                        {{ __('main.contact-us') }}
                    </a>
                </li>
            </ul>


            <!--actions list-- login register lang-->
            <ul style="@if (LaravelLocalization::getCurrentLocale() == 'en') direction: ltr; @endif" class="menu actionsBtn">


                @if (!auth()->guard('client-web')->check())
                    <li>
                        <a class="registerBtn loginBtnAni" href="{{ route('index3') }}">
                            {{ __('main.register') }}
                        </a>
                    </li>

                    <li>
                        <a class="loginBtn" href="{{ route('client.login') }}">
                            {{ __('main.login') }}
                        </a>
                    </li>
                @else
                    <li>
                        <a class="loginBtn" href="{{ route('client.home') }}">
                            {{ __('main.home') }}
                        </a>
                    </li>
                @endif

                <li>
                    @if (LaravelLocalization::getCurrentLocale() == 'ar')
                        <a href="{{ LaravelLocalization::getLocalizedURL('en') }}">
                            <img src="https://img.icons8.com/color/30/000000/great-britain.png" />
                            {{ __('main.english') }}
                        </a>
                    @else
                        <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}">
                            <img src="https://img.icons8.com/color/30/000000/saudi-arabia.png" />
                            {{ __('main.arabic') }}
                        </a>
                    @endif
                </li>
            </ul>


            <div class="header-bar d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

    </header>


    @yield('content')


    <footer class="footer-section"
        style="background: linear-gradient(180deg, #20779C 0%, #065272 100%);padding-top: 213px;clip-path: polygon(0 0, 0% 20%, 0 53%, 0 100%, 18% 100%, 50% 100%, 100% 100%, 100% 80%, 100% 0, 64% 24%, 100% 38%, 100% 37%);">
        <div class="filled-area"
            style=" background: linear-gradient(180deg, #E0A93D 0%, #C89531 100%);
            clip-path: polygon( 100% 0, 64% 24%, 100% 38%, 100% 37%);">
        </div>
        <div class="container">
            <div class="footer-top pb-4 @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                <div
                    class="col-md-4 mt-5 mb-0 pl-0 logo @if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                    <a href="{{ route('index') }}">
                        @if (empty($system->profile->profile_pic))
                            <img style="width: 80px!important;height: 80px!important;"
                                src="{{ asset('images/soft.png') }}" alt="footer">
                        @else
                            <img style="width: 80px!important;height: 80px!important;"
                                src="{{ asset($system->profile->profile_pic) }}" alt="footer">
                        @endif
                    </a>
                    <br>
                    <br>
                    <p style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                        {{ __('main.footer1') }}
                        <br>
                        {{ __('main.footer2') }}
                        <br>
                        {{ __('main.footer3') }}
                    </p>

                </div>

                <div class="col-md-2 mt-5 p-0 logo ">
                    <p style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                        {{ __('main.footer4') }}
                        <img style="width: 35%; display: block; margin-right: 7px; @if (LaravelLocalization::getCurrentLocale() == 'en') left: 0; position: absolute; @endif"
                            src="{{ asset('images/zigzag.png') }}">
                    </p>
                    <br>
                    <ul class="mt-0">
                        <li style="margin-top: -40px;">
                            <a class="pt-2" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">

                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif " src="{{ asset('images/mask.png') }}">
                                {{ __('main.home') }}
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                  
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif "
                                    src="{{ asset('images/mask.png') }}">
                                {{ __('main.pricing') }}
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif " src="{{ asset('images/mask.png') }}">
                                {{ __('main.services') }}
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                  
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif "
                                    src="{{ asset('images/mask.png') }}">
                                {{ __('main.apps') }}
                            </a>
                        </li>

                    </ul>

                </div>

                <div
                    class="col-md-3  mt-5  p-0 logo @if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                    <p style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                        {{ __('main.footer4') }}
                        <img style="width: 24%; display: block; margin-right: 7px; @if (LaravelLocalization::getCurrentLocale() == 'en') left: 0; position: absolute; @endif"
                            src="{{ asset('images/zigzag.png') }}">
                    </p>
                    <br>
                    <ul>
                        <li style="margin-top: -40px;">
                            <a class="pt-2" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif " src="{{ asset('images/mask.png') }}">
                                {{ __('main.eInvoice') }}
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                  
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif "
                                    src="{{ asset('images/mask.png') }}">
                                {{ __('main.successPar') }}
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif " src="{{ asset('images/mask.png') }}">
                                {{ __('main.subscription') }}
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                  
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif "
                                    src="{{ asset('images/mask.png') }}">
                                {{ __('main.reviews') }}
                            </a>
                        </li>

                    </ul>

                </div>

                <div
                    class="col-md-3  mt-5  p-0 logo @if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                    <p style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                        {{ __('main.contact2') }}
                        <img style="width: 24%; display: block; margin-right: 7px; @if (LaravelLocalization::getCurrentLocale() == 'en') left: 0; position: absolute; @endif"
                            src="{{ asset('images/zigzag.png') }}">
                    </p>
                    <br>
                    <ul>
                        <li style="margin-top: -40px;">
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @endif" width="13"
                                    fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path
                                        d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                </svg>
                                <span class="mr-1">{{ __('main.loc') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @endif" width="18"
                                    fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path
                                        d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0l57.4-43c23.9-59.8 79.7-103.3 146.3-109.8l13.9-10.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176V384c0 35.3 28.7 64 64 64H360.2C335.1 417.6 320 378.5 320 336c0-5.6 .3-11.1 .8-16.6l-26.4 19.8zM640 336a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L480 353.4l60.7-60.7c6.2-6.2 16.4-6.2 22.6 0z" />
                                </svg>
                                <span class="mr-1">support@soft-klik.com</span>
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" target="_blank"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @endif" width="18"
                                    fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M280 0C408.1 0 512 103.9 512 232c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-101.6-82.4-184-184-184c-13.3 0-24-10.7-24-24s10.7-24 24-24zm8 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-72c0-13.3 10.7-24 24-24c75.1 0 136 60.9 136 136c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-48.6-39.4-88-88-88c-13.3 0-24-10.7-24-24zM117.5 1.4c19.4-5.3 39.7 4.6 47.4 23.2l40 96c6.8 16.3 2.1 35.2-11.6 46.3L144 207.3c33.3 70.4 90.3 127.4 160.7 160.7L345 318.7c11.2-13.7 30-18.4 46.3-11.6l96 40c18.6 7.7 28.5 28 23.2 47.4l-24 88C481.8 499.9 466 512 448 512C200.6 512 0 311.4 0 64C0 46 12.1 30.2 29.5 25.4l88-24z" />
                                </svg>
                                <span class="mr-1">966596698916+</span>
                            </a>
                        </li>

                    </ul>

                </div>

            </div>
            <div class="footer-bottom">
                <p class="links d-block text-center text-white" dir="rtl"
                    style="color:#f57c00; padding-right: 50px;">
                    {{ __('main.platform-copyright') }}
                    {{ $system->name }}
            </div>
        </div>
    </footer>
    @include('site.layouts.common.js_links')
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"
    integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
