<div class="container formulario-login">
    <div class=" main_login">
        <img src="https://cms-img.auna.org/unidad_cardiovascular_3841a27a15.png" alt="logo">
    </div>
    <div class=" formulario-body">
        <form wire:submit.prevent="login" class="flex flex-col justify-center items-center"  method="post" action="{{ route('auth') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="mb-4">Email</label>
                <input type="email" class="form-control" id="email" wire:model.live="email" placeholder="Email">
                @if ($emailExists == false)
                    <span class="text-danger" wire:loading.class.remove="d-none" wire:target="email">
                        Usuario no esta registrado
                    </span>
                @else
                    <span class="text-success" wire:loading.class.remove="d-none" wire:target="email">
                        Usuario registrado
                    </span>
                @endif
            </div>
            <div class="form-group mb-3">
                <label class="d-flex flex-row justify-content-between mb-4">
                    <span>
                        Contraseña
                    </span>
                    <span>
                        @if ($verContrasena == false)
                            <span class="cursor" wire:click="ver_contrasena">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                                    <path
                                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                                </svg>
                            </span>
                        @else
                            <span class="cursor" wire:click="ocultar_contrasena">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                </svg>
                            </span>
                        @endif
                    </span>
                </label>
                <input type="{{ $verContrasena ? 'text' : 'password' }}" class="form-control mt-1" id="password"
                    placeholder="contraseña">
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn-default ">Registrarse</button>
            </div>
        </form>
    </div>
</div>
