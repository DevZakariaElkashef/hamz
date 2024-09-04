<option selected disabled>{{ __("mall.select") }}</option>
@foreach ($items as $item)
    <option value="{{ $item->id }}">
        {{ isset($item->name) ? $item->name : $item->value }}
    </option>
@endforeach
