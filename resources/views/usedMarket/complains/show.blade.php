@extends('usedMarket.layouts.master')

@section('title')
    تفاصيل الشكوى
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            الشكاوي
        @endslot
        @slot('title')
            تفاصيل الشكوى
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0">
                        تفاصيل الشكوى # {{ $complain->id }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <h5 class="fw-bold">اسم المستخدم:</h5>
                            <p>{{ $complain->user->name }}</p>
                        </div>

                        <div class="mb-3 col-6">
                            <h5 class="fw-bold">البريد الإلكتروني:</h5>
                            <p>{{ $complain->user->email }}</p>
                        </div>

                        <div class="mb-3 col-6">
                            <h5 class="fw-bold">رقم الجوال:</h5>
                            <p>{{ $complain->user->phone }}</p>
                        </div>

                        <div class="mb-3 col-6">
                            <h5 class="fw-bold">المتنج:</h5>
                            <p>{{ $complain->product->name }}</p>
                        </div>

                        <div class="mb-3 col-6">
                            <h5 class="fw-bold">نص الشكوى:</h5>
                            <p>{{ $complain->message }}</p>
                        </div>

                        <div class="mb-3 col-6">
                            <h5 class="fw-bold">تاريخ الشكوى:</h5>
                            <p>{{ $complain->created_at->format('d/m/Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <div class="btn-group">
                            <button type="submit"
                                class="modal-effect btn btn-outline-secondary bg-danger text-dark btn-sm "
                                title="{{ __('admin.delete') }}" data-effect="effect-newspaper"
                                data-toggle="modal" href="#myModal{{ $complain->id }}">
                                <span style="color:white; padding-left: 5px; font-weight: bolder;">
                                    حذف الشكوى
                                </span>
                                <i class="fas fa-trash-alt" style="color:white"></i>
                            </button>
                        </div>

                        <div class="mr-3">
                            <a href="{{ route('usedMarket.complains') }}" class="btn btn-secondary">رجوع</a>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal" id="myModal{{ $complain->id }}">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h5 class="modal-title">حذف الشكوي</h5>
                                    <button aria-label="Close" class="close" data-dismiss="modal"
                                        type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>هل تريد حذف الشكوي؟</p>
                                </div>
                                <div class="modal-footer">
                                    <form class="d-inline" action="{{ route('usedMarket.complains.delete') }}"
                                        method="POST">
                                        @csrf
                                        @method('Delete')
                                        <input type="hidden" name="complainId"
                                            value="{{ $complain->id }}" />
                                        <button type="button" class="btn btn-secondary waves-effect"
                                            data-dismiss="modal">{{ __('admin.back') }}</button>
                                        <button type="submit"
                                            class="btn btn-danger waves-effect waves-light">{{ __('admin.delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
