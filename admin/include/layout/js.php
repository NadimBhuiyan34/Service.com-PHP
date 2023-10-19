
  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <!-- alert message -->
  <script>
        // Function to hide the alert and progress bar after a delay
        function hideAlertAndProgressBar() {
            const duration = 5000; // 5000ms = 5 seconds
            const progressBar = $(".progress-bar");

            let progress = 0;
            const interval = 100; // 100ms interval for updating progress
            const steps = duration / interval;

            const updateProgressBar = setInterval(function() {
                progress += 100 / steps;
                progressBar.css("width", progress + "%");

                if (progress >= 100) {
                    clearInterval(updateProgressBar);
                    $(".fixed-alert").fadeOut(500, function() {
                        $(this).remove(); // Remove the entire .fixed-alert container
                    });
                }
            }, interval);
        }

        // Call the function when the page loads
        hideAlertAndProgressBar();
    </script>
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle delete form submissions
            $(".deleteForm").submit(function(event) {
                if (!confirm("Are you sure you want to delete this row?")) {
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
    
    <script>
        $(document).ready(function() {
            $('#statusFilter').change(function() {
                var selectedStatus = $(this).val(); // Get the selected status

                // Show all rows initially
                $('#tableBody tr').show();

                // Filter rows based on selected status
                if (selectedStatus !== 'all') {
                    $('#tableBody tr').not(':has(td:contains(' + selectedStatus + '))').hide();
                }
            });
        });


        // searchg

        $(document).ready(function() {
            $('#statusFilter, #search').on('input', function() {
                var selectedStatus = $('#statusFilter').val();
                var searchQuery = $('#search').val().toLowerCase();

                // Show all rows initially
                $('#tableBody tr').show();

                // Filter rows based on selected status
                if (selectedStatus !== 'all') {
                    $('#tableBody tr').not(':has(td:contains(' + selectedStatus + '))').hide();
                }

                // Filter rows based on search query
                if (searchQuery !== '') {
                    $('#tableBody tr').filter(function() {
                        return $(this).text().toLowerCase().indexOf(searchQuery) === -1;
                    }).hide();
                }
            });
        });
    </script>