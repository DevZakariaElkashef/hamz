<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.image') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apps as $apps)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $apps->name }}</td>
                    <td>
                        <a href="{{ asset($apps->logo) }}" download>
                            <img src="{{ asset($apps->logo) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                        </a>
                    </td>

                    <td>
                        <a href="{{ route('apps.edit', $apps->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="my-3">{{ $apps->links() }}</div> --}}
</div>
