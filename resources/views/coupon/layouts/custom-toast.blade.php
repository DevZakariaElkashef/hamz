@php
    $toastPosition = app()->getLocale() == 'en' ? 'right: 20px;' : 'left: 20px;';
@endphp
@if (session('success') || session('error'))
    <div class="demo-static-toast" style="z-index: 10000000; position: fixed; bottom: 20px; {{ $toastPosition }}">
        <div aria-atomic="true" aria-live="assertive" class="toast fade show" role="alert">
            <div class="toast-body text-light"
                style="background-color: {{ session('success') ? '#007f00' : '#c82333' }};">
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    </div>
@endif


<div class="demo-static-toast success-toast d-none"
    style="z-index: 10000000; position: fixed; bottom: 20px; {{ $toastPosition }}">
    <div aria-atomic="true" aria-live="assertive" class="toast fade show" role="alert">
        <div class="toast-body text-light" style="background-color: #007f00;">

        </div>
    </div>
</div>
<div class="demo-static-toast error-toast d-none"
    style="z-index: 10000000; position: fixed; bottom: 20px; {{ $toastPosition }}">
    <div aria-atomic="true" aria-live="assertive" class="toast fade show" role="alert">
        <div class="toast-body text-light" style="background-color: #c82333;">

        </div>
    </div>
</div>
