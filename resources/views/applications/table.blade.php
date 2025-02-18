<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.image') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apps as $app)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $app->name }}</td>
                    <td>
                        <a href="{{ asset($app->logo) }}" download>
                            <img src="{{ asset($app->logo) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                        </a>
                    </td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $app->id }}"
                                data-url="{{ route('app.toggleStatus', $app->id) }}"
                                {{ $app->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('apps.edit', $app->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="my-3">{{ $apps->links() }}</div> --}}
</div>
