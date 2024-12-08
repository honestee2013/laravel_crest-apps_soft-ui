<div class="card" >

    <div class="card-header pb-0 px-3"  >
        <div class="row d-flex justify-content-between ps-3 pe-5 px-md-4" id = "{{ $resourceName }}">
            <a class="col-10" data-bs-toggle="collapse" href="#{{ $resourceName }}" role="button"
                aria-expanded="false" aria-controls="{{ $resourceName }}">
                <h6 class="mb-1">{{ ucfirst($resourceName) }} Management</h6>
                <span class="mb-2 text-xs">
                    What <span
                        class="text-dark font-weight-bold">{{ ucfirst($scope?->name) }}</span>
                    can do
                    on <span class="text-dark font-weight-bold">{{ ucfirst($resourceName) }}
                        records?</span>
                </span>

                <div id="what_scope_can_do_on_{{ $resourceName }}" class="pt-0">

                    @foreach ($scope?->permissions as $permission)
                        @if (is_array($allControls))
                            @foreach ($allControls as $control)
                                @if (str_contains($permission->name, strtolower($control . ' ' . $resourceName)))
                                    <span
                                        class="badge rounded-pill bg-gradient-{{ $controlColors[$control]['bg'] ?? 'primary' }}"
                                        style="font-size: 0.6em; margin: 0.3em 0.1em">{{ ucfirst($control) }}
                                    </span>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                </div>
            </a>


            <div class="col-1 me-2 ">
                <div class="form-check form-switch">
                    <input class="form-check-input"
                        id = "toggle-all-{{ $resourceName }}"
                        type="checkbox"

                        wire:change="togglePermission('all', $event.target.checked)"
                        style="background-color: {{$toggleSwitchColors['toggleAll']}}; border:   {{$toggleSwitchColors['toggleAll']}};"
                        {{ ($toggleSwitchColors['toggleAll'] != $offColor)? "checked": "" }}

                    />

                </div>
            </div>


        </div>
    </div>

    <hr class="horizontal dark mt-4 mb-0  pb-0" />

    <div class="card-body pt-4 p-2 p-md-4 pt-md-4 mb-2">
        <ul class="list-group collapse p-1" id="{{ $resourceName }}" wire:ignore>
            @foreach ($allControls as $control)
                <li
                    class="list-group-item  border-0  ps-3 pe-5 py-3 my-1 bg-gray-100 border-radius-lg ">
                    <div class="row d-flex justify-content-between px-3">
                        <div class="col-10">
                            <p class="mb-3 text-sm">
                                <span
                                    class="text-dark font-weight-bold">{{ ucfirst($scope->name) }}</span>
                                should be able to <span
                                    class="font-weight-bold">{{ $control }}</span>
                                {{ strtolower($resourceName) }} records
                            </p>
                        </div>
                        <div class="col-1 ">
                            <div class="form-check form-switch">

                                <input class="form-check-input switchHalfOn"
                                    id = "toggle-{{ $control }}-{{ $resourceName }}"
                                    type="checkbox"

                                    wire:change="togglePermission('{{$control}}', $event.target.checked)"
                                    style="background-color: {{$toggleSwitchColors[$control]}}; border:   {{$toggleSwitchColors[$control]}};"
                                    {{ ($toggleSwitchColors[$control] != $offColor)? "checked": "" }}


                                />
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>




</div>

@script
<script>
   document.addEventListener('livewire:initialized', function() {
        Livewire.on('permission-updated', function(data) {

            let toggleAllChecked = false;
            const controls = data[0].controls;
            const resourceName = data[0].resourceName;
            const toggleSwitchColors = data[0].toggleSwitchColors;
            const toggleSwitchStates = data[0].toggleSwitchStates;

            const toggleAll = document.getElementById("toggle-all-"+resourceName);
            toggleAll.style.backgroundColor = toggleSwitchColors["oggleAll"];

            controls.forEach(control => {
                let switchId = "toggle-"+control+"-"+resourceName;
                let toogleSwitch = document.getElementById(switchId);
                toogleSwitch.checked = toggleSwitchStates[control];
                toogleSwitch.style.backgroundColor = toggleSwitchColors[control];

                // Is at least one option is switched on?
                if (toggleSwitchStates[control])
                    toggleAllChecked = true;
            });

            // At least one option is switched on
            toggleAll.checked = toggleAllChecked;

        });
    });
</script>

@endscript







