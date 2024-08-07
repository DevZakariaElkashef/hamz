<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('mall.id') }}</th>
                <th>{{ __('mall.name') }}</th>
                <th>{{ __('mall.image') }}</th>
                <th>{{ __('mall.url') }}</th>
                <th>{{ __('mall.status') }}</th>
                <th>{{ __('mall.actions') }}</th>
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
                            <img src="{{ asset($slider->image) }}"
                                style="display: inline-block; border-radius: 50%;" width="40"
                                height="40" alt="">
                        </a>
                    </td>
                    <td>{{ $slider->url }}</td>
                    <td>
                        @if ($slider->is_active)
                            <span class="badge badge-primary">{{ __('mall.active') }}</span>
                        @else
                            <span class="badge badge-secondary">{{ __('mall.active') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mall.sliders.edit', $slider->id) }}"
                            class="btn btn-secondary">{{ __('mall.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('mall.sliders.destroy', $slider->id) }}"
                            data-target="#deletemodal">{{ __('mall.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $sliders->links() }}</div>
</div>
