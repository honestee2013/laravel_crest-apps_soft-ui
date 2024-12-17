<section class="m-0 m-md-4">


    {{-- ----------------- MAIN MODAL FOR ADD-EDIT ----------------- --}}
    @include('core.views::data-tables.modals.modal-header', [
        'modalId' => 'addEditModal',
        'isEditMode' => $isEditMode,
    ])
        <div class="card-body">
            {{-- REACTIVE FORM COMPONENT --}}
            <livewire:core.livewire.data-tables.data-table-form
                :pageTitle="$pageTitle"
                :queryFilters="$queryFilters"

                :fieldDefinitions="$fieldDefinitions"
                :model="$model"
                :moduleName="$moduleName"
                :modelName="$modelName"
                :multiSelectFormFields="$multiSelectFormFields"
                :hiddenFields="$hiddenFields"
                :columns="$columns"
                :isEditMode="$isEditMode"
                modalId="addEditModal"
                key="addEditModal" />
        </div>
    @include('core.views::data-tables.modals.modal-footer', [
        'modalId' => 'addEditModal',
        'isEditMode' => $isEditMode,
    ])


    {{-- ------------ CONTENT BEGINS ------------ --}}
    <div class="card  p-4">

        {{-- ------------DATA TABLE MANAGER HEADER TEXT ------------ --}}
        <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    @php
                        if (!$pageTitle) // Check if 'pageTitle' is available in the DataTableManager
                            $pageTitle = $this->getConfigFileField($moduleName, $modelName, 'pageTitle');
                        if (!$pageTitle) { // Check if 'pageTitle' is available in the config file
                            // Generate the 'pageTitle'from the moduleName
                            $pageTitle = Str::snake($modelName); // Convert to snake case
                            $pageTitle = ucwords(str_replace('_', ' ', $pageTitle)); // Convert to capitalised words
                            $pageTitle = Str::plural(ucfirst($pageTitle))." Record";
                        }
                    @endphp

                    <h5 class="mb-4">{{ $pageTitle }} </h5>

                </div>
                @if (is_array($controls) && in_array('addButton', $controls))
                    <button wire:click="$dispatch('openAddModalEvent')"
                        class="btn bg-gradient-primary btn-icon-only rounded-circle" type="button">
                        <i class="fa-solid fa-plus   text-white"></i>
                    </button>
                @endif
            </div>
        </div>



        {{-- @include('core.views::data-tables.partials.feedback-messages')
        {{-- <livewire:core.livewire.feedback.feedback-message />
        <livewire:core.livewire.feedback.alert-message /> --}}




        {{-- ------------ DATA TABLE CONTROLS ------------ --}}
        <div class="container ms-0 mt-4 mb-0">
            <livewire:core.livewire.data-tables.data-table-control :controls="$controls" :columns="$columns" :hiddenFields="$hiddenFields"
                :visibleColumns="$visibleColumns" :model="$model" :fieldDefinitions="$fieldDefinitions" :multiSelectFormFields="$multiSelectFormFields" :sortField="$sortField"
                :sortDirection="$sortDirection" :perPage="$perPage" :moduleName="$moduleName" :modelName="$modelName" />
        </div>


        {{-- ------------ DATA TABLE  ------------ --}}
        <livewire:core.livewire.data-tables.data-table :fieldDefinitions="$fieldDefinitions" :hiddenFields="$hiddenFields" :multiSelectFormFields="$multiSelectFormFields"
            :queryFilters="$queryFilters"
            :columns="$columns" :model="$model" :simpleActions="$simpleActions" :controls="$controls" :visibleColumns="$visibleColumns"
            :sortField="$sortField" :sortDirection="$sortDirection" :perPage="$perPage" :moduleName="$moduleName" :modelName="$modelName"
            :moreActions="$moreActions" />


        {{-- NONE REACTIVE BLADE FILE FOR SHOWING ITEM DETAIL --}}
        @include('core.views::data-tables.modals.show-detail-modal', ['selectedItem' => $selectedItem])


    </div>


</section>

@include('core.assets::data-tables.assets')
@include('core.assets::data-tables.scripts')
