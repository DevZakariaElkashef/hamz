<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.store') }}</th>
                <th>{{ __('main.reword_amount') }}</th>
                <th>{{ __('main.views') }}</th>
                <th>{{ __('main.url') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($videos as $video)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $video->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $video->title }}</td>
                    <td>{{ $video->store->name }}</td>
                    <td>{{ $video->reword_amount . __('main.sar') }}</td>
                    <td>{{ $video->viewed_count }}</td>
                    <td>
                        <a href="{{ $video->path }}" target="_blank">{{ __("main.show") }}</a>
                    </td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $video->id }}"
                                data-url="{{ route('earn.video.toggleStatus', $video->id) }}"
                                {{ $video->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>

                    <td>
                        <a href="{{ route('earn.videos.edit', $video->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('earn.videos.destroy', $video->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $videos->links() }}</div>
</div>
