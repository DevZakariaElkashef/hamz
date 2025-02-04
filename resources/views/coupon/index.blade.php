@extends('coupon.layouts.master')
@section('title')
    {{ __('main.home') }}
@endsection
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@can('coupon.dashboard.index')
    @section('page-header')
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.welcome_dashboard') }}</h2>
                </div>
            </div>
        </div>
        <!-- /breadcrumb -->
    @endsection
    @section('content')
        <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-4 col-lg-4 col-md-4 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.total_coupons') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $total_coupons }}</h4>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.total_coupons_uses') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $total_coupons_uses }}</h4>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-xm-12">
                <div class="card overflow-hidden sales-card bg-warning-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.total_coupons_copies') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $total_coupons_copies }}</h4>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline3" class="pt-1">3,2,4,6,2,5,9,12,14,16,12,7,8,4,3,2,2,5,6,7</span>
                </div>
            </div>
        </div>
        <!-- row closed -->

        <!-- row opened -->
        <div class="row row-sm row-deck">

            <div class="col-xl-12">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-1">{{ __('main.most_used_coupons') }}</h4>
                        <a href="{{ route('coupon.coupons.index') }}"
                            class="btn btn-primary  btn-sm mb-2">{{ __('main.show_more') }}</a>
                    </div>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('main.code') }}</th>
                                    <th>{{ __('main.category') }}</th>
                                    <th>{{ __('main.store') }}</th>
                                    <th>{{ __('main.discount') }}</th>
                                    <th>{{ __('main.max_usage') }}</th>
                                    <th>{{ __('main.used_times') }}</th>
                                    <th>{{ __('main.copied_times') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($most_used_coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ $coupon->category->name ?? null }}</td>
                                        <td>{{ $coupon->store->name ?? null }}</td>
                                        <td>{{ $coupon->discount }}</td>
                                        <td>{{ $coupon->max_usage }}</td>
                                        <td>{{ $coupon->users->count() }}</td>
                                        <td>{{ $coupon->copies->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-1">{{ __('main.least_used_coupons') }}</h4>
                        <a href="{{ route('coupon.coupons.index') }}"
                            class="btn btn-primary btn-sm mb-2">{{ __('main.show_more') }}</a>
                    </div>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('main.code') }}</th>
                                    <th>{{ __('main.category') }}</th>
                                    <th>{{ __('main.store') }}</th>
                                    <th>{{ __('main.discount') }}</th>
                                    <th>{{ __('main.max_usage') }}</th>
                                    <th>{{ __('main.used_times') }}</th>
                                    <th>{{ __('main.copied_times') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($least_used_coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ $coupon->category->name ?? null }}</td>
                                        <td>{{ $coupon->store->name ?? null }}</td>
                                        <td>{{ $coupon->discount }}</td>
                                        <td>{{ $coupon->max_usage }}</td>
                                        <td>{{ $coupon->users->count() }}</td>
                                        <td>{{ $coupon->copies->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- Container closed -->
    @endsection
@endcan
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
