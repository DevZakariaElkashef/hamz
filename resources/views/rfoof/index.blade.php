@extends('rfoof.layouts.master')
@section('title')
    {{ __('mall.home') }}
@endsection
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.welcome_dashboard') }}</h2>
            </div>
        </div>
        {{-- <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">Customer Ratings</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i>
                    <i class="typcn typcn-star active"></i>
                    <i class="typcn typcn-star active"></i>
                    <i class="typcn typcn-star active"></i>
                    <i class="typcn typcn-star"></i>
                    <span>(14,873)</span>
                </div>
            </div>
            <div>
                <label class="tx-13">Online Sales</label>
                <h5>563,275</h5>
            </div>
            <div>
                <label class="tx-13">Offline Sales</label>
                <h5>783,675</h5>
            </div>
        </div> --}}
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        {{-- <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">TODAY ORDERS</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">$5,74.12</h4>
                                <p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> +427</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">TODAY EARNINGS</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">$1,230.17</h4>
                                <p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> -23.09%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">TOTAL EARNINGS</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">$7,125.70</h4>
                                <p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> 52.09%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">PRODUCT SOLD</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">$4,820.50</h4>
                                <p class="mb-0 tx-12 text-white op-7">Compared to last week</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> -152.3</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div> --}}

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
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.all_ads') }}</h6>
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
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.accept_ads') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $acceptProductsCount }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                
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
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.noaccept_ads') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $productsCount - $acceptProductsCount }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
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
    <div class="row row-sm row-deck">

        <div class="col-xl-12">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-1">{{ __('main.fav_ads') }}</h4>
                    <a href="{{ route('rfoof.products', 0) }}"
                        class="btn btn-primary  btn-sm mb-2">{{ __('main.show_more') }}</a>
                </div>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-25p">{{ __('main.product') }}</th>
                                <th class="wd-lg-25p">{{ __('main.category') }}</th>
                                <th class="wd-lg-25p">{{ __('main.Vendor_Name') }}</th>
                                <th class="wd-lg-25p">{{ __('main.comment_count') }}</th>
                                <th class="wd-lg-25p">{{ __('main.reviews') }}</th>
                                {{-- <th class="wd-lg-25p">{{ __('main.url') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($favAds as $Product)
                                <tr>
                                    <td class="tx-right tx-medium tx-inverse">{{ $Product->name }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ $Product->category->name }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ $Product->user->name }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ $Product->commenets_count ?? 0 }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ round($Product->commenets_avg_rate, 1) ?? 0.0 }}</td>
                                    {{-- <td class="tx-right tx-medium tx-inverse">
                                        <a href="{{ route('rfoof.products.edit', $Product->id) }}" target="_blank">{{ __('main.show') }}</a>
                                    </td> --}}
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
                    <h4 class="card-title mb-1">{{ __('main.new_ads') }}</h4>
                    <a href="{{ route('rfoof.products', 0) }}"
                        class="btn btn-primary  btn-sm mb-2">{{ __('main.show_more') }}</a>
                </div>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-25p">{{ __('main.product') }}</th>
                                <th class="wd-lg-25p">{{ __('main.category') }}</th>
                                <th class="wd-lg-25p">{{ __('main.Vendor_Name') }}</th>
                                {{-- <th class="wd-lg-25p">{{ __('main.total_orders') }}</th> --}}
                                {{-- <th class="wd-lg-25p">{{ __('main.url') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newAds as $Product)
                                <tr>
                                    <td class="tx-right tx-medium tx-inverse">{{ $Product->name }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ $Product->category->name }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ $Product->user->name }}</td>
                                    {{-- <td class="tx-right tx-medium tx-inverse">{{ $Product->order_items_sum_qty ?? 0 }}</td> --}}
                                    {{-- <td class="tx-right tx-medium tx-inverse">
                                        <a href="{{ route('rfoof.products.edit', $Product->id) }}" target="_blank">{{ __('main.show') }}</a>
                                    </td> --}}
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
