
<div>



{{--<livewire:access.livewire.access-controls.resource-access
    :allControls="$allControls"
    :controlsCSSClasses="$controlsCSSClasses"
/>--}}




    <div>



        <div class="container-fluid py-4">
            <div class="card mb-4 mx-4 p-4">



                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            @php
                                $pageTitle = "Access Control";

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

                    </div>
                </div>


                <div class="container ms-0 mt-4 mb-2">


                    <div class="row g-3">


                        <div class="col-12 col-sm-auto ">
                            <select wire:model.live.500ms='selectedModule' onchange="Livewire.dispatch('selectedModuleChangedEvent')"  class="form-select form-control ps-sm-2 pe-sm-5 rounded-pill module-control-input">
                                <option value="" >Select module...</option>
                                @foreach ($moduleOptions as $moduleOption)
                                    <option value="{{ $moduleOption }}">{{ ucfirst($moduleOption) }}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-12 col-sm-auto">
                            <select wire:model.live.500ms='selectedScopeGroup'  class="form-select form-control ps-sm-2 pe-sm-5 rounded-pill module-control-input">
                                <option value="">Scope Group...</option>
                                @foreach ($scopeGroupOptions as $scopeGroupOption)
                                    <option value="{{ $scopeGroupOption }}">{{ ucfirst($scopeGroupOption) }}</option>
                                @endforeach
                            </select>
                        </div>
zzzz {{$selectedScopeGroup}} zzzz

                        <div class="col-12 col-sm-auto">
                            <select wire:model.live.500ms='selectedScopeId'   x-on:change="$dispatch('updateSelectedScopeIdEvent', [$wire.selectedModule, $wire.selectedScopeGroup, $event.target.value])" class="form-select form-control ps-sm-2 pe-sm-5 rounded-pill module-control-input">
                                <option value="">Select xxxxx {{$selectedScopeGroup}}...</option>
                                @foreach ($scopeOptions as  $scopeOption)
                                    <option value="{{ $scopeOption->id }}">{{ ucfirst($scopeOption->name) }}</option>
                                @endforeach
                            </select>
                        </div>
xxx {{$selectedScopeId}} xxx
                      </div>



                </div>




                    <div class="card-body pt-4 p-3" >

                        <form action="/user-profile" method="POST" role="form text-left">
                            @csrf
                            @if ($errors->any())
                                <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                                    <span class="alert-text text-white">
                                        {{ $errors->first() }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success"
                                    role="alert">
                                    <span class="alert-text text-white">
                                        {{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif





                            <div class="row md-d-flex md-justify-content-between p-1 m-2 rounded-3 py-2 bg-gray-100" x-effect="$wire.selectedScope">

                                @if ($selectedScope)

                                    @foreach ($resourceNames as $key => $resourceName)
                                        <div class="col-md-6 my-2" >
                                            <livewire:access.livewire.access-controls.resource-access
                                                :key="$key"
                                                :resourceName="$resourceName"
                                                :scope="$selectedScope"
                                            />
                                        </div>
                                    @endforeach

                                @endif

                            </div>

                        </form>

                    </div>



            </div>
        </div>

        <span id="accessControllerData" data-accesscontroller="{{ json_encode($accessController) }}"></span>


    </div>


    <script>
        const offColor = '#e8ebee'
        const onColor = '#98ec2d';
        const halfOnColor = 'green';

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



        function toggleCheckBoxColor(data) {
           // alert(JSON.stringify(data));

            // Toggle one of the switch color
            //const switched = event.target;
            const switched = document.getElementById(data["html_input_id"]);


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

            } else { // Toggle all switch color when individual switches clicked

                // GREEN YELLOW & GRAY Indicating toggle all button state

                if (data["controls"].length === 0) { // OFF
                    toggleAllCheckBox.style.backgroundColor = offColor; // No control color
                    toggleAllCheckBox.style.border = offColor; // No control color
                    toggleAllCheckBox.checked = false; // Uncheck the checkbox

                } else if (data["controls"].length === data["allControls"].length) { // ON
                    toggleAllCheckBox.style.backgroundColor = onColor; // Full control color
                    toggleAllCheckBox.style.border = onColor; // Full control color
                    toggleAllCheckBox.checked = true; // Check the checkbox

                } else { // PARTIALLY ON
                    toggleAllCheckBox.style.backgroundColor = halfOnColor; // Half control color
                    toggleAllCheckBox.style.border = halfOnColor; // Half control color
                    toggleAllCheckBox.checked = true; // Check the checkbox
                }

            }

        }



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


        document.addEventListener('livewire:initialized', () => {
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







            });
        });



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






