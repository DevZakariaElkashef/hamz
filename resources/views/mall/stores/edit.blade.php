@extends('mall.layouts.master')
@section('title')
    {{ __('mall.edit_store') }}
@endsection

@include('mall.stores.style')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">{{ __('mall.home') }}</h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('mall.stores.index') }}">{{ __('mall.stores') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('mall.stores.create') }}">{{ __('mall.create_store') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('mall.stores.index') }}" class="btn btn-secondary ">{{ __('mall.back') }}</a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="modal" id="deleteImageModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('mall.filter') }}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('images.destroy') }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="image_id" id="imageIDInput">
                    <div class="modal-body">
                        {{ __("mall.Are you sure!") }}
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" type="submit">{{ __('mall.delete') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('mall.Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('mall.stores') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('mall.stores.update', $store->id) }}" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $store->id }}">
                        <div class="row">
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.name') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="name_ar" placeholder="{{ __('mall.enter_name') }}"
                                    required="" type="text" value="{{ old('name_ar') ?? $store->name_ar }}">
                                @error('name_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.name') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="name_en" placeholder="{{ __('mall.enter_name') }}"
                                    required="" type="text" value="{{ old('name_en') ?? $store->name_en }}">
                                @error('name_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.description') }}(AR): <span
                                        class="tx-danger">*</span></label>
                                <textarea class="form-control" name="description_ar" placeholder="{{ __('mall.enter_description') }}" required="">{{ old('description_ar') ?? $store->description_ar }}</textarea>
                                @error('description_ar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.description') }}(EN): <span
                                        class="tx-danger">*</span></label>
                                <textarea class="form-control" name="description_en" placeholder="{{ __('mall.enter_description') }}" required="">{{ old('description_en') ?? $store->description_en }}</textarea>
                                @error('description_en')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.phone') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="phone" placeholder="{{ __('mall.enter_phone') }}"
                                    required="" type="text" value="{{ old('phone') ?? $store->phone }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.sections') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control select2" name="section_id">
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"
                                            @if (old('section_id') == $section->id || $store->section_id == $section->id) selected @endif>
                                            {{ $section->name }}</option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.sellers') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control select2" name="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if (old('user_id') == $user->id || $store->user_id == $user->id) selected @endif>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.lat') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="lat" placeholder="{{ __('mall.enter_lat') }}"
                                    required="" type="text" value="{{ old('lat') ?? $store->lat }}">
                                @error('lat')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.lng') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control" name="lng" placeholder="{{ __('mall.enter_lng') }}"
                                    required="" type="text" value="{{ old('lng') ?? $store->lng }}">
                                @error('lng')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.address') ?? $store->address }}: <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="address" placeholder="{{ __('mall.enter_address') }}"
                                    required="" type="text" value="{{ old('address') ?? $store->address }}">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mg-b-0">
                                <label class="form-label">{{ __('mall.status') }}: <span
                                        class="tx-danger">*</span></label>
                                <select required class="form-control" name="is_active">
                                    <option value="0" @if (old('is_active') == 0 || $store->is_active == 0) selected @endif>
                                        {{ __('not_active') }}</option>
                                    <option value="1" @if (old('is_active') == 1 || $store->is_active == 1) selected @endif>
                                        {{ __('active') }}</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mt-4">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="customFile">{{ __('mall.image') }}</label>
                                    <input class="custom-file-input" id="customFile" type="file"
                                        name="image">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-12 form-group mt-4">
                                <div class="custom-file">
                                    <label class="custom-file-label"
                                        for="customFileMulti">{{ __('mall.images') }}</label>
                                    <input class="custom-file-input" multiple id="customFileMulti" type="file"
                                        name="images[]" accept="image/*">
                                    @error('images')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="image-preview" class="mt-4 d-flex flex-wrap">
                                    @foreach ($store->images as $image)
                                        <div class="image-box position-relative m-2">
                                            <img src="{{ asset($image->path) }}">
                                            <button type="button" data-id="{{ $image->id }}" data-toggle="modal" data-effect="effect-flip-vertical"
                                                data-target="#deleteImageModal"
                                                class="btn btn-danger delete-image btn-sm position-absolute top-0 end-0"
                                                data-index="3">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="custom-checkbox-toggle">
                                    <input type="checkbox" value="1" id="pick_up"
                                        @if ($store->pick_up) checked @endif name="pick_up">
                                    <label for="pick_up">{{ __('mall.Pick_Up_From_The_Store') }}</label>
                                </div>
                                @error('pick_up')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="custom-checkbox-toggle">
                                    <input type="checkbox" value="1" id="delivery_type"
                                        @if ($store->delivery_type) checked @endif name="delivery_type">
                                    <label for="delivery_type">{{ __("mall.Store_Has_Delivery") }}</label>
                                </div>
                                @error('delivery_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>





                            <div class="col-12 mg-t-10 mg-sm-t-25">
                                <button class="btn btn-main-primary pd-x-20"
                                    type="submit">{{ __('mall.submit') }}</button>
                            </div>
                        </div>
                    </form>
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

@include('mall.stores.script')
