<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('mall.id') }}</th>
                <th>{{ __('mall.code') }}</th>
                <th>{{ __('mall.discount') }}</th>
                <th>{{ __('mall.max_usage') }}</th>
                <th>{{ __('mall.used_times') }}</th>
                <th>{{ __('mall.status') }}</th>
                <th>{{ __('mall.actions') }}</th>
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
                                data-url="{{ route('mall.coupon.toggleStatus', $coupon->id) }}"
                                {{ $coupon->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>


                    <td>
                        <a href="{{ route('mall.coupons.edit', $coupon->id) }}"
                            class="btn btn-secondary">{{ __('mall.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('mall.coupons.destroy', $coupon->id) }}"
                            data-target="#deletemodal">{{ __('mall.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $coupons->links() }}</div>
</div>
