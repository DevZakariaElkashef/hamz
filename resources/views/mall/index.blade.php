@extends('mall.layouts.master')
@section('title')
    {{ __('main.home') }}
@endsection
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection

@can('mall.dashboard.index')
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
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.categories') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $categoriesCount }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    {{-- <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7"> +427</span> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline" class="pt-1"></span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.products') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $productsCount }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7"> -23.09%</span> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline2" class="pt-1"></span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.orders') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $ordersCount }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    {{-- <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7"> 52.09%</span> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline3" class="pt-1"></span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-warning-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{ __('main.coupons') }}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $couponsCount }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7"> -152.3</span> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline4" class="pt-1"></span>
                </div>
            </div>
        </div>
        <!-- row closed -->

        <!-- row opened -->
        {{-- <div class="row row-sm row-deck">

            <div class="col-md-12 col-lg-6 col-xl-6">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-1">Your Most Recent Earnings</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <span class="tx-12 tx-muted mb-3 ">This is your most recent earnings for today's date.</span>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                                <tr>
                                    <th class="wd-lg-25p">Date</th>
                                    <th class="wd-lg-25p tx-right">Sales Count</th>
                                    <th class="wd-lg-25p tx-right">Earnings</th>
                                    <th class="wd-lg-25p tx-right">Tax Witheld</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>05 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">34</td>
                                    <td class="tx-right tx-medium tx-inverse">$658.20</td>
                                    <td class="tx-right tx-medium tx-danger">-$45.10</td>
                                </tr>
                                <tr>
                                    <td>06 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">26</td>
                                    <td class="tx-right tx-medium tx-inverse">$453.25</td>
                                    <td class="tx-right tx-medium tx-danger">-$15.02</td>
                                </tr>
                                <tr>
                                    <td>07 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">34</td>
                                    <td class="tx-right tx-medium tx-inverse">$653.12</td>
                                    <td class="tx-right tx-medium tx-danger">-$13.45</td>
                                </tr>
                                <tr>
                                    <td>08 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">45</td>
                                    <td class="tx-right tx-medium tx-inverse">$546.47</td>
                                    <td class="tx-right tx-medium tx-danger">-$24.22</td>
                                </tr>
                                <tr>
                                    <td>09 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">31</td>
                                    <td class="tx-right tx-medium tx-inverse">$425.72</td>
                                    <td class="tx-right tx-medium tx-danger">-$25.01</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /row -->
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
