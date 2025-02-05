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
        <div class="row d-flex justify-content-center row-sm">
            @if (auth()->user()->role->name == "seller")
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
            @endif
            @if (auth()->user()->role->name == "super-admin")
                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-secondary-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">{{ __('main.sections') }}</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $sectionsCount }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                    <span class="float-right my-auto mr-auto">
                                        {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                                        <span class="text-white op-7"> -23.09%</span> --}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span  class="pt-1">
                            <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                        </span>
                    </div>
                </div>
            @endif
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
        @if (auth()->user()->role->name == "super-admin")
            <div class="row row-sm row-deck">

                <div class="col-xl-12">
                    <div class="card card-table-two">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-1">{{ __('main.store_most_sale') }}</h4>
                            <a href="{{ route('mall.stores.index') }}"
                                class="btn btn-primary  btn-sm mb-2">{{ __('main.show_more') }}</a>
                        </div>
                        <div class="table-responsive country-table">
                            <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-25p">{{ __('main.store') }}</th>
                                        <th class="wd-lg-25p">{{ __('main.Vendor_Name') }}</th>
                                        <th class="wd-lg-25p">{{ __('main.total_orders') }}</th>
                                        <th class="wd-lg-25p">{{ __('main.url') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mostStors as $store)
                                        <tr>
                                            <td class="tx-right tx-medium tx-inverse">{{ $store->name }}</td>
                                            <td class="tx-right tx-medium tx-inverse">{{ $store->user->name }}</td>
                                            <td class="tx-right tx-medium tx-inverse">{{ $store->orders_count }}</td>
                                            <td class="tx-right tx-medium tx-inverse">
                                                <a href="{{ route('mall.stores.edit', $store->id) }}" target="_blank">{{ __('main.show') }}</a>
                                            </td>
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
                            <h4 class="card-title mb-1">{{ __('main.store_less_sale') }}</h4>
                            <a href="{{ route('mall.stores.index') }}"
                                class="btn btn-primary  btn-sm mb-2">{{ __('main.show_more') }}</a>
                        </div>
                        <div class="table-responsive country-table">
                            <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-25p">{{ __('main.store') }}</th>
                                        <th class="wd-lg-25p">{{ __('main.Vendor_Name') }}</th>
                                        <th class="wd-lg-25p">{{ __('main.total_orders') }}</th>
                                        <th class="wd-lg-25p">{{ __('main.url') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lessStors as $store)
                                        <tr>
                                            <td class="tx-right tx-medium tx-inverse">{{ $store->name }}</td>
                                            <td class="tx-right tx-medium tx-inverse">{{ $store->user->name }}</td>
                                            <td class="tx-right tx-medium tx-inverse">{{ $store->orders_count }}</td>
                                            <td class="tx-right tx-medium tx-inverse">
                                                <a href="{{ route('mall.stores.edit', $store->id) }}" target="_blank">{{ __('main.show') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @endif
        <!-- /row -->
        <!-- row opened -->
        <div class="row row-sm row-deck">

            <div class="col-xl-12">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-1">{{ __('main.products_most_sale') }}</h4>
                        <a href="{{ route('mall.products.index') }}"
                            class="btn btn-primary  btn-sm mb-2">{{ __('main.show_more') }}</a>
                    </div>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                                <tr>
                                    <th class="wd-lg-25p">{{ __('main.product') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.store') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.Vendor_Name') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.total_orders') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.url') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mostProducts as $Product)
                                    <tr>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->name }}</td>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->store->name }}</td>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->store->user->name }}</td>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->order_items_sum_qty ?? 0 }}</td>
                                        <td class="tx-right tx-medium tx-inverse">
                                            <a href="{{ route('mall.products.edit', $Product->id) }}" target="_blank">{{ __('main.show') }}</a>
                                        </td>
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
                        <h4 class="card-title mb-1">{{ __('main.products_less_sale') }}</h4>
                        <a href="{{ route('mall.products.index') }}"
                            class="btn btn-primary  btn-sm mb-2">{{ __('main.show_more') }}</a>
                    </div>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                                <tr>
                                    <th class="wd-lg-25p">{{ __('main.product') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.store') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.Vendor_Name') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.total_orders') }}</th>
                                    <th class="wd-lg-25p">{{ __('main.url') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lessProducts as $Product)
                                    <tr>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->name }}</td>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->store->name }}</td>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->store->user->name }}</td>
                                        <td class="tx-right tx-medium tx-inverse">{{ $Product->order_items_sum_qty ?? 0 }}</td>
                                        <td class="tx-right tx-medium tx-inverse">
                                            <a href="{{ route('mall.products.edit', $Product->id) }}" target="_blank">{{ __('main.show') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
