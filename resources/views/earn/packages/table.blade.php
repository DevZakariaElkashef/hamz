<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.limit') }}</th>
                <th>قيمه المكافأه</th>
                {{-- <th>{{ __('main.period_in_days') }}</th> --}}
                <th>{{ __('main.price') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $package->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $package->name }}</td>
                    <td>{{ $package->limit }}</td>
                    {{-- <td>{{ $package->period_in_days }}</td> --}}
                    <td>{{ $package->reword_amount ?? 0 }} {{ __("main.sar")  }}</td>
                    <td>{{ $package->price . ' ' . __("main.sar") }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $package->id }}"
                                data-url="{{ route('earn.package.toggleStatus', $package->id) }}"
                                {{ $package->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>



                    <td>
                        <a href="{{ route('earn.packages.edit', $package->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('earn.packages.destroy', $package->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $packages->links() }}</div>
</div>
