<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.code') }}</th>
                <th>{{ __('main.discount') }}</th>
                <th>{{ __('main.max_usage') }}</th>
                <th>{{ __('main.used_times') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $coupon)
                <tr>
                    <th class="text-end p-1">
                        <input type="checkbox" class="checkbox-input" value="{{ $coupon->id }}">
                    </th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->discount }}</td>
                    <td>{{ $coupon->max_usage }}</td>
                    <td>{{ $coupon->users->count() }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $coupon->id }}"
                                data-url="{{ route('coupon.coupon.toggleStatus', $coupon->id) }}"
                                {{ $coupon->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>


                    <td>
                        <a href="{{ route('coupon.coupons.edit', $coupon->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('coupon.coupons.destroy', $coupon->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $coupons->links() }}</div>
</div>
