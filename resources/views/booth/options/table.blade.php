<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.value') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $option)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $option->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $option->value }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $option->id }}"
                                data-url="{{ route('booth.options.toggleStatus', $option->id) }}"
                                {{ $option->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('booth.options.edit', $option->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('booth.options.destroy', $option->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $options->links() }}</div>
</div>
