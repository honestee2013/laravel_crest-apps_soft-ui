<div class="row md-d-flex md-justify-content-between p-1 m-2 rounded-3 py-2 bg-gray-100">

    @if ($selectedScope)
        @foreach ($resourceNames as $resourceName)
            <div class="col-md-6 my-2" >
                <div class="card"   wire:ignore>
                    <div class="card-header pb-0 px-3"  >
                        <div class="row d-flex justify-content-between ps-3 pe-5 px-md-4" id = "{{ $resourceName }}">
                            <a class="col-10" data-bs-toggle="collapse" href="#{{ $resourceName }}" role="button"
                                aria-expanded="false" aria-controls="{{ $resourceName }}">
                                <h6 class="mb-1">{{ ucfirst($resourceName) }} Management</h6>
                                <span class="mb-2 text-xs">
                                    What <span
                                        class="text-dark font-weight-bold">{{ ucfirst($selectedScope?->name) }}</span>
                                    can do
                                    on <span class="text-dark font-weight-bold">{{ ucfirst($resourceName) }}
                                        records?</span>
                                </span>

                                <div id="what_scope_can_do_on_{{ $resourceName }}" class="pt-0">

                                    @foreach ($selectedScope?->permissions as $permission)
                                        @if (is_array($allControls))
                                            @foreach ($allControls as $control)
                                                @if (str_contains($permission->name, strtolower($control . ' ' . $resourceName)))
                                                    <span
                                                        class="badge rounded-pill bg-gradient-{{ $controlsCSSClasses[$control]['bg'] ?? 'primary' }}"
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


                                    <input class="form-check-input" id = "toggle-all-{{ $resourceName }}"
                                        type="checkbox"
                                        onchange="updatePermission(event.target, '{{ $selectedScope->name }}', '{{ $selectedScope->id }}', 'all', '{{ $resourceName }}', '{{ $selectedScopeGroup }}')"
                                        @if (isset($toggleAllPermissionSwitchInitColors[$resourceName]) &&
                                                $toggleAllPermissionSwitchInitColors[$resourceName]['permissionCount']
                                        )
                                            checked
                                        @endif
                                        @if (isset($toggleAllPermissionSwitchInitColors[$resourceName]))
                                            style="background-color: {{ $toggleAllPermissionSwitchInitColors[$resourceName]['bg'] }};
                                                    border: {{ $toggleAllPermissionSwitchInitColors[$resourceName]['bg'] }}
                                                    "
                                        @endif

                                        />

                                </div>
                            </div>


                        </div>
                    </div>

                    <hr class="horizontal dark mt-4 mb-0  pb-0" />

                    <div class="card-body pt-4 p-2 p-md-4 pt-md-4 mb-2">
                        <ul class="list-group collapse p-1" id="{{ $resourceName }}">
                            @foreach ($allControls as $control)
                                <li
                                    class="list-group-item  border-0  ps-3 pe-5 py-3 my-1 bg-gray-100 border-radius-lg ">
                                    <div class="row d-flex justify-content-between px-3">
                                        <div class="col-10">
                                            <p class="mb-3 text-sm">
                                                <span
                                                    class="text-dark font-weight-bold">{{ ucfirst($selectedScope->name) }}</span>
                                                should be able to <span
                                                    class="font-weight-bold">{{ $control }}</span>
                                                {{ strtolower($resourceName) }} records
                                            </p>
                                        </div>
                                        <div class="col-1 ">
                                            <div class="form-check form-switch">
                                                @php
                                                    $thePermisionName =
                                                        $control . ' ' . strtolower(Str::plural($resourceName));
                                                    $thePermisionList = $selectedScope->permissions
                                                        ->pluck('name')
                                                        ->toArray();
                                                    $checked = in_array($thePermisionName, $thePermisionList);
                                                @endphp
                                                <input class="form-check-input" type="checkbox"
                                                    id = "toggle-{{ $control }}-{{ $resourceName }}"
                                                    onchange="updatePermission(event.target, '{{ $selectedScope->name }}', '{{ $selectedScope->id }}', '{{ $control }}', '{{ $resourceName }}', '{{ $selectedScopeGroup }}')"
                                                    {{ $checked ? 'checked' : '' }}
                                                    style="background-color: {{ $checked ? $onColor : $offColor }}; border: {{ $checked ? $onColor : $offColor }};">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endforeach
    @endif


</div>









