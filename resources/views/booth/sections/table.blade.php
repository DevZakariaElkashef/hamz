<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.image') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sections as $section)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $section->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $section->name }}</td>
                    <td>
                        <a href="{{ asset($section->image) }}" download>
                            <img src="{{ asset($section->image) }}"
                                style="display: inline-block; border-radius: 50%;" width="40"
                                height="40" alt="">
                        </a>
                    </td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $section->id }}"
                                data-url="{{ route('booth.sections.toggleStatus', $section->id) }}"
                                {{ $section->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('booth.sections.edit', $section->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('booth.sections.destroy', $section->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $sections->links() }}</div>
</div>
