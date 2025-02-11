@extends('layouts.master')
@section('title')
    {{ __('main.home') }}
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
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')

{{-- Mall --}}
<div class="left-content">
    <div>
        <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.mall') }}</h2>
    </div>
</div>
<!-- row -->
<div class="row mt-3 d-flex justify-content-center row-sm">

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
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalMallCats }}</h4>
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
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.coupons') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalMallCoupons }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">

                </span>
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
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalMallSections }}</h4>
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
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('main.mall') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalMallStores }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">

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
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalMallProducts }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                            {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                            <span class="text-white op-7"> -23.09%</span> --}}
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.orders') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalMallOrders }}</h4>
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


{{-- Booth --}}
<div class="left-content">
    <div>
        <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.booth') }}</h2>
    </div>
</div>
<!-- row -->
<div class="row mt-3 d-flex justify-content-center row-sm">

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
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalBoothCats }}</h4>
                                <p class="mb-0 tx-12 text-white op-7"></p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                {{-- <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> +427</span> --}}
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">
                    <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                </span>
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
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalBoothSections }}</h4>
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
        <div class="card overflow-hidden sales-card bg-success-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.booth') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalBoothStores }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline3" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>

            </span>
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
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalBoothProducts }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                            {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                            <span class="text-white op-7"> -23.09%</span> --}}
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.orders') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalBoothOrders }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                            {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                            <span class="text-white op-7"> -152.3</span> --}}
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline4" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>

            </span>
        </div>
    </div>

</div>
<!-- row closed -->


{{-- Coupons --}}
<div class="left-content">
    <div>
        <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.coupons') }}</h2>
    </div>
</div>
<!-- row -->
<div class="row mt-3 d-flex justify-content-center row-sm">

    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-secondary-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.sections') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalCouponsCats }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                            {{-- <i class="fas fa-arrow-circle-up text-white"></i>
                            <span class="text-white op-7"> +427</span> --}}
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.coupons') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalCoupons }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline3" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>

            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.used_times') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $usedCount }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                            {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                            <span class="text-white op-7"> -23.09%</span> --}}
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
            </span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.copied_times') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $copiesCount }}</h4>
                            <p class="mb-0 tx-12 text-white op-7"></p>
                        </div>
                        <span class="float-right my-auto mr-auto">
                            {{-- <i class="fas fa-arrow-circle-down text-white"></i>
                            <span class="text-white op-7"> -152.3</span> --}}
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline4" class="pt-1">
                <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>

            </span>
        </div>
    </div>

</div>
<!-- row closed -->

{{-- Earn --}}
<div class="left-content">
    <div>
        <h2 class="main-content-title tx-24 mb-3 mg-b-1 mg-b-lg-1">{{ __('main.earn') }}</h2>
    </div>
</div>
<!-- row -->
<div class="row row-sm">
    <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.Total_Videos') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalVideos }}</h4>
                        </div>
                        <span class="float-right my-auto mr-auto">
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline" class="pt-1">
                <canvas width="806" height="30" style="display: inline-block; width: 806px; height: 30px; vertical-align: top;"></canvas>
            </span>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">{{ __('main.Total_Views') }}</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalViews }}</h4>
                        </div>
                        <span class="float-right my-auto mr-auto">
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1">
                <canvas width="806" height="30" style="display: inline-block; width: 806px; height: 30px; vertical-align: top;"></canvas>
            </span>
        </div>
    </div>
</div>
<!-- row closed -->

@if (auth()->user()->role->name == "super-admin")
    {{-- rresale rfoof --}}
    <div class="row row-sm">
        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.usedmarket') }}</h2>
                </div>
            </div>
            <!-- row -->
            <div class="row mt-3 d-flex justify-content-center row-sm">

                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-secondary-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">{{ __('main.sections') }}</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalResaleCats }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                    <span class="float-right my-auto mr-auto">
                                        {{-- <i class="fas fa-arrow-circle-up text-white"></i>
                                        <span class="text-white op-7"> +427</span> --}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline" class="pt-1">
                            <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                        </span>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-success-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">{{ __('main.all_ads') }}</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalResaleAds }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                    <span class="float-right my-auto mr-auto">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline3" class="pt-1">
                            <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>

                        </span>
                    </div>
                </div>

            </div>
            <!-- row closed -->
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('main.rfoof') }}</h2>
                </div>
            </div>
            <!-- row -->
            <div class="row mt-3 d-flex justify-content-center row-sm">

                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-secondary-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">{{ __('main.sections') }}</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalRfoofCats }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                    <span class="float-right my-auto mr-auto">
                                        {{-- <i class="fas fa-arrow-circle-up text-white"></i>
                                        <span class="text-white op-7"> +427</span> --}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline" class="pt-1">
                            <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>
                        </span>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-success-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">{{ __('main.all_ads') }}</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalRfoofAds }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                    <span class="float-right my-auto mr-auto">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline3" class="pt-1">
                            <canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas>

                        </span>
                    </div>
                </div>

            </div>
            <!-- row closed -->
        </div>

    </div>
@endif



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
