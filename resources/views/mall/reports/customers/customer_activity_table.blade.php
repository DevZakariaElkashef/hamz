<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('mall.client') }}</th>
                <th>{{ __('mall.phone') }}</th>
                <th>{{ __('mall.total_orders') }}</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->orders_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">
        {{ $customers->links() }}
    </div>
</div>
