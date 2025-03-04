<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.order_id') }}</th>
                @if ( auth()->user()->role->name == 'super-admin' )
                    <th>{{ __('main.Vendor_Name') }}</th>
                @endif
                <th>{{ __('main.commission_value') }}</th>
                <th>{{ __('main.commission_percentage') }}</th>
                <th>{{ __('main.date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($commissions as $commission)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $commission->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    @if ( auth()->user()->role->name == 'super-admin' )
                        <td>{{ $commission->user->name ?? '' }}</td>
                    @endif
                    <td>{{ $commission->total_amount ?? 0 }}</td>
                    <td>{{ $commission->commission_percentage ?? 0 }} %</td>
                    <td>{{ \Carbon\Carbon::parse($commission->time)->format('Y-m-d, h:i A') }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="my-3">{{ $sections->links() }}</div> --}}
</div>
