@props(['name' => 'pdf', 'label' => 'Subir PDF', 'id' => 'uploadPdf', 'edit' => false, 'value' => null])

<div class="">
    <label class="mb-4" for="{{ $id }}">{{ $label }}</label>
    <div class="form-group">
        <input type="file" class="form-control" name="{{ $name }}" id="{{ $id }}"
            accept="application/pdf" onchange="previewPDF(event, '{{ $id }}')">
    </div>

    @if ($edit)
        <div class="content-file mt-4">
            @if ($value)
                <div class="mb-4">
                    <label class="mb-2"><strong>Antes:</strong></label>
                    <iframe src="{{ Storage::url($value) }}" width="50%" height="500px"></iframe>
                </div>
            @endif

            <div id="{{ $id }}-preview" class="mt-2" style="display: none;">
                <label class="mb-2"><strong>Ahora:</strong></label>
                <iframe id="{{ $id }}-frame"></iframe>
                <a type="button" class="" onclick="clearPDF('{{ $id }}')">{!! iconos('delete') !!}</a>
            </div>
        </div>
    @else
        <div id="{{ $id }}-preview" class="mt-2" style="display: none;">
            <iframe id="{{ $id }}-frame"></iframe>
            <a type="button" class="btn btn-danger mt-2"
                onclick="clearPDF('{{ $id }}')">{!! iconos('delete') !!}</a>
        </div>
    @endif
</div>

<script>
    function previewPDF(event, id) {
        const file = event.target.files[0];
        const preview = document.getElementById(id + '-preview');
        const frame = document.getElementById(id + '-frame');

        if (file && file.type === "application/pdf") {
            const fileURL = URL.createObjectURL(file);
            frame.src = fileURL;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    function clearPDF(id) {
        const input = document.getElementById(id);
        const preview = document.getElementById(id + '-preview');
        const frame = document.getElementById(id + '-frame');

        // Reset input value
        input.value = null;

        // Hide preview and clear iframe source
        frame.src = '';
        preview.style.display = 'none';
    }
</script>

<style>
    .content-file {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: flex-start;
        gap: 30px;
    }

    .content-file div iframe {
        width: 500px;
        height: 500px;
    }
</style>
