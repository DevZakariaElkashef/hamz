@extends('rfoof.layouts.master')
@section('title')
    التعليقات
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
            التعليقات
        @endslot
        @slot('title')
            التعليقات
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0">
                        التعليقات
                    </h4>


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
                                <th class="fw-bold">الاسم</th>
                                <th class="fw-bold">الايميل</th>
                                <th class="fw-bold">رقم الموبايل</th>
                                <th class="fw-bold">التعليق</th>
                                <th class="fw-bold">التقييم</th>
                                <th class="fw-bold">التاريخ</th>
                                <th class="fw-bold">اجراءت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($comments) == 0)
                                <tr class="align-middle">
                                    <td colspan="9" class="text-center">{{ __('admin.no_data') }}</td>
                                </tr>
                            @endif
                            @foreach ($comments as $count => $new)
                                <tr data-id="{{ $count + 1 }}">
                                    <td style="width: 80px" class="align-middle">{{ $count + 1 }}</td>
                                    <td class="align-middle">{{ $new->user->name }}</td>
                                    <td class="align-middle">{{ $new->user->email }}</td>
                                    <td class="align-middle">{{ $new->user->phone }}</td>
                                    <td class="align-middle">{{ $new->comment }}</td>
                                    <td class="align-middle">
                                        @if ($new->rate)
                                            @for ($f = 0; $f < $new->rate; $f++)
                                                <span class="fa fa-star checked"></span>
                                            @endfor
                                        @else
                                            <span class="fa fa-star checked"></span>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $new->created_at }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <button type="submit"
                                                class="modal-effect btn btn-outline-secondary bg-danger text-dark btn-sm"
                                                title="{{ __('admin.delete') }}" data-effect="effect-newspaper"
                                                data-toggle="modal" href="#myModal{{ $new->id }}">
                                                <i class="fas fa-trash-alt" style="color:white"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <div class="modal" id="myModal{{ $new->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">حذف التعليق</h5>
                                                    <button aria-label="Close" class="close" data-dismiss="modal"
                                                        type="button"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد حذف التعليق؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form class="d-inline" action="{{ route('rfoof.comments.delete') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('Delete')
                                                        <input type="hidden" name="new_id" value="{{ $new->id }}" />
                                                        <button type="button" class="btn btn-secondary waves-effect"
                                                            data-dismiss="modal">{{ __('admin.back') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-danger waves-effect waves-light">{{ __('admin.delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12 pagination-box">
                            {{ $comments->links() }}
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
