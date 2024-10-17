<section>
    {{-------------- CONTENT BEGINS --------------}}
    <div class="card mb-4 mx-4 p-4">

        {{-------------- CARD HEADER --------------}}
        <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-4">{{ Str::plural(ucfirst($modelName)) }} Record</h5>
                </div>
                @if(is_array($controls) && in_array('addButton',$controls))

                    <button wire:click="$dispatch('openAddModalEvent')" class="btn bg-gradient-primary btn-icon-only rounded-circle"
                        type="button">
                        <i class="fa-solid fa-plus   text-white"></i>
                    </button>
                @endif
            </div>
        </div>



        {{--@include('core::data-tables.partials.feedback-messages')
        {{--<livewire:core.livewire.feedback.feedback-message />
        <livewire:core.livewire.feedback.alert-message /> --}}




        {{-------------- DATA TABLE CONTROLS --------------}}
        <div class="container ms-0 mt-4 mb-0">
            <livewire:core.livewire.data-tables.data-table-control
                :controls="$controls"
                :columns="$columns"
                :hiddenFields="$hiddenFields"
                :visibleColumns="$visibleColumns"
                :model="$model"
                :fieldDefinitions="$fieldDefinitions"
                :multiSelectFormFields="$multiSelectFormFields"
                :sortField="$sortField"
                :sortDirection="$sortDirection"
                :perPage="$perPage"
                :moduleName="$moduleName"
                :modelName="$modelName"
            />
        </div>


        {{-------------- DATA TABLE  --------------}}
        <livewire:core.livewire.data-tables.data-table
                :fieldDefinitions="$fieldDefinitions"
                :hiddenFields="$hiddenFields"
                :multiSelectFormFields="$multiSelectFormFields"
                :columns="$columns"
                :model="$model"
                :simpleActions="$simpleActions"
                :controls="$controls"
                :visibleColumns="$visibleColumns"
                :sortField="$sortField"
                :sortDirection="$sortDirection"
                :perPage="$perPage"
                :moduleName="$moduleName"
                :modelName="$modelName"
                :moreActions="$moreActions"
        />


        {{-- NONE REACTIVE BLADE FILE FOR SHOWING ITEM DETAIL --}}
        @include('core::data-tables.modals.show-detail-modal', ["selectedItem" => $selectedItem])


        {{------------------- MAIN MODAL FOR ADD-EDIT -------------------}}
        @include('core::data-tables.modals.modal-header', ["modalId" => "addEditModal", "isEditMode" => $isEditMode])
        <div class="card-body">
            {{-- REACTIVE FORM COMPONENT --}}
            <livewire:core.livewire.data-tables.data-table-form
                :fieldDefinitions="$fieldDefinitions"
                :model="$model"
                :multiSelectFormFields="$multiSelectFormFields"
                :hiddenFields="$hiddenFields"
                :columns="$columns"
                :isEditMode="$isEditMode"
                modalId="addEditModal"
                key="addEditModal"
            />
        </div>
        @include('core::data-tables.modals.modal-footer', ["modalId" => "addEditModal", "isEditMode" => $isEditMode])


        {{-------------- CHILD MODAL CALL WITHIN ANOTHER MODAL --------------}}
        <div id="child-modal-container"></div>

    </div>
</section>

@include('modules.assets.core::data-tables.assets')
@include('modules.assets.core::data-tables.scripts')


