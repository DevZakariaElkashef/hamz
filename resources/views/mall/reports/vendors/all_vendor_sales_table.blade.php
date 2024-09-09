<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('mall.Vendor_Name') }}</th>
                <th>{{ __('mall.Quantity_Sold') }}</th>
                <th>{{ __('mall.Total_Sales') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sale->store_name }}</td>
                    <td>{{ $sale->total_quantity }}</td>
                    <td>{{ $sale->total_sales }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="my-3">
        {{ $sales->links() }}
    </div>

</div>
