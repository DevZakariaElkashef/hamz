<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.image') }}</th>
                <th>{{ __('main.url') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $slider)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $slider->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $slider->name }}</td>
                    <td>
                        <a href="{{ asset($slider->image) }}" download>
                            <img src="{{ asset($slider->image) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                        </a>
                    </td>
                    <td>{{ $slider->url }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $slider->id }}"
                                data-url="{{ route('earn.slider.toggleStatus', $slider->id) }}"
                                {{ $slider->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>

                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input custom-toggle-input-is-fixed" data-id="{{ $slider->id }}"
                                data-url="{{ route('booth.slider.toggleFixedStatus', $slider->id) }}"
                                {{ $slider->is_fixed ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>

                    <td>
                        <a href="{{ route('earn.sliders.edit', $slider->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('earn.sliders.destroy', $slider->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $sliders->links() }}</div>
</div>
