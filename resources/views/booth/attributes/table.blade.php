<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attributes as $attribute)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $attribute->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $attribute->name }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $attribute->id }}"
                                data-url="{{ route('booth.attributes.toggleStatus', $attribute->id) }}"
                                {{ $attribute->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('booth.attributes.edit', $attribute->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('booth.attributes.destroy', $attribute->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $attributes->links() }}</div>
</div>
