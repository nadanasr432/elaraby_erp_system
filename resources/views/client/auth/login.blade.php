@extends('site.layouts.app-main')
<style>
    .leftEng {
        text-align: left;
        direction: ltr !important;
    }

    .starEN {
        float: right;
        margin-left: 7px !important;
    }

    footer {
        display: none !important;
    }
</style>
@section('content')
    <!--begin::Login-->
    <div class="row overflow-hidden"
        @if (Config::get('app.locale') == 'en') style="direction: ltr; margin: 0; height: 100%; width: 100%;" @else style="direction: rtl; margin: 0; height: 100%; width: 100%;" @endif>
        <!--begin::Aside-->
        <div class="col-md-6 d-flex align-items-center justify-content-center" style="padding: 20px;">
            <!--begin: Aside Container-->
            <div class="d-flex flex-column-fluid flex-column justify-content-center px-md-3 px-sm-2 p-1" style="width: 100%;">
                <!--begin::Logo-->
                <a class="mb-2 text-center" href="/">
                    <h4 class="@if (Config::get('app.locale') == 'en') text-left @else text-right @endif" style="color: #1e2246;">
                        {{ __('main.welcome') }}
                    </h4>
                    <br>
                    <h4 class="@if (Config::get('app.locale') == 'en') text-left @else text-right @endif"
                        style="font-family: Tajawal; font-size: 24px; font-weight: 500; line-height: 33.6px; color: #637381;">
                        {{ __('main.welcome2') }}
                    </h4>
                </a>
                <!--end::Logo-->
                <!--begin::Signin-->
                <div class="login-form login-signin py-4">
                    <form class="account-form" method="POST" action="{{ route('client.login') }}">
                        @csrf
                        <!--email-->
                        <div class="form-group fv-plugins-icon-container">
                            <label
                                class="text-dark mb-2 @if (Config::get('app.locale') == 'en') text-left @else text-right @endif"
                                style="font-family: Cairo; font-size: 18px; font-weight: 500; line-height: 33.6px;">
                                {{ __('main.email') }}
                                <span class="font-weight-bold text-danger">*</span>
                            </label>
                            <input class="form-control py-7 px-6 rounded-lg" type="text" value="{{ old('email') }}"
                                placeholder="{{ __('main.email') }}" name="email" required="" autocomplete="off"
                                style="height: 60px; background:white">
                            @error('email')
                                <span style="direction: rtl!important; text-align: right!important;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!--password-->
                        <div class="form-group fv-plugins-icon-container">
                            <label
                                class="text-dark mb-2 @if (Config::get('app.locale') == 'en') text-left @else text-right @endif"
                                style="font-family: Cairo; font-size: 18px; font-weight: 500; line-height: 33.6px;">
                                {{ __('main.password') }}
                                <span class="font-weight-bold text-danger">*</span>
                            </label>
                            <input class="form-control py-7 px-6 rounded-lg border" type="password" name="password"
                                id="pass3" autocomplete="off" required="" placeholder="{{ __('main.password') }}"
                                style="height: 60px;">
                            @error('password')
                                <span class="text-right" dir="rtl" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!--forget password-->
                        @if (Route::has('client.password.request'))
                            <div class="form-group text-right mt-3" dir="rtl">
                                <a href="{{ route('client.password.request') }}" class="forget-pass"
                                    style="color: #20779C !important;">
                                    {{ __('main.forget-your-password') }}
                                </a>
                            </div>
                        @endif
                        <!--login button-->
                        <div class="text-center pt-2">
                            <button type="submit" class="btn btn-dark font-weight-bolder"
                                style="background: #20779C; padding: 15px 30px; font-size: 15px; height: 65px; border-radius: 10px; border: none;">
                                {{ __('main.login') }}
                            </button>
                            <a href="{{ route('index3') }}" class="font-weight-bolder d-block mt-3"
                                style="font-size: 15px; color: #20779C;">
                                <span style="color: black; font-family: Tajawal; font-size: 15px; font-weight: 500;">
                                    {{ __('main.no-account') }}
                                </span>
                                {{ __('main.register') }}
                            </a>
                        </div>
                    </form>
                </div>
                <!--end::Signin-->
            </div>
            <!--end: Aside Container-->
        </div>
        <!--begin::Content-->
        <div class="col-md-6 d-none d-md-block"
            style="background-image: url('{{ asset('images/login_bg.png') }}'); background-size: cover;">
            <!--begin::Image-->
            <div
                class="content-img d-flex align-items-end justify-content-center h-100 w-100 bgi-no-repeat bgi-position-center">
                <!-- Optional content here -->
            </div>
            <!--end::Image-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
@endsection
