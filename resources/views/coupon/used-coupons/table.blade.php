<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                {{-- <th>{{ __('main.id') }}</th> --}}
                <th>{{ __('main.code') }}</th>
                <th>{{ __('main.store') }}</th>
                <th>{{ __('main.user_image') }}</th>
                <th>{{ __('main.user_name') }}</th>
                <th>{{ __('main.user_phone') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usedCoupons as $coupon)
                <tr>
                    <th class="text-end p-1">
                        <input type="checkbox" class="checkbox-input" value="{{ $coupon->id }}">
                    </th>
                    {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->store_name ?? null }}</td>
                    <td>
                        <img src="{{ asset($coupon->user_image) }}" style="display: inline-block; border-radius: 50%;"
                            width="40" height="40" alt="">
                    </td>
                    <td>{{ $coupon->user_name }}</td>
                    <td>{{ $coupon->user_phone }}</td>
                    <td>
                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('coupon.used-coupons.destroy', $coupon->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $usedCoupons->links() }}</div>
</div>
