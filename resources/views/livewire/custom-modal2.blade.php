<div>
    @if($isOpen)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Modal</h2>
                </div>
                <div class="p-4">
                   
                </div>
                <div class="px-4 py-3 border-t border-gray-200 text-right">
                    <button wire:click="toggleModal" class="btn btn-secondary">Cerrar</button>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    background-color: white;
    padding: 20px;
   
    z-index: 1000;
}

.modal-content {
    text-align: center;
}
</style>
