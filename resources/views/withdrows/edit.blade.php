@extends('layouts.master')
@section('title')
    {{ __('main.edit_withdrow') }}
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
                        href="{{ route('withdrows.index') }}">{{ __('main.withdrows') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('withdrows.edit', $withdrow->id) }}">{{ __('main.edit_withdrow') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('withdrows.index') }}" class="btn btn-secondary ">{{ __('main.back') }}</a>
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
                        <h4 class="card-title mg-b-0">{{ __('main.withdrows') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('withdrows.update', $withdrow->id) }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.iban') }}: <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="iban" placeholder="{{ __('main.iban') }}"
                                    required="" type="text" value="{{ old('iban') ?? $withdrow->iban }}">
                                @error('iban')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('main.amount') }}: <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="amount" placeholder="{{ __('main.amount') }}"
                                    required="" type="text" value="{{ old('amount') ?? $withdrow->amount }}">
                                @error('amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group mg-b-0">
                                <label for="status">{{ __('main.status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{ __('main.all') }}</option>
                                    <option value="0" @if ($withdrow->status == 0) selected @endif>
                                        {{ __('main.pending') }}</option>
                                    <option value="1" @if ($withdrow->status == 1) selected @endif>
                                        {{ __('main.confirmed') }}</option>
                                    <option value="2" @if ($withdrow->status == 2) selected @endif>
                                        {{ __('main.canceled') }}</option>
                                    <option value="3" @if ($withdrow->status == 3) selected @endif>
                                        {{ __('main.failed') }}</option>
                                </select>
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
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection
