
<div wire:ignore.self id="{{$modalId}}" class="modal-wrapper" wire:key="{{$modalId}}">
    <!-- Modal Backdrop -->
    <div class="modal-backdrop" id="modalBackdrop"
        onclick="Livewire.dispatch('close-modal-event', [{'modalId': '{{$modalId}}' }])"></div>

    <!-- Modal Content -->
    <div class="modal-content p-4  {{ $modalClass?? 'mainModal'}}" id="modalContent">
        <h5 class="card-title text-info text-gradient font-weight-bolder pt-4 ps-4">
            @if ($modalId !== "detail")
            {{ $isEditMode ? 'Edit '.ucfirst($modelName).' Record' : 'New '.ucfirst($modelName).' Record' }}
            @else
                {{ ucfirst($modelName) }} Record Detail
            @endif
        </h5>
        <div class="mb-4"><hr class="horizontal dark my-0" /></div>
        <div class="modal-body">





