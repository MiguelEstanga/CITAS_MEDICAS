@extends('layout.auth')

@section('content')
    <style>
        /* Fuentes y Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }

        /* Contenedor principal */
        .loginContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 1rem;
            background:var(--color_menu);
        }

        .container.formulario-login {
            background-image:var(--color_fondo2);
            max-width: 420px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            box-shadow: #333 0px 0px 1px;
        }

        /* Sección del logo o imagen */
        .main_login {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--color-segundario);
            padding: 1.5rem 1rem;
        }

        .main_login img {
            width: 100%;
   
            height: auto;
        }

        /* Formulario */
        .formulario-body {
          
            padding: 2rem;
        }

        .formulario-body form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
            color: var(--color_texto);
        }

        input.form-control {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input.form-control:focus {
            border-color: #77BFF8;
        }

       

        /* Botón */
        .btn-default {
            display: inline-block;
          
          
            font-weight: bold;
            border: none;
            border-radius: 4px;
            padding: 0.6rem 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            text-align: center;
            background: var(--color_texto)!important;
            color: #fff;
        }

        .btn-default:hover {
            background-color: #5AA3E0;
        }

        /* Responsivo */
        @media (max-width: 576px) {
            .container.formulario-login {
                max-width: 100%;
                margin: 0 1rem;
            }
        }
    </style>

    <div class="loginContainer">
        <div class="container formulario-login">
            <div class="main_login">
                <img src="{{asset('storage/sistema/logo.png')}}" alt="{{asset('sistema/logo.png')}}" width="100px" height="100px">
            </div>
            <div class="formulario-body">
                <form wire:submit.prevent="login" class="flex flex-col justify-center items-center" method="post"
                    action="{{ route('auth') }}">
                    @csrf
                    <div class=" ">
                        <label for="email" class="mb-4">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="mb-4">
                            Contraseña
                        </label>
                        <input type="password" name="password" class="form-control mt-1" id="password"
                               placeholder="Contraseña">
                    </div>
                    <div class="f">
                        <button type="submit" class="btn-default">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
