<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.order_id') }}</th>
                @if ( auth()->user()->role->name == 'super-admin' )
                    <th>{{ __('main.Vendor_Name') }}</th>
                @endif
                {{-- <th>{{ __('main.section') }}</th> --}}
                <th>{{ __('main.total') }}</th>
                <th>{{ __('main.commission_percentage') }}</th>
                <th>{{ __('main.commission_value') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $order->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    @if ( auth()->user()->role->name == 'super-admin' )
                        <td>{{ $order->store->user->name ?? '' }}</td>
                    @endif
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->commission ?? 0 }} %</td>
                    <td>{{ $order->commission_value }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="my-3">{{ $sections->links() }}</div> --}}
</div>
