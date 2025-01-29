@props([
    'label' => '',
    'name' => '',
    'options' => [], // Debe ser un array asociativo: ['value' => 'name']
    'required' => false,
    'selected' => null,
    'id' => '1',
    
])

<div class="input">
    <label for="{{$name}}" class="form-label">
        {{$label}} <span style="color: red">{{$required ? '*' : ''}}</span>
    </label>
    <select name="{{$name}}" id="{{$name}}" class="form-select" id="{{$id}}" >
       
        @foreach ($options as $value )
            <option  {{ $selected == $value ? "selected" : "" }} value="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select>
</div>

<style>
    .input-select {
        margin-bottom: 20px;
    }
</style>
