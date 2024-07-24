// <!-------------------------------------------------------- Plugins Starts ---------------------------------------------->
// <!------------- Flat Date Picker JS -------------->

        if (document.querySelector('.datepicker')) {
            flatpickr('.datepicker', {
            dateFormat: "j/n/Y",
            });
        }

        if (document.querySelector('.date-range-picker')) {
            flatpickr('.date-range-picker', {
                mode: "range",
                dateFormat: "j/n/Y",
            });
        }

        if (document.querySelector('.multiple-date-picker')) {
            flatpickr('.multiple-date-picker', {
                mode: "multiple",
                dateFormat: "j/n/Y",
            });
        }

        if (document.querySelector('.datetime-picker')) {
            flatpickr('.datetime-picker', {
                enableTime: true,
                dateFormat: "j/n/Y G:i K",
            });
        }

    // <!------------- Flat Date Picker JS ENDS -------------->

    // <!------------------- Sweet Alert JS ------------------>

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the form from submitting immediately

                // Get the form id from the button's data attribute
                const formId = button.getAttribute('data-form-id');
                const form = document.getElementById(formId);

                if (!form) {
                    console.error('Form with id = "' + formId + '" not found');
                    return;
                }

                // Use the theme's showSwal function for 'warning-message-and-confirmation'
                soft.showSwal('warning-message-and-confirmation'); // Adjust if needed based on your theme configuration

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
                        form.submit();
                    }
                });
            });
        });
    });



    // <!------------------- Sweet Alert ENDS ------------------>





    // <!---------------------- Custom Data Table FUNCTIONALTIES ----------------------->

            // <!---------  XLS File  ----------->

            function exportToExcel(tableId = 'data_table', file_name = 'exported_xls_file') {
                const table = document.getElementById(tableId);
                if (!table) {
                    console.error('Table not found');
                    return;
                }

                let tableData = document.getElementById(tableId).outerHTML;
                tableData = tableData.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
                tableData = tableData.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params
                //tableData = tableData + '<br /><br />Code witten By sudhir K gupta.<br />My Blog - https://comedymood.com'

                let a = document.createElement('a');
                a.href = `data:application/vnd.ms-excel, ${encodeURIComponent(tableData)}`
                a.download = file_name+ '.xls'
                a.click()
            }


            // <!-------------  CSV File ----------->
            function exportTableToCSV(tableId = 'data_table', filename = 'exported_csv_file') {
                const table = document.getElementById(tableId);
                if (!table) {
                    console.error('Table not found');
                    return;
                }

                let csvContent = '';

                // Get the headers
                const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
                csvContent += headers.join(',') + '\n';

                // Get the rows
                const rows = Array.from(table.querySelectorAll('tbody tr'));
                rows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim());
                    csvContent += cells.join(',') + '\n';
                });

                // Create a blob and trigger download
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

        // <!------------ PDF File ------------>
            function exportTableToPDF(tableId = 'data_table', filename = 'exported_pdf_file') {
                // Get the table element
                const table = document.getElementById(tableId);
                if (!table) {
                    console.error('Table not found');
                    return;
                }

                var worker = html2pdf();  // Or:  var worker = new html2pdf.Worker;
                var worker = html2pdf().from(table).save(filename);
            }

        // <!------------ Column Search  ------------>
            function searchFilter(tableId = 'data_table', search_box_id = 'search_box') {

                // Declare variables
                var input, filter, table, tr, td, i, txtValue;

                // Get the search input element
                input = document.getElementById(search_box_id);
                if (!input) {
                    console.error('Search input with id = "' + search_box_id + '" not found');
                    return;
                }

                // Get the table element
                table = document.getElementById(tableId);
                if (!table) {
                    console.error('Table with id = "' + tableId + '" not found');
                    return;
                }

                // Get the search filter
                filter = input.value.toUpperCase();
                // Get all table rows
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                    td = tr[i].getElementsByTagName("td");
                    if (td) {
                        let rowMatches = false;
                        // Loop through all cells in the row
                        for (let j = 0; j < td.length; j++) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                rowMatches = true;
                                break;
                            }
                        }
                        if (rowMatches) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

        // <!------------ Column Sort  ------------>
            function sortTable(n) {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("data_table");
                switching = true;
                dir = "asc";
                while (switching) {
                    switching = false;
                    rows = table.rows;
                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];
                        let xContent = x.innerHTML.trim();
                        let yContent = y.innerHTML.trim();
                        if (dir == "asc") {
                            if (isNaN(xContent) || isNaN(yContent)) {
                                if (xContent.toLowerCase() > yContent.toLowerCase()) {
                                    shouldSwitch = true;
                                    break;
                                }
                            } else {
                                if (parseFloat(xContent) > parseFloat(yContent)) {
                                    shouldSwitch = true;
                                    break;
                                }
                            }
                        } else if (dir == "desc") {
                            if (isNaN(xContent) || isNaN(yContent)) {
                                if (xContent.toLowerCase() < yContent.toLowerCase()) {
                                    shouldSwitch = true;
                                    break;
                                }
                            } else {
                                if (parseFloat(xContent) < parseFloat(yContent)) {
                                    shouldSwitch = true;
                                    break;
                                }
                            }
                        }
                    }
                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount++;
                    } else {
                        if (switchcount == 0 && dir == "asc") {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                var headers = document.querySelectorAll('#data_table th');
                headers.forEach(function(header, index) {
                    if (index !== 0) {
                        header.addEventListener('click', function() {
                            sortTable(index);
                        });
                    }
                });
            });




       //  <!---- BULK DELETE ---->

       document.addEventListener('DOMContentLoaded', function() {
           var selectAllCheckbox = document.getElementById('select-all');
           var rowCheckboxes = document.querySelectorAll('.row-checkbox');
           var bulkDeleteBtn = document.getElementById('bulk-delete-btn');
           var bulkDeleteForm = document.getElementById('bulk-delete-form');

            if (selectAllCheckbox) { // Avoide attempt on empty record
                selectAllCheckbox.addEventListener('change', function(event) {
                    event.stopPropagation(); // Prevent the sorting event from being triggered
                    rowCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    toggleBulkDeleteBtn();
                });
            }

           rowCheckboxes.forEach(function(checkbox) {
               checkbox.addEventListener('change', function(event) {
                   event.stopPropagation(); // Prevent the sorting event from being triggered
                   if (!checkbox.checked) {
                       selectAllCheckbox.checked = false;
                   }
                   toggleBulkDeleteBtn();
               });
           });

           function toggleBulkDeleteBtn() {
               var anyChecked = Array.from(rowCheckboxes).some(function(checkbox) {
                   return checkbox.checked;
               });
               bulkDeleteBtn.style.display = anyChecked ? 'block' : 'none';
           }

           function getSelectedIds() {
               return Array.from(rowCheckboxes)
                   .filter(function(checkbox) {
                       return checkbox.checked;
                   })
                   .map(function(checkbox) {
                       return checkbox.getAttribute('data-id');
                   });
           }

           window.bulkDelete = function() {
               var ids = getSelectedIds();
               if (ids.length === 0) {
                   alert('No records selected');
                   return;
               }

               Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this operation!",
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonText: 'Yes, delete them!',
                   cancelButtonText: 'No, cancel!',
                   customClass: {
                       confirmButton: 'btn bg-gradient-success me-3',
                       cancelButton: 'btn bg-gradient-danger'
                   },
                   buttonsStyling: false
               }).then((result) => {
                   if (result.isConfirmed) {
                       ids.forEach(function(id) {
                           var idInput = document.createElement('input');
                           idInput.name = 'ids[]';
                           idInput.value = id;
                           idInput.type = 'hidden';
                           bulkDeleteForm.appendChild(idInput);
                       });

                       bulkDeleteForm.submit();
                   }
               });
           };
       });



       // !<---- CHANGE NO OF ROWS PER PAGE

        function changeRecordsPerPage() {
            var recordsPerPage = document.getElementById('records-per-page').value;
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('records_per_page', recordsPerPage);
            window.location.href = currentUrl.toString();
        }

     // <!---------------------- Custom Data Table FUNCTIONALTIES ENDS ----------------------->


     // <!-------------------------------------------------------- Plugins Ends ---------------------------------------------->
