<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('main.id') }}</th>
                <th>{{ __('main.product') }}</th>
                <th>{{ __('main.status') }}</th>
                <th>{{ __('main.qty') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <label class="custom-toggle-switch">
                            <input type="checkbox" class="custom-toggle-input" data-id="{{ $product->id }}"
                                data-url="{{ route('mall.products.toggleStatus', $product->id) }}"
                                {{ $product->is_active ? 'checked' : '' }}>
                            <span class="custom-toggle-slider"></span>
                        </label>
                    </td>
                    <td>{{ $product->qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
