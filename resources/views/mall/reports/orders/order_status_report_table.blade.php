<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('mall.status') }}</th>
                <th>{{ __('mall.total_orders') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $sale)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->status }}</td>
                <td>{{ $sale->total_orders }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="my-3">
        {{ $orders->links() }}
    </div>
</div>
