@props([
    'label' => '',
    'name' => '',
    'required' => false,
    'value' => null,  // Aquí llegará la ruta de la imagen actual
])

<div class="input">
    <label for="{{ $name }}" class="form-label">
        {{ $label }} <span style="color: red">{{ $required ? '*' : '' }}</span>
    </label>

    {{-- Input de archivo --}}
    <input 
        type="file" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        accept="image/*"
        class="form-control file-input"
        data-preview="#{{ $name }}-preview"  {{-- apunte a un selector de id --}}
    >

    {{-- Contenedor de la imagen de preview --}}
    <div class="image-preview mt-3">
        <img 
            id="{{ $name }}-preview" 
            src="{{ $value ?? '' }}" 
            alt="Vista previa"
            style="max-width: 200px; max-height: 200px; {{ $value ? 'display:block;' : 'display:none;' }}"
        >
    </div>
</div>

<style>
    .image-preview img {
        padding: 5px;
        border-radius: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('.file-input');

        fileInputs.forEach(fileInput => {
            fileInput.addEventListener('change', function(event) {
                // Obtén el selector del preview desde data-preview
                const previewSelector = this.getAttribute('data-preview');
                const previewImage = document.querySelector(previewSelector);
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Si no hay archivo seleccionado, ocultamos y vaciamos
                    previewImage.style.display = 'none';
                    previewImage.src = '';
                }
            });
        });
    });
</script>
