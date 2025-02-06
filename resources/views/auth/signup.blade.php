@extends('layouts.master2')
@section('title')
@endsection
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
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
                                                {{ __('main.signup_new_vendor') }}</h5>
                                            <form action="{{ route('signup') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <label class="custom-file-label"
                                                            for="customFile">{{ __('main.image') }}</label>
                                                        <input class="custom-file-input" id="customFile" type="file"
                                                            name="image">
                                                        @error('image')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('main.name') }}</label> <input class="form-control"
                                                        placeholder="{{ __('main.Enter_your_name') }}" name="name"
                                                        required type="name" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('main.email') }}</label> <input class="form-control"
                                                        placeholder="{{ __('main.Enter_your_email') }}" name="email"
                                                        required type="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('main.phone') }}</label> <input class="form-control"
                                                        placeholder="{{ __('main.Enter_your_phone') }}" name="phone"
                                                        required type="phone" value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('main.city') }}</label>
                                                    <select required class="form-control select2" name="city_id">
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                @if (old('city_id') == $city->id) selected @endif>
                                                                {{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('city_id')
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
                                                <div class="form-group">
                                                    <label>{{ __('main.password_confirmation') }}</label> <input
                                                        class="form-control"
                                                        placeholder="{{ __('main.Enter_your_password_confirmation') }}"
                                                        name="password_confirmation" required type="password">
                                                    @error('password_confirmation')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <button type="submit"
                                                    class="btn btn-main-primary btn-block">{{ __('main.signup') }}</button>

                                            </form>
                                            <div class="main-signin-footer mt-2">
                                                <p><a href="{{ route('login') }}">{{ __('main.have_account') }}</a>
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

@section('js')
    <!--Internal  Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection
