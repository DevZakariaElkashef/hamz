<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.store') }}</th>
                {{-- <th>{{ __('main.name') }}</th> --}}
                <th>{{ __('main.image') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $category->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $category->store->name ?? '' }}</td>
                    <td>{{ $category->name }}</td>
                    {{-- <td>
                        <a href="{{ asset($category->image) }}" download>
                            <img src="{{ asset($category->image) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                        </a>
                    </td> --}}
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $category->id }}"
                                data-url="{{ route('booth.categories.toggleStatus', $category->id) }}"
                                {{ $category->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('booth.categories.edit', $category->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('booth.categories.destroy', $category->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $categories->links() }}</div>
</div>
