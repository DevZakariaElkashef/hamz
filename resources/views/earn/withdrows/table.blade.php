<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.user') }}</th>
                <th>{{ __('main.iban') }}</th>
                <th>{{ __('main.amount') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdrows as $withdrow)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $withdrow->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ asset($withdrow->user->image) }}" download>
                            <img src="{{ asset($withdrow->user->image) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                            {{ $withdrow->user->name }}
                        </a>
                    </td>
                    <td>{{ $withdrow->iban }}</td>
                    <td>{{ $withdrow->amount }}</td>
                    <td>
                        <select style="max-width: 150px;" class="form-control" data-url="{{ route("earn.withdrow.toggleStatus", $withdrow) }}" name="status" id="withdrowStatus">
                            <option value="0" @if($withdrow->status == 0) selected @endif>{{ __("main.pending") }}</option>
                            <option value="1" @if($withdrow->status == 1) selected @endif>{{ __("main.confirmed") }}</option>
                            <option value="2" @if($withdrow->status == 2) selected @endif>{{ __("main.canceled") }}</option>
                            <option value="3" @if($withdrow->status == 3) selected @endif>{{ __("main.failed") }}</option>
                        </select>
                    </td>

                    <td>
                        <a href="{{ route('earn.withdrows.edit', $withdrow->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('earn.withdrows.destroy', $withdrow->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $withdrows->links() }}</div>
</div>
