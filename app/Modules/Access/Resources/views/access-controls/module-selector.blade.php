

    <div class="row">

        <!-- Role Selection Dropdown -->
        <div class="input-group col-12 w-100 col-sm-auto w-sm-auto">
            <select id="roleSelect" wire:model="selectedRole" class="form-select rounded-pill p-1 ps-3 pe-sm-5 px-sm-4 m-0"  style = "height: 2.6em;">
                <option value="">Select role...</option>
                @foreach($roles as $roleName => $roleSlug)
                    <option value="{{ $roleSlug }}">{{ $roleName }}</option>
                @endforeach
            </select>
        </div>

        <!-- Module Selection Dropdown (Conditional) -->
        @if (!$selectedModule)
            <div x-data class="input-group col-12 w-100 col-sm-auto w-sm-auto" x-show="$wire.selectedRole" x-cloak>
                <select id="moduleSelect" wire:model="selectedModule" class="form-select rounded-pill p-1 ps-3 pe-sm-5 px-sm-4 m-0"  style = "height: 2.6em;">
                    <option value="">Select module...</option>
                    @foreach($modules as $moduleName)
                        <option value="{{ strtolower($moduleName) }}">{{ $moduleName }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Navigation Button -->
        <div x-data class="col-12 w-100 col-sm-auto w-sm-auto" >
            <button
                 style = "height: 3em;"
                wire:click="navigate"
                class="btn btn-primary rounded-pill py-0"
                :disabled="!$wire.selectedRole || !$wire.selectedModule">
                OK
            </button>
        </div>

    </div>


