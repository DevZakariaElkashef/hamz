<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.store') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.image') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $brand->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $brand->store->name ?? '' }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>
                        <a href="{{ asset($brand->image) }}" download>
                            <img src="{{ asset($brand->image) }}"
                                style="display: inline-block; border-radius: 50%;" width="40"
                                height="40" alt="">
                        </a>
                    </td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $brand->id }}"
                                data-url="{{ route('booth.brands.toggleStatus', $brand->id) }}"
                                {{ $brand->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('booth.brands.edit', $brand->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('booth.brands.destroy', $brand->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $brands->links() }}</div>
</div>
