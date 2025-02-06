@extends('coupon.layouts.master')
@section('title')
    {{ __('main.used_coupons') }}
@endsection
@section('css')
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto"><a href="{{ route('coupon.home') }}"
                        class="text-dark">{{ __('main.home') }}</a></h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('coupon.used-coupons.index') }}">{{ __('main.used_coupons') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('coupon.used-coupons.index') }}" class="btn btn-warning  btn-icon ml-2"><i
                        class="mdi mdi-refresh"></i></a>
            </div>

            @can('coupon.coupons.create')
                <button type="button" class="btn btn-primary ml-2" data-target="#createModal" data-toggle="modal"
                    data-effect="effect-flip-vertical">{{ __('main.create') }}</button>
            @endcan
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="modal" id="deletemodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('main.delete') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="ids" id="selectionIdsInput">
                    <div class="modal-body">
                        <h6 class="text-center">{{ __('main.Are_you_sure') }}</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" type="submit">{{ __('main.delete') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('main.Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="createModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('main.filter') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="post" action="{{ route('coupon.used-coupons.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label" for="phone">{{ __('main.user_phone') }}</label>
                            <input class="form-control" type="text" name="phone" value="{{ request('phone') }}"
                                id="phone" class="form-control">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="code">{{ __('main.coupon_code') }}</label>
                            <input class="form-control" type="text" name="code" value="{{ request('code') }}"
                                id="code" class="form-control">
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('main.create') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('main.Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal effects-->
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('main.used_coupons') }}</h4>
                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-danger mx-1 d-none" id="deleteSelectionBtn"
                                data-toggle="modal" data-effect="effect-flip-vertical" data-target="#deletemodal"
                                data-url="{{ route('coupon.used-coupons.delete') }}">{{ __('main.delete') }}</a>

                            <input type="text" id="searchInput" data-url="{{ route('coupon.used-coupons.search') }}"
                                class="form-control mx-1" placeholder="{{ __('main.search') }}">

                            <div class="custom-select-wrapper mx-1">
                                <select id="showPerPage" class="custom-select"
                                    data-url="{{ route('coupon.used-coupons.index') }}" onchange="updatePageSize()">
                                    <option value="10" @if (request('per_page') && request('per_page') == 10) selected @endif>10</option>
                                    <option value="25" @if (request('per_page') && request('per_page') == 25) selected @endif>25</option>
                                    <option value="50" @if (request('per_page') && request('per_page') == 50) selected @endif>50</option>
                                    <option value="100" @if (request('per_page') && request('per_page') == 100) selected @endif>100</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div id="tableFile">
                        @include('coupon.used-coupons.table')
                    </div>
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
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection
