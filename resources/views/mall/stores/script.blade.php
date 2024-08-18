@section('js')
    <!--Internal  Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        $(document).ready(function() {
            // When images are selected
            $('#customFileMulti').on('change', function(e) {
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
                const fileInput = $('#customFile')[0];

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


        $(document).on('click', '.delete-image', function()
    {
        $('#deleteImageModal').modal('show');
    });
    </script>
@endsection
