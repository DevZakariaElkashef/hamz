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
                <th>الحد الاقصي للمشاهدات</th>
                <th>الباقه</th>
                <th>الحاله</th>
                <th>{{ __('main.url') }}</th>
                @if (auth()->user()->role->name == 'super-admin')  
                    <th>{{ __('main.status') }}</th>
                @endif
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($videos as $video)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $video->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $video->title }}</td>
                    <td>{{ $video->store->name ?? '' }}</td>
                    <td>{{ $video->reword_amount . '    ' . __('main.sar') }}</td>
                    <td>{{ $video->viewed_count }}</td>
                    <td>{{ $video->package ? $video->package->limit : 0 }}</td>
                    <td>{{ $video->package ? $video->package->name : "" }}</td>
                    @if ($video->is_active)
                        <td>{{ $video->payment_status ? "مفعل" : "غير مفعل" }}</td>
                    @else
                        <td>في انتظار الموافقه</td>
                    @endif
                    <td>
                        <a href="{{ $video->path }}" target="_blank">{{ __("main.show") }}</a>
                    </td>
                    @if (auth()->user()->role->name == 'super-admin')    
                        <td>
                            <label class="custom-toggle-switch">
                                <input type="checkbox" class="custom-toggle-input" data-id="{{ $video->id }}"
                                    data-url="{{ route('earn.video.toggleStatus', $video->id) }}"
                                    {{ $video->is_active ? 'checked' : '' }}>
                                <span class="custom-toggle-slider"></span>
                            </label>
                        </td>
                    @endif

                    <td class="d-flex justify-content-center">
                        @if (($status == 'unpaid' || $status == 'all') && $video->payment_status == 0 && $video->is_active )
                            <a href="{{ route('earn.subscripe.create', $video->id) }}"
                                class="btn m-1 btn-primary">تفعيل
                            </a>
                        @endif
                        <a href="{{ route('earn.videos.edit', $video->id) }}"
                            class="btn m-1 btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn m-1 btn-danger delete-btn" data-toggle="modal"
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
