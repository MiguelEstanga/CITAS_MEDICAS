@extends('layout.app')

@section('content')
    <div class="container2">

        <div>
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-input name="name" :required="true" label="Nombre" type="text" placeholder="Nombre"
                    value="{{ $user->name }}" />
                <x-input name="last_name" :required="true" label="Apellido" type="text" placeholder="Apellido"
                    value="{{ $user->last_name }}" />
                <x-input name="email" :required="true" label="Gmail" type="email" placeholder="Gmail"
                    value="{{ $user->email }}" />

                <x-input_select name="role" :required="true" label="Rol" :options="$roles"
                    selected="{{ $user->roles->first()->id }}" />
                <div class="mt-2 mb-2 ">

                    <div class="circle_avatar">
                        <img src="{{ asset('storage/' . $user->avatar) ?? user_default() }}"
                            alt="{{ asset('storage/' . $user->avatar) }}" class="circle_avatar">
                    </div>
                </div>
                <x-input_file label="Subir imagen" name="imagen" :value="asset('storage/' . $user->avatar)" />
                <div class="container">
                    <button class=" btn-default " type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
