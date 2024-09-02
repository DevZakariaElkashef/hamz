<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('mall.id') }}</th>
                <th>{{ __('mall.value') }}</th>
                <th>{{ __('mall.status') }}</th>
                <th>{{ __('mall.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $option)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $option->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $option->value }}</td>
                    <td>
                        @if ($option->is_active)
                            <span class="badge badge-primary">{{ __('mall.active') }}</span>
                        @else
                            <span class="badge badge-secondary">{{ __('mall.not_active') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mall.options.edit', $option->id) }}"
                            class="btn btn-secondary">{{ __('mall.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('mall.options.destroy', $option->id) }}"
                            data-target="#deletemodal">{{ __('mall.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $options->links() }}</div>
</div>
