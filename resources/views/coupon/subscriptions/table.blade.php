<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.user') }}</th>
                <th>{{ __('main.package') }}</th>
                <th>{{ __('main.transaction_id') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $subscription->id }}">
                    </th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ asset($subscription->user->image) }}" download>
                            {{ $subscription->user->name ?? '' }} <br>
                            <small>{{ $subscription->user->phone }}</small>
                            <img src="{{ asset($subscription->user->image) }}"
                                style="display: inline-block; border-radius: 50%;" width="40" height="40"
                                alt="">
                        </a>
                    </td>
                    <td>{{ $subscription->package->name ?? '' }}</td>
                    <td>{{ $subscription->transaction_id }}</td>
                    <td>
                        <select style="max-width: 150px;" class="form-control"
                            data-url="{{ route('coupon.subscription.toggleStatus', $subscription) }}" name="status"
                            id="subscriptionStatus">
                            <option value="0" @if ($subscription->status == 0) selected @endif>
                                {{ __('main.pending') }}</option>
                            <option value="1" @if ($subscription->status == 1) selected @endif>
                                {{ __('main.active') }}</option>
                            <option value="2" @if ($subscription->status == 2) selected @endif>
                                {{ __('main.expired') }}</option>
                            <option value="3" @if ($subscription->status == 3) selected @endif>
                                {{ __('main.cancelled') }}</option>
                        </select>
                    </td>
                    </td>

                    <td>
                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('coupon.subscriptions.destroy', $subscription->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $subscriptions->links() }}</div>
</div>
