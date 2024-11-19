@include('core::data-tables.modals.modal-header', [
    'modalId' => $modalId,
    'isEditMode' => $isEditMode,
    'isModal' => $isModal,
])

@include('core::data-tables.data-table-form')

@include('core::data-tables.modals.modal-footer', [
    'modalId' => $modalId,
    'isEditMode' => $isEditMode,
    'isModal' => $isModal,

])