@script
<script>
    /*const offColor = '#e8ebee'
        const onColor = '#98ec2d';
        const halfOnColor = 'green';*/

    document.addEventListener('DOMContentLoaded', function() {
        /*const accessControllerDataElement = document.getElementById("accessControllerData");
        if (accessControllerDataElement) {
            const accessControllerData = accessControllerDataElement.dataset.accesscontroller;
            try {
                const accessController = JSON.parse(accessControllerData);
                console.log(accessController);
            } catch (e) {
                console.error("Failed to parse JSON data:", e);
            }
        } else {
            console.error("Element with ID 'accessControllerData' not found.");
        }*/


        // Use querySelectorAll to get all elements with the class "form-check-input"
        const allCheckedBoxes = document.querySelectorAll(".form-check-input");

        for (let i = 0; i < allCheckedBoxes.length; i++) {
            let checkBox = allCheckedBoxes[i]; // Declare the variable with let

            if (checkBox.id.indexOf("-all-") == -1) {
                if (checkBox.checked) {
                    checkBox.style.backgroundColor = onColor;
                    checkBox.style.border = onColor;
                } else {
                    checkBox.style.backgroundColor = offColor;
                    checkBox.style.border = offColor;
                }
            }
        }



    });







    function updatePermission(event, selectedScope, scopeId, control, resourceName, scope) {

        data = [{
            "scope_id": scopeId,
            "selectedScope": selectedScope,
            "control": control,
            "resource_name": resourceName,
            "checked": event.checked,
            "html_input_id": event.id,
            "scope": scope
        }];

        Livewire.dispatch('updatePermissionEvent', data);


    }


    /*document.addEventListener('livewire:initialized', () => {
        Livewire.on('permission-updated-event', function(event) {
            const data = event[0];


            const resourceName = data['resource_name'];

            // Change background color based on the checkbox state
            toggleCheckBoxColor(data);

            // Update the list of what role can do
            const element = document.getElementById("what_scope_can_do_on_" + resourceName);
            element.innerHTML = "";
            for (var i = 0; i < data['controls'].length; i++) {
                //console.log(data['controls'][i]);
                control = data['controls'][i]; // eg view, edit

                // Create a new span element
                var span = document.createElement('span');
                var controlCSSClass = 'primary';
                if ((data['controlsCSSClasses'][control]).bg)
                    controlCSSClass = (data['controlsCSSClasses'][control]).bg;

                span.className = 'badge rounded-pill bg-gradient-' + controlCSSClass;
                span.style.fontSize = '0.6em';
                span.style.margin = '0.5em 0.3em';
                span.textContent = control;

                // Append the new span element to the parent element
                element.appendChild(span);
            }

            $wire.$refresh();











        });





        function toggleCheckBoxColor(data) {


            // Toggle one of the switch color
            //const switched = event.target;
            const switched = document.getElementById(data["html_input_id"]);
            //alert($switched.checked);

            // Handling the  INDIVIDUAL switch event
            if (switched.checked) {
                switched.style.backgroundColor = onColor;
                switched.style.border = onColor;
            } else {
                switched.style.backgroundColor = offColor;
                switched.style.border = offColor;
            }


            // Handling the  TOGGLE ALL switch event
            toggleAllElementId = "toggle-all-" + data["resource_name"];
            const toggleAllCheckBox = document.getElementById(toggleAllElementId);
            toggleAllCheckBox.style.backgroundColor = "#ffffff"; // No control color
            toggleAllCheckBox.innerHTML = <h1>stupidddd</h1>"; // No control color
            //alert(toggleAllCheckBox.id)

            if (event.target.id === toggleAllElementId) { // Toggle all switch color when directly clicked
                for (var i = 0; i < data["allControls"].length; i++) {
                    var switchId = "toggle-" + data["allControls"][i] + "-" + data["resource_name"];
                    var switchElem = document.getElementById(switchId);
                    if (data["controls"].length) {
                        switchElem.checked = true;
                        switchElem.style.backgroundColor = onColor;
                        switchElem.style.border = onColor;
                    } else {
                        switchElem.checked = false;
                        switchElem.style.backgroundColor = offColor;
                        switchElem.style.border = offColor;
                    }
                }

            } else { // Control Toggle all switch color when individual switches clicked

                // GREEN YELLOW & GRAY Indicating toggle all button state

                if (data["controls"].length == 0) { // OFF
                    toggleAllCheckBox.style.backgroundColor = offColor; // No control color
                    toggleAllCheckBox.style.border = offColor; // No control color
                    toggleAllCheckBox.checked = false; // Uncheck the checkbox

                } else if (data["controls"].length == data["allControls"].length) { // ON

                    toggleAllCheckBox.style.backgroundColor = 'red'; // Full control color
                    toggleAllCheckBox.style.border = 'red'; // Full control color
                    toggleAllCheckBox.checked = true; // Check the checkbox

                } else { // PARTIALLY ON
                    toggleAllCheckBox.style.backgroundColor = halfOnColor; // Half control color
                    toggleAllCheckBox.style.border = halfOnColor; // Half control color
                    toggleAllCheckBox.checked = true; // Check the checkbox
                }

            }

        }












    });*/



    /*function xxxxxupdatePermission(event, selectedScope, scopeId, control, resourceName) {
        //alert(checkbox.checked+": "+selectedScope+" "+scopeId+" "+control+" "+resourceName);
        const isChecked = event.target.checked;
        const url = '{{-- route('access-control.update') --}}'; // Define your route name for updating permissions

        fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    scope_id: scopeId,
                    selectedScope: selectedScope,
                    control: control,
                    resource_name: resourceName,
                    checked: isChecked
                })
            })
            .then(response => response.json())
            .then(data => {
                // Handle success or update UI if needed
                if (data['success']) {

                    // Change background color based on the checkbox state
                    toggleCheckBoxColor(event, data);

                    // Update the list of what role can do
                    const element = document.getElementById("what_scope_can_do_on_" + resourceName);
                    element.innerHTML = "";
                    for (var i = 0; i < data['controls'].length; i++) {
                        //console.log(data['controls'][i]);
                        control = data['controls'][i]; // eg view, edit

                        // Create a new span element
                        var span = document.createElement('span');
                        var controlCSSClass = 'primary';
                        if ((data['controlsCSSClasses'][control]).bg)
                            controlCSSClass = (data['controlsCSSClasses'][control]).bg;

                        span.className = 'badge rounded-pill bg-gradient-' + controlCSSClass;
                        span.style.fontSize = '0.6em';
                        span.style.margin = '0.5em 0.3em';
                        span.textContent = control;

                        // Append the new span element to the parent element
                        element.appendChild(span);
                    }

                }

            })
            .catch((error) => {
                // Handle error
                console.error('Error:', error);
            });
    }*/
</script>

@endscript




</div>
