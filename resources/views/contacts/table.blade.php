<div class="table-responsive">
    <table class="table mg-b-0 text-md-nowrap">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.phone') }}</th>
                <th>{{ __('main.email') }}</th>
                <th>{{ __('main.Contact_Types') }}</th>
                <th>{{ __('main.message') }}</th>
                <th>{{ __('main.is_readed') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $contact->id }}"></th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->contactType->name ?? '' }}</td>
                    <td>{{ Str::limit($contact->message, 20) }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $contact->id }}"
                                data-url="{{ route('contact.toggleStatus', $contact->id) }}"
                                {{ $contact->read_at ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>



                    <td>
                        <a href="#" data-target="#showmodal" data-message="{{ $contact->message }}" data-toggle="modal"
                            data-effect="effect-flip-vertical"class="btn btn-primary show-btn">{{ __('main.show') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical" data-url="{{ route('contacts.destroy', $contact->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $contacts->links() }}</div>
</div>
