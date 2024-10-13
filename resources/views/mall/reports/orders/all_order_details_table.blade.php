<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('main.Order_number') }}</th>
                <th>{{ __('main.product') }}</th>
                <th>{{ __('main.qty') }}</th>
                <th>{{ __('main.price') }}</th>
                <th>{{ __('main.total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $detail)
                <tr>
                    <td>
                        <a href="{{ route('mall.orders.show', $detail->order_id) }}">
                            {{ $detail->order_id }}
                        </a>
                    </td>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->price }}</td>
                    <td>{{ $detail->order->sub_total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">
        {{ $orders->links() }}
    </div>
</div>
