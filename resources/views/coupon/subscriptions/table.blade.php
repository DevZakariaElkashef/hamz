<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                @if (auth()->user()->role_id != '3')
                    <th>{{ __('main.user') }}</th>
                @endif
                <th>{{ __('main.package') }}</th>
                <th>{{ __('main.limit') }}</th>
                <th>{{ __('main.used_count') }}</th>
                <th>{{ __('main.expire_date') }}</th>
                <th>{{ __('main.transaction_id') }}</th>
                <th>{{ __('main.status') }}</th>
                @if (auth()->user()->role_id != '3')
                    <th>{{ __('main.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $subscription->id }}">
                    </th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    @if (auth()->user()->role_id != '3')
                        <td>
                            <a href="{{ asset($subscription->user->image) }}" download>
                                {{ $subscription->user->name ?? '' }} <br>
                                <small>{{ $subscription->user->phone }}</small>
                                <img src="{{ asset($subscription->user->image) }}"
                                    style="display: inline-block; border-radius: 50%;" width="40" height="40"
                                    alt="">
                            </a>
                        </td>
                    @endif
                    <td>{{ $subscription->package->name ?? '' }}</td>
                    <td>{{ $subscription->limit }}</td>
                    <td>{{ $used }}</td>
                    <td>{{ $subscription->expire_date }}</td>
                    <td>{{ $subscription->transaction_id }}</td>
                    @if (auth()->user()->role_id != '3')
                        <td>
                            <select style="max-width: 150px;" class="form-control"
                                data-url="{{ route('earn.subscription.toggleStatus', $subscription) }}" name="status"
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
                        <td>
                            <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                                data-effect="effect-flip-vertical"
                                data-url="{{ route('earn.subscriptions.destroy', $subscription->id) }}"
                                data-target="#deletemodal">{{ __('main.delete') }}</a>
                        </td>
                    @else
                        <td>
                            @if (date('Y-m-d') > $subscription->expire_date)
                                {{ __('main.expired') }}
                            @elseif ($subscription->status == 0)
                                {{ __('main.pending') }}
                            @elseif ($subscription->status == 1)
                                {{ __('main.active') }}
                            @elseif ($subscription->status == 2)
                                {{ __('main.expired') }}
                            @elseif ($subscription->status == 3)
                                {{ __('main.cancelled') }}
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $subscriptions->links() }}</div>
</div>
