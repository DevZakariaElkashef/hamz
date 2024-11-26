<option selected disabled>{{ __("main.select") }}</option>
@foreach ($items as $item)
    <option value="{{ $item->id }}">
        {{ isset($item->name) ? $item->name : $item->value }}
    </option>
@endforeach
