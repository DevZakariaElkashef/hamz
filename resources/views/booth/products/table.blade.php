<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.name') }}</th>
                <th>{{ __('main.section') }}</th>
                <th>{{ __('main.store') }}</th>
                <th>{{ __('main.category') }}</th>
                {{-- <th>{{ __('main.brand') }}</th> --}}
                <th>{{ __('main.price') }}</th>
                <th>{{ __('main.inventory') }}</th>

                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <th class="text-end p-1"><input type="checkbox" class="checkbox-input" value="{{ $product->id }}">
                    </th>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ asset($product->image) }}" class="text-dark" download>
                            <img src="{{ asset($product->image) }}" style="display: inline-block; border-radius: 50%;"
                                width="40" height="40" alt="">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td>{{ $product->store->section->name ?? '' }}</td>
                    <td>{{ $product->store->name ?? '' }}</td>
                    <td>{{ $product->category->name ?? '' }}</td>
                    {{-- <td>{{ $product->brand->name ?? '' }}</td> --}}
                    <td>{{ $product->calc_price ?? '' }}</td>
                    <td>{{ $product->qty }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $product->id }}"
                                data-url="{{ route('booth.products.toggleStatus', $product->id) }}"
                                {{ $product->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('booth.products.edit', $product->id) }}"
                            class="btn btn-secondary">{{ __('main.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('booth.products.destroy', $product->id) }}"
                            data-target="#deletemodal">{{ __('main.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $products->links() }}</div>
</div>
