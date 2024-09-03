<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="text-end p-1"><input type="checkbox" id="selectAllInputs"></th>
                <th>{{ __('mall.id') }}</th>
                <th>{{ __('mall.name') }}</th>
                <th>{{ __('mall.section') }}</th>
                <th>{{ __('mall.store') }}</th>
                <th>{{ __('mall.category') }}</th>
                <th>{{ __('mall.brand') }}</th>
                <th>{{ __('mall.price') }}</th>
                <th>{{ __('mall.inventory') }}</th>

                <th>{{ __('mall.status') }}</th>
                <th>{{ __('mall.actions') }}</th>
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
                    <td>{{ $product->store->section->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->calc_price }}</td>
                    <td>{{ $product->qty }}</td>
                    <td>
                        @if ($product->is_active)
                            <span class="badge badge-primary">{{ __('mall.active') }}</span>
                        @else
                            <span class="badge badge-secondary">{{ __('mall.not_active') }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mall.products.edit', $product->id) }}"
                            class="btn btn-secondary">{{ __('mall.edit') }}</a>

                        <a href="#" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-effect="effect-flip-vertical"
                            data-url="{{ route('mall.products.destroy', $product->id) }}"
                            data-target="#deletemodal">{{ __('mall.delete') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-3">{{ $products->links() }}</div>
</div>
