@extends('mall.layouts.master')
@section('title')
    {{ __('mall.create_order') }}
@endsection
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <style>
        .custom-checkbox-toggle {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .custom-checkbox-toggle input {
            opacity: 0;
            position: absolute;
            z-index: -1;
        }

        .custom-checkbox-toggle label {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding-left: 2.5rem;
            font-size: 1rem;
            color: #333;
            transition: color 0.3s ease;
        }

        .custom-checkbox-toggle label::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2rem;
            height: 1.2rem;
            background-color: #ddd;
            border-radius: 2rem;
            transition: background-color 0.3s ease;
        }

        .custom-checkbox-toggle label::after {
            content: '';
            position: absolute;
            left: 0.2rem;
            width: 1rem;
            height: 1rem;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .custom-checkbox-toggle input:checked+label::before {
            background-color: #025cd8;
            /* Change this to the color you prefer for active state */
        }

        .custom-checkbox-toggle input:checked+label::after {
            transform: translateX(0.8rem);
            /* Adjust this based on the width of your toggle */
        }

        .custom-checkbox-toggle input:checked+label {
            color: #025cd8;
            /* Change this to the text color when active */
        }

        .image-box {
            position: relative;
            display: inline-block;
        }

        .image-box img {
            max-width: 150px;
            height: auto;
        }

        .delete-image,
        .remove-image {
            top: -10px;
            right: -10px;
            cursor: pointer;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">{{ __('mall.home') }}</h5>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('mall.orders.index') }}">{{ __('mall.orders') }}</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a class="text-dark"
                        href="{{ route('mall.orders.create') }}">{{ __('mall.create_order') }}</a></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('mall.orders.index') }}" class="btn btn-secondary ">{{ __('mall.back') }}</a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('mall.orders') }}</h4>
                    </div>
                </div>
                <form id="createOrderForm" method="post" action="{{ route('mall.orders.store') }}"
                    data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="main-content-label mg-b-5">
                            {{ __('mall.create_order') }}
                        </div>
                        <div id="wizard1">
                            <h3>{{ __('mall.General_Information') }}</h3>
                            <section>
                                <div class="row">
                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.name') }}(AR): <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" name="name_ar"
                                            placeholder="{{ __('mall.enter_name') }}" required="" type="text"
                                            value="{{ old('name_ar') }}">
                                        @error('name_ar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.name') }}(EN): <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" name="name_en"
                                            placeholder="{{ __('mall.enter_name') }}" required="" type="text"
                                            value="{{ old('name_en') }}">
                                        @error('name_en')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.description') }}(AR): <span
                                                class="tx-danger">*</span></label>
                                        <textarea class="form-control" name="description_ar" placeholder="{{ __('mall.enter_description') }}" required=""> {{ old('description_ar') }} </textarea>
                                        @error('description_ar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.description') }}(EN): <span
                                                class="tx-danger">*</span></label>
                                        <textarea class="form-control" name="description_en" placeholder="{{ __('mall.enter_description') }}" required=""> {{ old('description_en') }} </textarea>
                                        @error('description_en')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.price') }}:</label>
                                        <input class="form-control" type="number" name="price"
                                            placeholder="{{ __('mall.enter_price') }}" type="price"
                                            value="{{ old('price') }}">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.offer') }}:</label>
                                        <input class="form-control" type="number" name="offer"
                                            placeholder="{{ __('mall.enter_offer') }}" type="offer"
                                            value="{{ old('offer') }}">
                                        @error('offer')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.start_offer_date') }}:</label>
                                        <input class="form-control" type="date" name="start_offer_date"
                                            placeholder="{{ __('mall.enter_start_offer_date') }}" type="start_offer_date"
                                            value="{{ old('start_offer_date') }}">
                                        @error('start_offer_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.end_offer_date') }}:</label>
                                        <input class="form-control" type="date" name="end_offer_date"
                                            placeholder="{{ __('mall.enter_end_offer_date') }}" type="end_offer_date"
                                            value="{{ old('end_offer_date') }}">
                                        @error('end_offer_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.inventory') }}:</label>
                                        <input class="form-control" type="number" name="qty"
                                            placeholder="{{ __('mall.enter_qty') }}" type="qty"
                                            value="{{ old('qty') }}">
                                        @error('qty')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.section') }}: </label>
                                        <select class="form-control select2" name="section_id" id="sectionId">
                                            <option selected>{{ __('mall.select') }}</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    @if (old('section_id') == $section->id) selected @endif>{{ $section->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.store') }}: </label>
                                        <select class="form-control select2" name="store_id" id="storeId">
                                            <option selected>{{ __('mall.select') }}</option>
                                            @foreach ($stores as $store)
                                                <option value="{{ $store->id }}"
                                                    @if (old('store_id') == $store->id) selected @endif>{{ $store->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('store_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.category') }}: </label>
                                        <select class="form-control select2" name="category_id" id="categoryId">
                                            <option selected>{{ __('mall.select') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.brand') }}: </label>
                                        <select class="form-control select2" name="brand_id" id="brandId">
                                            <option selected>{{ __('mall.select') }}</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    @if (old('brand_id') == $brand->id) selected @endif>{{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mg-b-0">
                                        <label class="form-label">{{ __('mall.status') }}: <span
                                                class="tx-danger">*</span></label>
                                        <select required class="form-control" name="is_active">
                                            <option value="0" @if (old('is_active') == 0) selected @endif>
                                                {{ __('mall.not_active') }}</option>
                                            <option value="1" @if (old('is_active') == 1) selected @endif>
                                                {{ __('mall.active') }}</option>
                                        </select>
                                        @error('is_active')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </section>
                            <h3>{{ __('mall.order_attributes') }}</h3>
                            <section>
                                <div class="attibutes">
                                    <div class="attribute row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Attribute">{{ __('mall.attribute') }}</label>
                                                <select name="attributes[]" id="Attribute" class="form-control">
                                                    <option selected disabled>{{ __('mall.select') }}</option>
                                                    @foreach ($attributes as $attribute)
                                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="option">{{ __('mall.options') }}</label>
                                                <select name="options[]" id="option"
                                                    class="form-control optionSelect">
                                                    <option selected disabled>{{ __('mall.select') }}</option>
                                                    @foreach ($options as $option)
                                                        <option value="{{ $option->id }}">{{ $option->value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="ckbox">
                                                    <input checked="" class="isRequiredCheckbox" name="is_required[]"
                                                        type="checkbox">
                                                    <span>
                                                        {{ __('mall.is_required') }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="price">{{ __('mall.additional_price') }}</label>
                                                <input type="number" class="form-control" name="costs[]" value="0"
                                                    id="price">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" id="createAttribute" class="btn btn-primary">+</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <h3>{{ __('mall.order_images') }}</h3>
                            <section>
                                <div class="row">
                                    <div class="col-md-12 form-group mt-4">
                                        <div class="custom-file">
                                            <label class="custom-file-label"
                                                for="customFile">{{ __('mall.image') }}</label>
                                            <input class="custom-file-input" required id="customFile" type="file"
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
                                        <div id="image-preview" class="mt-4 d-flex flex-wrap"></div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </form>
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
@section('js')
    <!--Internal  Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
    <!-- Internal Jquery.steps js -->
    <script src="{{ URL::asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script> --}}
    <!--Internal  Form-wizard js -->
    {{-- <script src="{{ URL::asset('assets/js/form-wizard.js') }}"></script> --}}


    @include('mall.orders._dynamic_selector')

    <script>
        $(document).on('change', '#Attribute', async function() {
            const attributeId = $(this).val();
            const attributeElement = $(this); // Store reference to the triggering element

            $.ajax({
                type: "GET",
                url: "{{ route('mall.options.byAttribute') }}",
                data: {
                    attributeId: attributeId
                },
                dataType: "html", // Assuming the response is HTML; change if necessary
                success: function(response) {
                    // Use the stored reference to find the nearest '.optionSelect' element
                    attributeElement.closest('.attribute').find('.optionSelect').html(response);
                    attributeElement.closest('.attribute').find('.isRequiredCheckbox').attr('value',
                        attributeId);
                },
                error: function(error) {
                    console.error('Error fetching options:', error);
                }
            });
        });
    </script>


    <script>
        $(document).on('click', '#createAttribute', function(e) {
            e.preventDefault();
            let $clone = $('.attribute:first').clone();
            $clone.find('#createAttribute').parent().remove(); // Remove the create button
            $clone.append(
                '<div class="col-md-2"><a href="#" class="btn btn-danger removeAttribute">-</a></div>'
            ); // Add a delete button
            $('.attibutes').append($clone);
        });

        $(document).on('click', '.removeAttribute', function(e) {
            e.preventDefault();
            $(this).closest('.attribute').remove();
        });
    </script>


<script>
    $(document).ready(function() {
        // When images are selected
        $(document).on('change', '#customFileMulti', function(e) {
            const files = e.target.files;
            const previewContainer = $('#image-preview');
            previewContainer.empty(); // Clear existing previews

            // Loop through selected images
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Create a preview box for each image
                    const previewBox = $(`
                        <div class="image-box position-relative m-2">
                            <img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px; height: auto;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image" data-index="${index}">&times;</button>
                        </div>
                    `);

                    previewContainer.append(previewBox);
                };

                reader.readAsDataURL(file); // Read the image file
            });
        });

        // Remove image on click
        $(document).on('click', '.remove-image', function() {
            const index = $(this).data('index');
            const fileInput = $('#customFileMulti')[0]; // Corrected to match the input element's ID

            // Create a DataTransfer object to manipulate files
            const dt = new DataTransfer();

            // Loop through files and add them back, excluding the one that needs to be removed
            Array.from(fileInput.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });

            // Re-assign the updated files list to the input
            fileInput.files = dt.files;

            // Refresh the preview container
            $(this).closest('.image-box').remove();
        });
    });

    $(document).on('click', '.delete-image', function() {
        $('#imageIDInput').val($(this).data('id'));
    });
</script>



    <script>
        $(function() {
            'use strict'
            $('#wizard1').steps({
                headerTag: 'h3',
                bodyTag: 'section',
                autoFocus: true,
                titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
                onFinished: function(event, currentIndex) {
                    // Submit the form when the user finishes the wizard
                    $("#createOrderForm").submit();
                }
            });
        });
    </script>
@endsection
