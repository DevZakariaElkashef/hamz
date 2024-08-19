@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
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

        .delete-image {
            top: -10px;
            right: -10px;
            cursor: pointer;
        }
        .remove-image {
            top: -10px;
            right: -10px;
            cursor: pointer;
        }
    </style>
@endsection
