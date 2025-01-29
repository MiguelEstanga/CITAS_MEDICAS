@extends('layout.app')

@section('content')
    <div class="content p-4 sombra">
        <div class="header">
          
        </div>
        <form id="editUserForm" method="POST" action="{{ route('usuarios.udate', user()->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="modal-body">
                <input type="hidden" id="editUserId" name="id">
                <input type="hidden" id="editUserId" name="role" value="1">
                <x-input_file label="" name="imagen" />
                <input type="hidden" name="id" value="{{ user()->id }}">
                <div class="mb-3 input">
                    <label for="editUserName" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="editUserName" name="name" value="{{ user()->name }}"
                        required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserName" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="editUserName" name="last_name"
                        value="{{ user()->last_name }}" required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserCedula" class="form-label">Cédula</label>
                    <input type="text" class="form-control" id="editUserCedula" name="cedula"
                        value="{{ user()->cedula }}" required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserEdad" class="form-label">Edad</label>
                    <input type="number" class="form-control" id="editUserEdad" name="edad" value="{{ user()->edad }}"
                        required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserTelefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="editUserTelefono" name="telefono"
                        value="{{ user()->telefono }}" required>
                </div>

                <div class="mb-3 input">
                    <label for="editUserEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editUserEmail" name="email" value="{{ user()->email }}"
                        required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>

            </div>
        </form>
    </div>
    <style>
        .content{
            max-width: 1200px;
            background-color: #ffff;
            margin: auto;
            border-radius: 10px;

        }
        .estadostocas {
            display: flex;

            margin-bottom: 100px;
            gap: 10px;
        }


        .header {
            
            position: relative;
            display: flex;
            flex-direction: row;
            gap: 20px;
            height: 250px;
            margin: 10px;
            padding: 10px;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 60px;
            background: var(--color_menu);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            background-image: url({{asset('storage/sistema/logo.png')}});
          
            border-radius: 10px;
        }
        .header .imagen_baner{
            position: absolute;
            left: 0;
            right: 0;
            top: 100px;
            
        }
        .baner {
            border-radius: 10px;
            min-width: 200px;
            height: 200px;
            background-color: #f5f5f5;
        }

        .body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 10px;
            padding: 10px;
        }

        .imagen_baner {
            width: 205px;
            border: solid 3px var(--color_menu);
            border-radius: 50%;
            margin: auto;

            img {
                border-radius: 50%;
            }
        }
    </style>
@endsection
