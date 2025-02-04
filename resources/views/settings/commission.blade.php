@extends('layouts.master')
@section('title')
    {{ __('main.commission') }}
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
                        href="{{ route('abouts.index') }}">{{ __('main.commission') }}</a></span>
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
                    <form action="{{ route('commission.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="value">{{ __('main.mall') }}</label>
                                    <input id="value" class="form-control" value="{{ collect($commission)->firstWhere('key', 'commission_mall')->value_ar ?? '' }}" type="text" name="mall-value">
                                    @error('value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="value">{{ __('main.booth') }}</label>
                                    <input id="value" class="form-control" value="{{ collect($commission)->firstWhere('key', 'commission_booth')->value_ar ?? '' }}" type="text" name="booth-value">
                                    @error('value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="value">{{ __('main.usedmarket') }}</label>
                                    <input id="value" class="form-control" value="{{ collect($commission)->firstWhere('key', 'commission_resale')->value_ar ?? '' }}" type="text" name="resale-value">
                                    @error('value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="resale-desc-ar">{{ __('main.content') }}(EN)</label>
                                            <textarea id="resale-desc-ar" class="form-control" type="text" name="resale-desc-ar">{{ collect($commission)->firstWhere('key', 'desc_resale')->value_ar ?? '' }}</textarea>
                                            @error('resale-desc-ar')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="resale-desc-en">{{ __('main.content') }}(EN)</label>
                                            <textarea id="resale-desc-en" class="form-control" type="text" name="resale-desc-en">{{ collect($commission)->firstWhere('key', 'desc_resale')->value_en ?? '' }}</textarea>
                                            @error('resale-desc-en')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="value">{{ __('main.rfoof') }}</label>
                                    <input id="value" class="form-control" value="{{ collect($commission)->firstWhere('key','commission_rfoof')->value_ar ?? '' }}" type="text" name="rfoof-value">
                                    @error('value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="rfoof-desc-ar">{{ __('main.content') }}(EN)</label>
                                            <textarea id="rfoof-desc-ar" class="form-control" type="text" name="rfoof-desc-ar">{{ collect($commission)->firstWhere('key', 'desc_rfoof')->value_ar ?? '' }}</textarea>
                                            @error('rfoof-desc-ar')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="rfoof-desc-en">{{ __('main.content') }}(EN)</label>
                                            <textarea id="rfoof-desc-en" class="form-control" type="text" name="rfoof-desc-en">{{ collect($commission)->firstWhere('key', 'desc_rfoof')->value_en ?? '' }}</textarea>
                                            @error('rfoof-desc-en')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="value_en">{{ __('main.content') }}(EN)</label>
                                    <textarea id="value_en" class="form-control" type="text" name="value_en">{{ $about->value_en  ?? '' }}</textarea>
                                    @error('value_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}

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

