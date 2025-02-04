<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.wallet_type') }}</th>
                <th>{{ __('main.withdraw_type') }}</th>
                <th>{{ __('main.iban') }}</th>
                <th>{{ __('main.amount') }}</th>
                <th>{{ __('main.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdraws as $withdraw)
                <tr>
                    <td>{{ $withdraw->id }}</td>
                    <td>{{ __("main.wallet_type_$withdraw->wallet_type") }}</td>
                    <td>{{ __("main.withdraw_type_$withdraw->withdraw_type") }}</td>
                    <td>{{ $withdraw->iban ?? __('admin.not_found') }}</td>
                    <td>{{ $withdraw->amount }}</td>
                    <td>{{$withdraw->statusName}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $withdraws->links() }}</div>
</div>
