@extends('layouts.master')
@section('title')
    {{ __('main.General_Settings') }}
@endsection
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">{{ __('main.home') }}</h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('applications.index') }}">{{ __('main.General_Settings') }}</a></span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-4 mb-lg-0 mb-4">
            <h4>{{ __('main.settings') }}</h4>
            @include('settings._nav')


        </div>

        <!-- /Categories -->

        <!-- Article -->
        <div class="col-xl-9 col-lg-8 col-md-8">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <form action="{{ route('applications.update', $application) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name_ar">{{ __('Name') }}(AR)</label>
                                    <input id="name_ar" class="form-control" type="text" name="name_ar"
                                        value="{{ $application->name_ar }}">
                                    @error('name_ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name_en">{{ __('Name') }}(EN)</label>
                                    <input id="name_en" class="form-control" type="text" name="name_en"
                                        value="{{ $application->name_en }}">
                                    @error('name_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email" class="form-control" type="email" name="email"
                                        value="{{ $application->email }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="address">{{ __('Address') }}</label>
                                    <input id="address" class="form-control" type="address" name="address"
                                        value="{{ $application->address }}">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="lat">{{ __('Lat') }}</label>
                                    <input id="lat" class="form-control" type="lat" name="lat"
                                        value="{{ $application->lat }}">
                                    @error('lat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="lng">{{ __('Lng') }}</label>
                                    <input id="lng" class="form-control" type="lng" name="lng"
                                        value="{{ $application->lng }}">
                                    @error('lng')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="phone">{{ __('Phone') }}</label>
                                    <input id="phone" class="form-control" type="text" name="phone"
                                        value="{{ $application->phone }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="facebook">{{ __('Facebook') }}</label>
                                    <input id="facebook" class="form-control" type="text" name="facebook"
                                        value="{{ $application->facebook }}">
                                    @error('facebook')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="instagram">{{ __('Instagram') }}</label>
                                    <input id="instagram" class="form-control" type="text" name="instagram"
                                        value="{{ $application->instagram }}">
                                    @error('instagram')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="twitter">{{ __('Twitter') }}</label>
                                    <input id="twitter" class="form-control" type="text" name="twitter"
                                        value="{{ $application->twitter }}">
                                    @error('twitter')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="google">{{ __('Google') }}</label>
                                    <input id="google" class="form-control" type="text" name="google"
                                        value="{{ $application->google }}">
                                    @error('google')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}



                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="logo">{{ __('Logo') }}</label>
                                    <input id="logo" class="form-control" type="file" name="logo">
                                    @error('logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Article -->
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection

