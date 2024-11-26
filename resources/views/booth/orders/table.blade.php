<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.date') }}</th>
                <th>{{ __('main.client') }}</th>
            <th>{{ __('main.payment_method') }}</th>
            <th>{{ __('main.payment_status') }}</th>
                <th>{{ __('main.total') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.section') }}</th>
                <th>{{ __('main.store') }}</th>
                <th>{{ __('main.actions') }}</th>
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
                        <a href="{{ asset($order->user->image) }}" class="text-dark d-flex" download>
                            <img src="{{ asset($order->user->image) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                                <div class="">
                                    {{ $order->user->name ?? '' }} <br>
                                    <sbooth>{{ $order->user->phone ?? '' }}</sbooth>
                                </div>
                        </a>
                    </td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->payment_condition }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->orderStatus->name }}</td>
                    <td>{{ $order->store->section->name }}</td>
                    <td>{{ $order->store->name }}</td>
                    <td>
                        <a href="{{ route('booth.orders.show', $order->id) }}"
                            class="btn btn-primary">{{ __('main.show') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('booth.orders.destroy', $order->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $orders->links() }}</div>
</div>
