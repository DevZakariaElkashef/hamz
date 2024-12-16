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
            @foreach ($applications as $application)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $application->name }}</td>
                    <td>
                        <a href="{{ asset($application->image) }}" download>
                            <img src="{{ asset($application->image) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                        </a>
                    </td>
                    <td>{{ $application->url }}</td>

                    <td>
                        <a href="{{ route('applications.edit', $application->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $applications->links() }}</div>
</div>
