@extends('layouts.app')

@section('auth-soft-ui')
    <div>
        </span>

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
                                Who do you want to control?
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                Access Control
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Control scope selection') }}</h6>
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











                        <div class="form-group px-2">
                            <label for="scope" class="form-control-label">Scope type</label>

                            <select class="form-select{{ $errors->has('scope') ? ' is-invalid' : '' }}" id="scope" name="scope">
                                <option value="" style="display: none;"  disabled selected>Select scope...</option>
                                <option value="role">Role</option>
                                <option value="team">Team</option>
                                <option value="user">User</option>
                            </select>

                            {!! $errors->first('scope', '<div class="invalid-feedback">:message</div>') !!}
                        </div>







                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <span id="accessControllerData" data-accesscontroller="{{ json_encode($accessController) }}"></span>

    </div>
@endsection


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
