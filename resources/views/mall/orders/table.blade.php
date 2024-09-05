<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('mall.id') }}</th>
                <th>{{ __('mall.date') }}</th>
                <th>{{ __('mall.client') }}</th>
            <th>{{ __('mall.payment_method') }}</th>
            <th>{{ __('mall.payment_status') }}</th>
                <th>{{ __('mall.total') }}</th>
                <th>{{ __('mall.status') }}</th>
                <th>{{ __('mall.price') }}</th>
                <th>{{ __('mall.section') }}</th>
                <th>{{ __('mall.store') }}</th>
                <th>{{ __('mall.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $order->id }}">
                    </th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <a href="{{ asset($order->user->image) }}" class="text-dark" download>
                            <img src="{{ asset($order->user->image) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                            {{ $order->user->name }}
                        </a>
                    </td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->payment_condition }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->orderStatus->name }}</td>
                    <td>{{ $order->store->section->name }}</td>
                    <td>{{ $order->store->name }}</td>
                    <td>{{ $order->calc_price }}</td>
                    <td>
                        <a href="{{ route('mall.orders.show', $order->id) }}"
                            class="btn btn-primary">{{ __('mall.show') }}</a>
                        <a href="{{ route('mall.orders.edit', $order->id) }}"
                            class="btn btn-secondary">{{ __('mall.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('mall.orders.destroy', $order->id) }}"
                            data-target="#deletemodal">{{ __('mall.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $orders->links() }}</div>
</div>
