<div>
    <button class="btn btn-default btn-sm mr-2"  wire:click="toggleModal">
        Crear Usuario
    </button>
    @if($isOpen)
        <div class="modal_custom">
            <div class="modal_content">
                
            </div>
                <div class="px-4 py-3 border-t border-gray-200 text-right">
                    <button wire:click="toggleModal" class="btn btn-secondary">Cerrar</button>
                </div>
            
        </div>
    @endif
 
</div>

