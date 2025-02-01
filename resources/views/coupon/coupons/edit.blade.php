@extends('coupon.layouts.master')
@section('title')
    {{ __('main.edit_coupon') }}
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
                        href="{{ route('coupon.coupons.index') }}">{{ __('main.coupons') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('coupon.coupons.edit', $coupon->id) }}">{{ __('main.edit_coupon') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('coupon.coupons.index') }}" class="btn btn-secondary ">{{ __('main.back') }}</a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('main.coupons') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('coupon.coupons.update', $coupon->id) }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.code') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="code" placeholder="{{ __('main.enter_code') }}"
                                    required="" type="text" value="{{ old('code', $coupon->code) }}">
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.discount') }}: <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="discount" placeholder="{{ __('main.enter_discount') }}"
                                    required="" type="number" value="{{ old('discount', $coupon->discount) }}">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.max_usage') }}: <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="max_usage" placeholder="{{ __('main.enter_max_usage') }}"
                                    required="" type="number" value="{{ old('max_usage', $coupon->max_usage) }}">
                                @error('max_usage')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.store') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control" name="store_id">
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            @if (old('store_id') == $store->id) selected @endif>
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('store_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.status') }}: <span class="tx-danger">*</span></label>
                                <select required class="form-control" name="is_active">
                                    <option value="0" @if (old('is_active', $coupon->is_active) == 0) selected @endif>
                                        {{ __('main.not_active') }}</option>
                                    <option value="1" @if (old('is_active', $coupon->is_active) == 1) selected @endif>
                                        {{ __('main.active') }}</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.start_date') }}:</label>
                                <input class="form-control" name="start_date" placeholder="{{ __('main.enter_start_at') }}"
                                    type="date" value="{{ old('start_date', $coupon->start_date) }}">
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.end_date') }}:</label>
                                <input class="form-control" name="end_date" placeholder="{{ __('main.enter_end_date') }}"
                                    type="date" value="{{ old('end_date', $coupon->end_date) }}">
                                @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-12 mg-t-10 mg-sm-t-25">
                                <button class="btn btn-main-primary pd-x-20"
                                    type="submit">{{ __('main.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/div-->
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
    {{-- <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script> --}}
@endsection
