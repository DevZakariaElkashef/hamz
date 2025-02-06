@extends('layouts.master2')
@section('title')
@endsection
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets/img/media/login.png') }}"
                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h5 class="font-weight-semibold mb-4">
                                                {{ __('main.Please_sign_in_to_continue.') }}</h5>
                                            <form action="{{ route('login') }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label>{{ __('main.email') }}</label> <input class="form-control"
                                                        placeholder="{{ __('main.Enter_your_email') }}" name="email"
                                                        required type="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('main.password') }}</label> <input class="form-control"
                                                        placeholder="{{ __('main.Enter_your_password') }}" name="password"
                                                        required type="password">
                                                    @error('password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Remember Me -->
                                                <div class="block mt-4">
                                                    <label for="remember_me" class="inline-flex items-center">
                                                        <input id="remember_me" type="checkbox"
                                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                            name="remember">
                                                        <span
                                                            class="ms-2 text-sm text-gray-600">{{ __('main.Remember_me') }}</span>
                                                    </label>
                                                </div>

                                                <button type="submit"
                                                    class="btn btn-main-primary btn-block">{{ __('main.login') }}</button>

                                            </form>
                                            <div class="main-signin-footer mt-2">
                                                <p><a
                                                        href="{{ route('password.request') }}">{{ __('main.Forgot_password?') }}</a>
                                                </p>
                                            </div>
                                            <div class="main-signin-footer mt-2">
                                                <p><a href="{{ route('signup') }}">{{ __('main.dont_have_account') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
@endsection
