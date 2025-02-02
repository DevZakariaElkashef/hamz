@extends('rfoof.layouts.master')
@section('title')
    الاعلانات
@endsection
@section('css')
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .pagination-box {
            display: flex;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            الاعلانات
        @endslot
        @slot('title')
            الاعلانات
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0">
                        الاعلانات
                    </h4>
                    {{-- @can('addProduct')
                        <a href="{{ route('addProduct') }}" class="btn btn-primary button-icon"><i
                                class="fe fe-plus ml-2 font-weight-bolder"></i>{{ __('admin.product_create') }}</a>
                    @endcan --}}

                </div>
                <div class="card-body table-responsive border-0">
                    @include('layouts.session')
                    @component('components.errors')
                        @slot('id')
                            company_id
                        @endslot
                    @endcomponent
                    <table id="datatable" class="table table-bordered dt-responsive text-nowrap w-100">
                        <thead>
                            <tr style="cursor: pointer;">
                                <th class="fw-bold">#</th>
                                <th class="fw-bold">{{ __('admin.image') }}</th>
                                <th class="fw-bold">{{ __('admin.title') }}</th>
                                <th class="fw-bold">{{ __('admin.description') }}</th>
                                <th class="fw-bold">القسم الرئيسي</th>
                                <th class="fw-bold">{{ __('admin.price') }}</th>
                                <th class="fw-bold">{{ __('admin.status') }}</th>
                                @if ($status == 1)
                                    <th class="fw-bold">تمييز</th>
                                    <th class="fw-bold">حظر</th>
                                @endif

                                <th class="fw-bold">{{ __('admin.actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($products) == 0)
                                <tr class="align-middle">
                                    <td colspan="10" class="text-center">{{ __('admin.no_data') }}</td>
                                </tr>
                            @endif
                            @foreach ($products as $count => $product)
                                <tr data-id="{{ $count + 1 }}">
                                    <td style="width: 80px" class="align-middle">{{ $count + 1 }}</td>
                                    <td class="align-middle"><img src="{{ asset('uploads/adsImages/'.$product->images[0]->image) }}"
                                            alt="{{ __('admin.image') }}" style="width: 100px;" /></td>
                                    <td class="align-middle">{{ $product->name }}</td>
                                    <td class="align-middle">{!! mb_strimwidth($product->description, 0, 50, ',...') !!}</td>
                                    <td class="align-middle">{{ $product->category->title() }}</td>
                                    <td class="align-middle">{{ $product->price }}</td>
                                    <td class="align-middle">
                                        @if ($product->status == 0)
                                            <a href="{{ route('rfoof.products.accepet', $product->id) }}"
                                                class="btn btn-success">موافقه</a>
                                            <a href="{{ route('rfoof.products.rejecet', $product->id) }}"
                                                class="btn btn-danger">رفض</a>
                                        @elseif($product->status == 1)
                                            <span class="btn btn-success">الاعلان مقبول</span>
                                        @else
                                            <span class="btn btn-danger">الاعلان مرفوض</span>
                                        @endif
                                    </td>
                                    @if ($status == 1)
                                        <td class="align-middle">
                                            <a href="{{ route('rfoof.products.discriminationAdsAction', $product->id) }}"
                                                class="btn btn-success">تمييز</a>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('rfoof.products.blockAds', $product->id) }}"
                                                class="btn btn-danger">حظر</a>
                                        </td>
                                    @endif
                                    <td class="align-middle">
                                        <div class="d-flex">

                                            <form class="d-inline ml-2" action="{{ route('rfoof.products.verify') }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                <button type="submit" class="btn btn-outline-secondary  bg-primary text-dark btn-sm"
                                                    @if ($product->verify == 1) title="{{ __('admin.hide') }}" @else title="{{ __('admin.showIcon') }}" @endif>
                                                    <i class="@if ($product->verify == 1) fas fa-eye-slash @else fas fa-eye @endif"
                                                        style="color:white">
                                                    </i>
                                                </button>
                                            </form>
                                            <button type="submit"
                                                class="modal-effect btn btn-outline-secondary bg-danger text-dark btn-sm"
                                                title="{{ __('admin.delete') }}" data-effect="effect-newspaper"
                                                data-toggle="modal" href="#myModal{{ $product->id }}">
                                                <i class="fas fa-trash-alt" style="color:white"></i>
                                            </button>

                                        </div>

                                        <div class="modal" id="myModal{{ $product->id }}">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ __('admin.product_delete') }}</h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ __('admin.deleteProductMessage') }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form class="d-inline" action="{{ route('rfoof.products.delete') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}" />
                                                            <button type="button" class="btn btn-secondary waves-effect"
                                                                data-dismiss="modal">{{ __('admin.back') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-danger waves-effect waves-light">{{ __('admin.delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12 pagination-box">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection
