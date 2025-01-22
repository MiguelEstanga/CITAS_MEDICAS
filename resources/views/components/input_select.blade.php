@props([
    'label' => '',
    'name' => '',
    'options' => [], // Debe ser un array asociativo: ['value' => 'name']
    'required' => false,
    'selected' => null,
])

<div class="input">
    <label for="{{$name}}" class="form-label">
        {{$label}} <span style="color: red">{{$required ? '*' : ''}}</span>
    </label>
    <select name="{{$name}}" id="{{$name}}" class="form-select">
       
        @foreach ($options as $value => $display)
            <option  {{ $selected == $value ? "selected" : "" }} value="{{ $value }}">{{ $display }}</option>
        @endforeach
    </select>
</div>

<style>
    .input-select {
        margin-bottom: 20px;
    }
</style>
