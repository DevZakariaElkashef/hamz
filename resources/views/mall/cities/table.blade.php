<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('mall.id') }}</th>
                <th>{{ __('mall.name') }}</th>
                <th>{{ __('mall.status') }}</th>
                <th>{{ __('mall.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cities as $city)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $city->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $city->name }}</td>
                    <td>
                        @if ($city->is_active)
                            <span class="badge badge-primary">{{ __('mall.active') }}</span>
                        @else
                            <span class="badge badge-secondary">{{ __('mall.not_active') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mall.cities.edit', $city->id) }}"
                            class="btn btn-secondary">{{ __('mall.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('mall.cities.destroy', $city->id) }}"
                            data-target="#deletemodal">{{ __('mall.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $cities->links() }}</div>
</div>
