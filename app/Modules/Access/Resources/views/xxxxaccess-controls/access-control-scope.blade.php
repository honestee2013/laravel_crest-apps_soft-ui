

        <div class="container-fluid">
            <div class="card card-body blur shadow-blur mx-4 ">

                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <i class="fa fa-key top-0 text-primary" style="font-size:3em" title="Edit Image"></i>
                            <!--<a href="javascript:;"
                                class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Edit Image"></i>
                            </a>-->
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ ucfirst($scopeName)?: "Who do you want to control?" }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                Access Control
                            </p>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="scope_type" class="form-control-label">Scope type</label>
                            <select class="form-select"  wire:model='scopeType' wire:change="scopeSelection()">
                                <option value=""  disabled>Select scope type...</option>
                                <option value="role">Role</option>
                                <option value="team">Team</option>
                                <option value="user">User</option>
                            </select>

                        </div>
                    </div>
                    <div class="col" x-show="$wire.scopeType">
                        <div class="form-group">
                            <label for="scope" class="form-control-label">{{ ucfirst($scopeType?: '') }}</label>
                            <select class="form-select"  wire:model='scope' wire:change='manage()'>
                                <option value=""  disabled>Select {{$scopeType}}...</option>
                                @if($scopeList)
                                    @foreach ($scopeList as $scope)
                                        <option value="{{ $scope->id }}">{{ $scope->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                    </div>

                </div>



































            </div>

            @if (isset($accessController))

                <div>
                    <div class="container-fluid py-4">
                        <div class="card">
                            <div class="card-header pb-0 px-3">
                                <h6 class="mb-0">{{ __('Profile Information') }}</h6>
                            </div>
                            <div class="card-body pt-4 p-3">
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




                                    <div class="row md-d-flex md-justify-content-between p-1 m-2 rounded-3 py-2 bg-gray-100">
                                        @foreach ($accessController['resourceNames'] as $resourceName)
                                            <div class="col-md-6 my-2">
                                                <div class="card">
                                                    <div class="card-header pb-0 px-3">
                                                        <div class="row d-flex justify-content-between ps-3 pe-5 px-md-4"
                                                            id = "{{ $resourceName }}">
                                                            <a class="col-11" data-bs-toggle="collapse" href="#{{ $resourceName }}"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="{{ $resourceName }}">
                                                                <h6 class="mb-1">{{ ucfirst($resourceName) }} Management</h6>
                                                                <span class="mb-2 text-xs">
                                                                    What <span
                                                                        class="text-dark font-weight-bold">{{ ucfirst($accessController['scope']->name) }}</span>
                                                                    can do
                                                                    on <span
                                                                        class="text-dark font-weight-bold">{{ ucfirst($resourceName) }}
                                                                        records?</span>
                                                                </span>
                                                                <div id="what_scope_can_do_on_{{ $resourceName }}" class="pt-0">
                                                                    <!--<span class="badge rounded-pill bg-gradient-info" style="font-size: 0.6em">View records</span>
                                                                        <span class="badge rounded-pill bg-gradient-success" style="font-size: 0.6em">Print records</span>
                                                                        <span class="badge rounded-pill bg-gradient-warning" style="font-size: 0.6em">Create records</span>
                                                                        <span class="badge rounded-pill bg-gradient-danger" style="font-size: 0.6em">Delete records</span>
                                                                        <span class="badge rounded-pill bg-gradient-primary" style="font-size: 0.6em">Export records</span>-->

                                                                    @foreach ($accessController['scope']->permissions as $permission)
                                                                        @foreach ($accessController['allControls'] as $control)
                                                                            @if (str_contains($permission->name, strtolower($control . ' ' . $resourceName)))
                                                                                <span
                                                                                    class="badge rounded-pill bg-gradient-{{ $accessController['controlsCSSClasses'][$control]['bg'] ?? 'primary' }}"
                                                                                    style="font-size: 0.6em; margin: 0.3em 0.1em">{{ ucfirst($control) }}
                                                                                </span>
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach

                                                                </div>
                                                            </a>


                                                            <div class="col-1 ">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input"
                                                                        id = "toggle-all-{{ $resourceName }}" type="checkbox"
                                                                        onchange="updatePermission(event, '{{ $accessController['scope']->name }}', '{{ $accessController['scope']->id }}', 'all', '{{ $resourceName }}')"
                                                                        @if($accessController["toggleAllPermissionSwitchInitColors"][$resourceName]['permissionCount'])
                                                                            checked
                                                                        @endif

                                                                        style="background-color: {{$accessController["toggleAllPermissionSwitchInitColors"][$resourceName]['bg']}};
                                                                                border: {{$accessController["toggleAllPermissionSwitchInitColors"][$resourceName]['bg']}}
                                                                        "
                                                                    />

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <div class="card-body pt-4 p-2 p-md-4 pt-md-4 mb-2">
                                                        <ul class="list-group collapse p-3" id="{{ $resourceName }}">
                                                            @foreach ($accessController['allControls'] as $control)
                                                                <li
                                                                    class="list-group-item  border-0  ps-3 pe-5 py-3 my-1 bg-gray-100 border-radius-lg ">
                                                                    <div class="row d-flex justify-content-between px-3">
                                                                        <div class="col-11">
                                                                            <p class="mb-3 text-sm">
                                                                                <span
                                                                                    class="text-dark font-weight-bold">{{ ucfirst($accessController['scope']->name) }}</span>
                                                                                should be able to <span
                                                                                    class="font-weight-bold">{{ $control }}</span>
                                                                                {{ strtolower($resourceName) }} records
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-1 ">
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id = "toggle-{{ $control }}-{{ $resourceName }}"
                                                                                    onchange="updatePermission(event, '{{ $accessController['scope']->name }}', '{{ $accessController['scope']->id }}', '{{ $control }}', '{{ $resourceName }}')"

                                                                                    @if(in_array($control, $accessController["toggleAllPermissionSwitchInitColors"][$resourceName]['controls']))
                                                                                        checked
                                                                                        style="background-color: {{$accessController["toggleAllPermissionSwitchInitColors"]['onColor']}};
                                                                                        border: {{$accessController["toggleAllPermissionSwitchInitColors"]['onColor']}} "


                                                                                    @endif

                                                                                >
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
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>























    <script>
        const offColor = '#e8ebee'
        const onColor = '#98ec2d';
        const halfOnColor = 'green';


















// Define the callback function to be executed when the element appears in the viewport
const callback = (entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // The element has appeared in the viewport
            console.log('Element is in view:', entry.target);
            // Perform any actions you need when the element is visible
            entry.target.style.backgroundColor = 'yellow'; // Example action

            // Optionally, stop observing the element if you only need to track its appearance once
            observer.unobserve(entry.target);
        }
    });
};

// Create a new IntersectionObserver instance
const observer = new IntersectionObserver(callback, {
    root: null, // Use the viewport as the root
    rootMargin: '0px',
    threshold: 0.1 // Trigger the callback when 10% of the element is visible
});

// Target the element(s) you want to observe
const targetElement = document.getElementById('thePanel');
observer.observe(targetElement);
















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



        function toggleCheckBoxColor(event, data) {

            // Toggle one of the switch color
            const switched = event.target;
            if (switched.checked) {
                switched.style.backgroundColor = onColor;
                switched.style.border = onColor;
            } else {
                switched.style.backgroundColor = offColor;
                switched.style.border = offColor;
            }


            // Handling the  TOGGLE ALL switch
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




        function updatePermission(event, scope, scopeId, control, resourceName) {
            //alert(checkbox.checked+": "+scope+" "+scopeId+" "+control+" "+resourceName);
            const isChecked = event.target.checked;
            const url = '{{ route('access-control.update') }}'; // Define your route name for updating permissions

            fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        scope_id: scopeId,
                        scope: scope,
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
        }
    </script>


