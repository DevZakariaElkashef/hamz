<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.video') }}</th>
                <th>{{ __('main.user') }}</th>
                <th>{{ __('main.is_watched') }}</th>
                <th>{{ __('main.watched_at') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($views as $view)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $view->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ asset($view->video->path) }}" download>
                            <img src="{{ asset($view->video->thumbnail) }}"
                                style="display: inline-block; border-radius: 50%;" width="40" height="40"
                                alt="">
                            {{ $view->video->title ?? '' }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ asset($view->user->image) }}" download>
                            <img src="{{ asset($view->user->image) }}"
                                style="display: inline-block; border-radius: 50%;" width="40" height="40"
                                alt="">
                            {{ $view->user->name ?? '' }}
                        </a>
                    </td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $view->id }}"
                                data-url="{{ route('earn.view.toggleStatus', $view->id) }}"
                                {{ $view->status ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>{{ $view->created_at }}</td>

                    <td>
                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical" data-url="{{ route('earn.views.destroy', $view->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $views->links() }}</div>
</div>
