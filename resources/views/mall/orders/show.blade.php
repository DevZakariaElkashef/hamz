@extends('mall.layouts.master')
@section('title')
    {{ __('mall.View_order_details') }} # {{ $order->id }}
@endsection
@section('css')
    <style type="text/css">
        #maporder {
            height: 400px;
            width: 100%;
        }

        #contentmap {
            font-size: 12pt;
            font-family: "Cairo", sans-serif;

        }

        .nostaractive {
            color: #e1e6f1 !important;
        }

        span#lg-share {
            display: none !important;
        }

        .cursorimg:hover {
            cursor: pointer;
        }
    </style>
    <!-- Internal Gallery css -->
    <link href="{{ URL::asset('assets/plugins/gallery/gallery.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('mall.View_order_details') }} # {{ $order->id }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0"> </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0 ml-3">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-danger" id="deleteOrderBtn"
                        data-url="{{ route('mall.orders.destroy', $order->id) }}" data-toggle="modal"
                        data-target="#deleteModal" data-placement="top" data-toggle="tooltip"
                        title="{{ __('mall.delete') }} ">
                        {{ __('mall.delete') }} </button>
                </div>
            </div>

            <div class="mb-3 mb-xl-0 ml-3">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalChangeStatusOrder"
                        data-placement="top" data-toggle="tooltip" title="{{ __('mall.Change_Order_Status') }} ">
                        {{ __('mall.Change_Order_Status') }} </button>
                </div>
            </div>

            <div class="mb-3 mb-xl-0 ml-3">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary " data-toggle="modal"
                        data-target="#ModalChangeMethodStatusOrder" data-placement="top" data-toggle="tooltip"
                        title="{{ __('mall.Change_payment_status') }} ">{{ __('mall.Change_payment_status') }}</button>
                </div>
            </div>



            <div class="mb-3 mb-xl-0 ml-3">
                <div class="btn-group dropdown">
                    <a href="{{ route('mall.invoices.show', $order) }}" target="_blank" class="btn btn-dark "
                        data-placement="top" data-toggle="tooltip"
                        title="{{ __('mall.Bill') }} ">{{ __('mall.Bill') }}</a>
                </div>
            </div>


            <div class="pr-1 mb-3 mb-xl-0 ml-3">
                <a href="{{ route('mall.orders.index') }}" class="btn btn-secondary ">{{ __('mall.back') }}</a>
            </div>

        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteProductForm" enctype="multipart/form-data">
                @csrf
                @method('delete')
                <div class="modal-content ">
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('mall.delete') }}</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        {{ __('mall.Are you sure!') }}
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" type="submit">{{ __('mall.delete') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade " id="addProductModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('mall.orderitems.store') }}" id="addProductModalvalid"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $order->id }}">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title"> {{ __('mall.add_product') }}</h4>
                        <h5>{{ __('mall.Change_Order_Status') }}</h5>
                    </div>
                    <div class="modal-body">

                        <div class="row row-sm">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('mall.product') }}: <span
                                            class="tx-danger">*</span></label>
                                    <div class="parsley-select " id="slWrapperis_active">
                                        <select class="form-control selectwithoutsearch"
                                            data-parsley-class-handler="#slWrapperis_active"
                                            data-parsley-errors-container="#slErrorContaineris_active"
                                            data-placeholder="{{ __('mall.select') }}" id="status_id" name="product_id"
                                            required="">
                                            <option value="  ">
                                                {{ __('mall.select') }}
                                            </option>
                                            @foreach ($products->reject(function ($product) use ($order) {
            return $order->orderItems->pluck('product_id')->contains($product->id);
        }) as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="slErrorContaineris_active">
                                            @if ($errors->ModalChangeStatusOrderbag->has('product_id'))
                                                <span
                                                    class="tx-danger">{{ $errors->ModalChangeStatusOrderbag->first('product_id') }}
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label for="qty">{{ __('mall.qty') }}</label>
                                    <input class="form-control" type="number" name="qty" id="qty">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" id="modal_changeorder_submit_button"
                            type="submit">{{ __('mall.add_product') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade " id="ModalChangeStatusOrder" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="ModalChangeStatusOrdervalid" enctype="multipart/form-data"
                action="{{ route('mall.orders.updateStatus') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $order->id }}">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title"> {{ __('mall.Order_number') }} {{ $order->id }}</h4>
                        <h5>{{ __('mall.Change_Order_Status') }}</h5>
                    </div>
                    <div class="modal-body">

                        <div class="row row-sm">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('mall.Order_Status') }}: <span
                                            class="tx-danger">*</span></label>
                                    <div class="parsley-select " id="slWrapperis_active">
                                        <select class="form-control selectwithoutsearch"
                                            data-parsley-class-handler="#slWrapperis_active"
                                            data-parsley-errors-container="#slErrorContaineris_active"
                                            data-placeholder="{{ __('mall.select') }}" id="status_id" name="status_id"
                                            required="">
                                            <option value="  ">
                                                {{ __('mall.select') }}
                                            </option>
                                            @foreach ($orderStatuses as $order_status)
                                                <option value="{{ $order_status->id }}"
                                                    {{ $order->order_status_id == $order_status->id ? 'selected' : '' }}>
                                                    {{ $order_status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="slErrorContaineris_active">
                                            @if ($errors->ModalChangeStatusOrderbag->has('status_id'))
                                                <span
                                                    class="tx-danger">{{ $errors->ModalChangeStatusOrderbag->first('status_id') }}
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" id="modal_changeorder_submit_button"
                            type="submit">{{ __('mall.edit') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade " id="ModalChangeMethodStatusOrder" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <form method="POST" id="ModalMethodStatusOrdervalid" enctype="multipart/form-data"
                action="{{ route('mall.orders.updatePayment') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $order->id }}">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title"> {{ __('mall.Order_number') }} {{ $order->id }}</h4>
                        <h5>{{ __('mall.Change_payment_status') }}</h5>
                    </div>
                    <div class="modal-body">

                        <div class="row row-sm">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('mall.payment_method') }}: <span
                                            class="tx-danger">*</span></label>
                                    <div class="parsley-select " id="slWrapperis_active">
                                        <select class="form-control selectwithoutsearch"
                                            data-parsley-class-handler="#slWrapperis_active"
                                            data-parsley-errors-container="#slErrorContaineris_activepaymentstatus"
                                            data-placeholder="{{ __('mall.select') }}" id="payment_type"
                                            name="payment_type" required="">
                                            <option value=" ">
                                                {{ __('mall.select') }}
                                            </option>
                                            @foreach ($paymentMethods as $payment)
                                                <option value="{{ $payment['id'] }}"
                                                    {{ $order->payment_type == $payment['id'] ? 'selected' : '' }}>
                                                    {{ $payment['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="slErrorContaineris_activepaymentstatus">
                                            @if ($errors->ModalChangeMethodStatusOrderbag->has('payment_type'))
                                                <span
                                                    class="tx-danger">{{ $errors->ModalChangeMethodStatusOrderbag->first('payment_type') }}
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('mall.payment_status') }}: <span
                                            class="tx-danger">*</span></label>
                                    <div class="parsley-select " id="slWrapperis_active">
                                        <select class="form-control selectwithoutsearch"
                                            data-parsley-class-handler="#slWrapperis_active"
                                            data-parsley-errors-container="#slErrorContaineris_activepaymentstatus"
                                            data-placeholder="{{ __('mall.select') }}" id="payment_status"
                                            name="payment_status" required="">
                                            <option value="  ">
                                                {{ __('mall.select') }}
                                            </option>
                                            @foreach ($paymentStatus as $payment_status)
                                                <option value="{{ $payment_status['id'] }}"
                                                    {{ $order->payment_status == $payment_status['id'] ? 'selected' : '' }}>
                                                    {{ $payment_status['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="slErrorContaineris_activepaymentstatus">
                                            @if ($errors->ModalChangeMethodStatusOrderbag->has('payment_status'))
                                                <span
                                                    class="tx-danger">{{ $errors->ModalChangeMethodStatusOrderbag->first('payment_status') }}
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" id="modal_changemethodstatus_submit_button"
                            type="submit">{{ __('mall.edit') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" src="{{ asset($order->user->image) }}">
                            </div>
                            <div class="d-flex justify-content-between mg-b-5">
                                <div>
                                    <h5 class="main-profile-name">{{ $order->user->name }}</h5>
                                    <p class="main-profile-name-text" style="font-size: 15px;"> <a
                                            href="javascript:void(0);" class="contact-icon border tx-inverse"
                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Call"
                                            aria-label="Call"><i class="fe fe-phone" style="color:green"></i></a>
                                        {{ $order->user->phone }} </p>
                                </div>
                            </div><br />
                            <h6>{{ __('mall.Note') }}</h6>
                            <div class="main-profile-bio">
                                {{ $order->note }}
                            </div><!-- main-profile-bio -->

                            <hr class="mg-y-10">
                            <div class="table-responsive mg-t-20">
                                <table class="table table-invoice border text-md-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('mall.number_products') }}</td>
                                            <td colspan="2">{{ $order->orderItems->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('mall.Total_Products') }}</td>
                                            <td colspan="2">{{ $order->sub_total }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('mall.Coupon_Discount_Value') }} ({{ $order->discount }}%)</td>
                                            <td colspan="2">
                                                @if ($order->discount > 0)
                                                    @php
                                                        // Assuming $order->total_price is the price before discount
                                                        $valuecoupon = ($order->discount / 100) * $order->total_price;
                                                    @endphp
                                                    {{ number_format($valuecoupon, 2) }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('mall.Delivery_value') }}</td>
                                            <td colspan="2">{{ floatval($order->delivery) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('mall.added_tax') }}</td>
                                            <td colspan="2">{{ floatval($order->tax) }}</td>
                                        </tr>
                                        <tr>
                                            <td class=" tx-uppercase tx-bold tx-inverse">{{ __('mall.total') }}
                                            </td>
                                            <td colspan="2">
                                                <h4 class="tx-primary tx-bold">{{ floatval($order->total) }}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row row-sm">
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-primary-transparent">
                                    <i class="icon-clock text-primary"></i>
                                </div>
                                <div class="mr-auto">
                                    <h2 class="tx-14 " style="font-weight:bold">{{ __('mall.date') }}</h2>
                                    <h5 class="mb-0 tx-15 mb-1 mt-1">
                                        {{ $order->created_at->format('d/m/Y') }}<br />{{ $order->created_at->format('h:i:s A') }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-danger-transparent">
                                    <i class="icon-rocket text-success"></i>
                                </div>
                                <div class="mr-auto">
                                    <h2 class="tx-14 mt-2" style="font-weight:bold">{{ __('mall.Order_Status') }}
                                    </h2>
                                    <h5 class="mb-0 tx-15 mb-1 mt-1">
                                        {{ $order->orderStatus->name }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-success-transparent">
                                    <i class="icon-paypal text-danger"></i>
                                </div>
                                <div class="mr-auto">
                                    <h2 class="tx-14 mt-2" style="font-weight:bold">
                                        {{ __('mall.payment_status') }}</h2>
                                    <h5 class="mb-0 tx-15 mb-1 mt-1">
                                        {{ $order->payment_condition }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="active">
                                <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i
                                            class="las la-shopping-cart tx-20 mr-1"></i></span> <span
                                        class="hidden-xs">{{ __('mall.Order_Products') }}</span> </a>
                            </li>
                            <li class="">
                                <a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                            class="las la-map-marker-alt tx-20 mr-1"></i></span> <span
                                        class="hidden-xs">{{ __('mall.Delivery_Address') }}</span> </a>
                            </li>
                            <li class="">
                                <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                            class="las la-file-invoice-dollar tx-20 mr-1"></i></span> <span
                                        class="hidden-xs">{{ __('mall.Payment_Method') }}</span> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                        <div class="tab-pane active" id="home">
                            <!-- Shopping Cart-->
                            <div class="product-details table-responsive text-nowrap">
                                <table class="table table-bordered table-hover mb-0 text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>{{ __('mall.product') }}</th>
                                            <th class="w-150">{{ __('mall.qty') }}</th>
                                            <th>{{ __('mall.price') }}</th>
                                            <th>{{ __('mall.total') }}</th>
                                            <th>{{ __('mall.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-items-body">
                                        @foreach ($order->orderItems as $order_item)
                                            <tr>
                                                <form action="{{ route('mall.orderitems.update', $order_item) }}"
                                                    method="post">
                                                    @method('put')
                                                    @csrf
                                                    <td>
                                                        <div class="media">
                                                            <div class="card-aside-img">
                                                                <img src="{{ asset($order_item->product->image) }}"
                                                                    alt="img" class="h-60 w-60 product-image">
                                                            </div>
                                                            <div class="media-body">
                                                                <div class="card-item-desc mt-0">
                                                                    <h6 class="font-weight-semibold mt-0 text-uppercase">
                                                                        <select name="product_id"
                                                                            class="form-control select2 product-select">
                                                                            @foreach ($products as $product)
                                                                                <option value="{{ $product->id }}"
                                                                                    @if ($order_item->product_id == $product->id) selected @endif>
                                                                                    {{ $product->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group" style="text-align: center">
                                                            <input type="number" name="qty"
                                                                class="form-control qty-input" style="width: 100px"
                                                                value="{{ $order_item->qty }}">
                                                        </div>
                                                    </td>
                                                    <td class="text-center text-lg text-medium">
                                                        <input type="number" name="price"
                                                            class="form-control price-input" style="width: 100px"
                                                            value="{{ $order_item->price }}">
                                                    </td>
                                                    <td class="text-center text-lg text-medium total">
                                                        {{ $order_item->qty * $order_item->price }}
                                                    </td>
                                                    <td>
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('mall.update') }}</button>
                                                        <a href="#" id="deleteproductItem"
                                                            data-url="{{ route('mall.orderitems.destroy', $order_item->id) }}"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            class="btn btn-danger">
                                                            {{ __('mall.delete') }}
                                                        </a>

                                                    </td>
                                                </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div style="text-align: end;" class="mt-3">

                                    <!-- Button to Add New Row -->
                                    <button id="add_product" data-toggle="modal" data-target="#addProductModal"
                                        class="btn btn-success">{{ __('mall.add_product') }}</button>
                                </div>



                            </div>
                        </div>
                        <div class="tab-pane" id="profile">
                            <p class="text-center my-3">{{ $order->address }}</p>

                        </div>
                        <div class="tab-pane" id="settings">
                            <div style="text-align: center" class="tx-16"><button type="button"
                                    class="btn btn-primary mx-2 button-icon mb-1 tx-14">
                                    {{ $order->payment_method }}
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/select2/js/i18n/' . app()->getLocale() . '.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/i18n/' . app()->getLocale() . '.js') }}"></script>
    {{-- <script type="text/javascript">
        function initMap() {
            const myLatLng = {
                lat: {{ $order->latitude }},
                lng: {{ $order->longitude }}
            };
            const map = new google.maps.Map(document.getElementById("maporder"), {
                zoom: 11,
                center: myLatLng,
            });

            var contentString = '<div id="contentmap">' + '{{ $order->address }}' + '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });


            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
            infowindow.open(map, marker);
        }

        window.initMap = initMap;

        $("#maporder").on('click', function() {

            url = "https://www.google.com.sa/maps/search/@" + {{ $order->latitude }} + "," +
                {{ $order->longitude }} + ",12.21z?hl=en";

            window.open(url, '_blank');


        });

        $(document).ready(function() {
            $(function() {

                //check if modal_div element exists on the page
                if ($('#ModalChangeStatusOrdervalid').length > 0) {

                    //Attach Parsley validation to the modal input elements


                    //On modal submit button click, validate all the input fields
                    $('#modal_changeorder_submit_button').click(function(event) {


                        $('#ModalChangeStatusOrdervalid select').each(function() {
                            if ($(this).parsley().validate() !== true)
                                event.preventDefault();
                        })


                    });
                }
            });




            $(function() {

                //check if modal_div element exists on the page
                if ($('#ModalMethodStatusOrdervalid').length > 0) {

                    //Attach Parsley validation to the modal input elements


                    //On modal submit button click, validate all the input fields
                    $('#modal_changemethodstatus_submit_button').click(function(event) {


                        $('#ModalMethodStatusOrdervalid select').each(function() {
                            if ($(this).parsley().validate() !== true)
                                event.preventDefault();
                        })


                    });
                }
            });

            @if ($errors->ModalChangeStatusOrderbag->any())
                $('#ModalChangeStatusOrder').modal({
                    show: true
                });
            @endif

            @if ($errors->ModalChangeMethodStatusOrderbag->any())
                $('#ModalChangeMethodStatusOrder').modal({
                    show: true
                });
            @endif

        });
    </script> --}}
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB556JrqytIxxt2hT5hkpLBQdUblve3w5U&language=ar&callback=initMap">
    </script>
    <!-- Internal Gallery js -->
    <script src="{{ URL::asset('assets/plugins/gallery/lightgallery-all.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/gallery/jquery.mousewheel.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/gallery.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Get CSRF token from meta tag
            const csrfToken = '{{ csrf_token() }}';

            // Event listener for dynamically updating product price, image, and total
            $(document).on('change', '.product-select', function() {
                const selectedProductId = $(this).val();
                const row = $(this).closest('tr');

                // Fetch product details via API
                fetch(`/mall/fetch-products/${selectedProductId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update the product image
                        row.find('.product-image').attr('src', data.image);

                        // Update the price input field
                        row.find('.price-input').val(data.price);

                        // Recalculate the total
                        const qty = row.find('.qty-input').val();
                        const total = qty * data.price;
                        row.find('.total').text(total);
                    })
                    .catch(error => console.error('Error fetching product details:', error));
            });

            // Event listener for qty and price input changes
            $(document).on('input', '.qty-input, .price-input', function() {
                const row = $(this).closest('tr');
                const qty = row.find('.qty-input').val();
                const price = row.find('.price-input').val();
                const total = qty * price;
                row.find('.total').text(total);
            });


            // Submit handler for dynamically added rows
            $(document).on('click', '.btn-store', function(e) {
                e.preventDefault();
                const uniqueId = $(this).attr('id').split('-')[1];
                const form = $(`#form-${uniqueId}`);
                form.submit(); // Submit the specific form
            });
        });

        $(document).on('click', '#deleteproductItem', function() {
            // $('#deleteModal').modal('show');
            $('#deleteProductForm').attr('action', $(this).data('url'));
        });

        $(document).on('click', '#deleteOrderBtn', function() {
            // $('#deleteModal').modal('show');
            $('#deleteProductForm').attr('action', $(this).data('url'));
        });
    </script>
@endsection
