<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('main.client') }}</th>
                <th>{{ __('main.phone') }}</th>
                <th>{{ __('main.total_orders') }}</th>

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
