@script
    <!---------- SCRIPT - IMAGE CROPPER  ---------->
    <script>
        let cropper;

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-crop-image-modal', (event) => {
                //alert(JSON.stringify(event[0].field))
                const field = event[0].field;
                const imgSrc = event[0].imgUrl;

                // Get the modal element by ID
                const modalElement = document.getElementById('crop-modal-' + field);
                // Create a new Bootstrap Modal instance
                const myModal = new bootstrap.Modal(modalElement, {
                    keyboard: false // Optional: Disable closing the modal with keyboard
                });

                // Show the modal
                myModal.show();


                // Set up the Cropper.js instance once the modal is fully shown
                modalElement.addEventListener('shown.bs.modal', function() {
                    const cropperContainer = document.getElementById('cropper-container-' + field);

                    // Ensure the container has 100% width and appropriate height
                    cropperContainer.style.width = '100%';
                    cropperContainer.style.height = '70vh'; // Adjust height as needed

                    // Initialize Cropper.js if not already initialized
                    const image = document.getElementById('image-to-crop-' +
                        field); // Ensure you have an image element with this ID

                    if (image) {

                        image.src = imgSrc;
                        // Destroy the old cropper instance if it exists
                        // Destroy the old cropper instance if it exists
                        if (cropper) {
                            cropper.destroy();
                        }

                        cropper = new Cropper(image, {
                            aspectRatio: 0, // Set aspect ratio if needed
                            viewMode: 2, // Adjust the view mode as needed
                            autoCropArea: 1, // Optional: Set the initial crop area to cover the entire image
                            responsive: true // Optional: Enable responsive mode
                        });

                        // Save cropped image on button click
                        document.getElementById('save-croped-image-' + field).addEventListener(
                            'click',
                            function() {
                                // Get the cropped image data URL
                                const croppedImage = cropper.getCroppedCanvas().toDataURL(
                                    'image/jpeg');
                                // Emit the event to Livewire with the Base64 image data
                                @this.call('saveCroppedImage', field, croppedImage);
                                // Close the modal
                                myModal.hide();
                            });
                    }
                });

            })
        });
    </script>
@endscript


<!----------  SWEET ALEART CONFIRM DELETE  ---------->
@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('confirm-delete', () => {
                // Use the theme's showSwal function for 'warning-message-and-confirmation'
                //soft.showSwal('warning-message-and-confirmation'); // Adjust if needed based on your theme configuration

                // Make sure to call this after the user confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this operation!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    customClass: {
                        confirmButton: 'btn bg-gradient-success me-3',
                        cancelButton: 'btn bg-gradient-danger'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        //form.submit();
                        @this.call('deleteSelected');
                    }
                });

            });


            window.addEventListener('swal:success', function(event) {
                Swal.fire({
                    title: event.detail[0].title,
                    text: event.detail[0].text,
                    icon: event.detail[0].icon,
                    showConfirmButton: false,
                    timer: 2000
                });
            });


        });
    </script>
@endscript


<!---------- SHOW DETAIL MODAL   ------------->
@script
    <script>
        document.addEventListener('livewire:initialized', function() {
            // Listen for Livewire event to open the modal
            @this.on('openModal', () => {
                var modal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                    keyboard: false
                });
                modal.show();
            });
        });
    </script>
@endscript

<!-------------- SHOW ADD - EDIT MODAL ------------------>
@script
    <script>
        document.addEventListener('livewire:initialized', function() {
            window.addEventListener('openAddEditModal', function() {
                var modal = new bootstrap.Modal(document.getElementById('addEditModal'));
                modal.show();
            });

            window.addEventListener('closeAddEditModal', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('addEditModal'));
                modal.hide();
            });
        });
    </script>
@endscript


<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script>
    function printTable() {
        printJS({
            printable: 'dataTable',
            type: 'html',
            showModal: true,
            style: `
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
                    .no-print { display: none; } /* Hide elements with the 'no-print' class */
                `
        });
    }
</script>
