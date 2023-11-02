<?php
//  fetch category
require 'config.php';
session_start();

if(!isset( $_SESSION['user_id']))
{
  header("Location: index.php");
}
// fetch data from table
mysqli_set_charset($connection, "utf8");

$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 10;
$offset = ($current_page - 1) * $items_per_page;

// $query = "SELECT * FROM service_requests ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";

$query = "SELECT sr.*, 
                 u_user.name AS user_name, 
                 u_user.mobile AS user_mobile,
                 up_user.address AS user_address, 
                 up_user.profile_image AS user_image,
                 u_servicer.name AS servicer_name,
                 u_servicer.mobile AS servicer_mobile,
                 sp_servicer.address AS servicer_address,
                 sp_servicer.profile_image AS servicer_image
          FROM service_requests sr
          LEFT JOIN users u_user ON sr.user_id = u_user.id
          LEFT JOIN user_profiles up_user ON sr.user_id = up_user.user_id
          LEFT JOIN users u_servicer ON sr.servicer_id = u_servicer.id
          LEFT JOIN servicer_profiles sp_servicer ON sr.servicer_id = sp_servicer.user_id
          ORDER BY sr.id DESC
          LIMIT $items_per_page OFFSET $offset";



$result = mysqli_query($connection, $query);
// Define the default table name and the JOIN condition





// Prepare the SQL query with the dynamically selected table and JOIN condition



// Calculate total rows for pagination
$total_rows_query = "SELECT COUNT(*) AS total FROM service_requests";
$total_rows_result = mysqli_query($connection, $total_rows_query);
$total_rows = mysqli_fetch_assoc($total_rows_result)['total'];
$total_pages = ceil($total_rows / $items_per_page);

// status updated
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['statusUpdate'])) {
        $status = $_POST['status'];
        $id = $_POST['id'];

        $updateQuery = "UPDATE `service_requests` SET `status` = '$status', `updated_at` = NOW() WHERE id = '$id'";
        $resultRequest = mysqli_query($connection, $updateQuery);
        if ($resultRequest) {
            $message = "Status Update Successfully.";

            // Redirect to the index.php page with the message
            header("Location: request.php?message=" . urlencode($message));
            exit;
        } else {
            $message = "Something is wrong.";

            // Redirect to the index.php page with the message
            header("Location: request.php?message=" . urlencode($message));
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin-Category</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include_once "include/layout/css.php" ?>

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include_once "include/layout/topbar.php" ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include_once "include/layout/sidebar.php" ?>
    <!-- End Sidebar-->

    <main id="main" class="main">
        <div id="notification"></div>

        <?php
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        ?>
            <div class="fixed-alert" style="position: fixed;top: 10px;right: 300px; z-index: 1000">
                <div class="alert text-white shadow" role="alert" style="background-color: green;">
                    <i class="fa-solid fa-check fa-bounce fa-2xl mr-2"></i>
                    <?php echo $message ?>

                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

            </div>

            <script>
                // Remove the message parameter from the URL on page load
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.pathname);
                }
            </script>
        <?php
        }
        ?>
       <div class="pagetitle d-flex justify-content-between">
            <div class="mt-3">
                <h1>Service Request</h1>

                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Service Request</li>
                    </ol>
                </nav>
            </div>
            <div class="text-center p-2">
                <img src="https://otp799999.000webhostapp.com/frontend/image/The-search.png" alt="" style="width:100px !important;height:75px !important" class="text-center">
            </div>

        </div><!-- End Page Title -->

        <section>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: hsl(180, 2%, 80%);">
                    <!-- <div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa-solid fa-plus"></i> Add New
        </button>
    </div> -->
                    <div class="form-group mb-0">
                        <label for="statusFilter" class="me-2 text-dark">Filter by Status <i class="fa-solid fa-filter"></i></label>
                        <select class="form-select" id="statusFilter">
                            <option value="all">All</option>
                            <option value="Accepted">Accepted</option>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div>
                        <!-- <div class="btn-group">
  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Get Status
  </button>
  <ul class="dropdown-menu">
  <li><a class="dropdown-item" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="#">Something else here</a></li>
    
  </ul>
</div> -->
                    </div>
                    <div class="form-group mb-0">
                        <label for="search" class="me-2">Search:</label>
                        <input type="text" id="search" class="form-control" placeholder="Search...">
                    </div>
                </div>


                <div class="card-body table-responsive">

                    <table id="example" class="display table " style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>User Name</th>
                                <th>User Mobile</th>
                                <th>User Address</th>
                                <th>Servicer Name</th>
                                <th>Servicer Mobile</th>
                                <th>Servicer Address</th>

                                <th>Requested Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php
                            $serialNumber = 1;

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $serialNumber++; ?></td>
                                    <td><?php echo $row['user_name']; ?></td>
                                    <td><?php echo $row['user_mobile']; ?></td>
                                    <td><?php echo $row['user_address']; ?></td>
                                    <td><?php echo $row['servicer_name']; ?></td>
                                    <td><?php echo $row['servicer_mobile']; ?></td>
                                    <td><?php echo $row['servicer_address']; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($row['created_at'])); ?></td>

                                    <td>
                                        <?php
                                        $status = $row['status'];
                                        $badgeClass = '';

                                        if ($status == 'completed') {
                                            $badgeClass = 'bg-success';
                                        } elseif ($status == 'accepted') {
                                            $badgeClass = 'bg-primary';
                                        } elseif ($status == 'pending') {
                                            $badgeClass = 'bg-danger';
                                        }

                                        $capitalizedStatus = ucfirst($status); // Capitalize the first letter

                                        echo '<span class="badge ' . $badgeClass . '">' . $capitalizedStatus . '</span>';

                                        ?>

                                    </td>


                                    <!-- Action row -->
                                    <td class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id'] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#showModal<?php echo $row['id'] ?>">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <form action="user_crud.php" method="POST" class="deleteForm">
                                            <input type="hidden" value="<?php echo $row['id']; ?>" name="id">

                                            <button type="submit" class="btn btn-outline-danger btn-sm" name="deleteUser">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>


                                    </td>
                                    <!-- edit modal -->
                                    <!-- Your HTML for the modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: rgb(223, 226, 217);">
                                                    <!-- Modal header content goes here -->
                                                </div>
                                                <div class="modal-body" style="background-color: #a1c7b3;">
                                                    <!-- Modal body content goes here -->
                                                    <form action="request.php" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="status">
                                                            <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                                            <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                                            <option value="accepted" <?php if ($row['status'] == 'accepted') echo 'selected'; ?>>Accepted</option>
                                                        </select>


                                                </div>
                                                <div class="modal-footer mx-auto text-center">
                                                    <!-- Modal footer content goes here -->
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" name="statusUpdate">Save Change</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end edit modal -->
                                    <!-- show modal -->
                                    <div class="modal fade" id="showModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-fullscreen">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: hsla(207, 88%, 91%, 0.841);">
                                                    <h3 class="modal-title text-center fw-bold mx-auto" id="exampleModalLabel" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;">
                                                        Service Request Details
                                                    </h3>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="background-color: rgb(138, 209, 234);">

                                                    <div class="row mx-lg-4 rounded-4" style="background-color: #ffffff;">

                                                        <div class="col-12 col-md-6 col-xl-6 col-lg-12">
                                                            <div class="m-2 p-3  rounded-4">
                                                                <div class="d-flex justify-content-between">
                                                                    <h3>User</h3>
                                                                    <img src="https://otp799999.000webhostapp.com/admin/public/profile/<?php echo $row['user_image']; ?>" alt="" style="border-radius: 50%; width: 50px; height: 50px;">
                                                                </div>
                                                                <hr>

                                                                <div class="row">
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Name</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['user_name']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Mobile</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['user_mobile']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-12 col-xl-12 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Address</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['user_address']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-12 col-xl-12 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Requested Date</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo date('d-M-Y', strtotime($row['created_at'])); ?>" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-xl-6 col-lg-12">
                                                            <div class=" m-2 p-3 rounded-4">
                                                                <div class="d-flex justify-content-between">
                                                                    <h3>Servicer</h3>
                                                                    <img src="https://otp799999.000webhostapp.com/admin/public/profile/<?php echo $row['servicer_image']; ?>" alt="" style="border-radius: 50%; width: 50px; height: 50px;">
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Name</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['servicer_name']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Mobile</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['servicer_mobile']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Address</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['servicer_address']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Status</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['status']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Approved Date</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo date('d-M-Y', strtotime($row['updated_at'])); ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 py-2 col-12">
                                                                        <label for="name" class="form-label fw-bold">Completed Date</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo date('d-M-Y', strtotime($row['completed_at'])); ?>" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <!-- Modal footer content goes here -->
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <!-- Add additional footer buttons or content here -->
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end show modal -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- Pagination links -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">

                            <!-- Previous Button -->
                            <li class="page-item <?php echo ($current_page === 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&role=<?php echo $role; ?>" aria-label="Previous">
                                    <span aria-hidden="true">Previous</span>
                                </a>
                            </li>

                            <!-- Display a subset of page numbers -->
                            <?php
                            $max_visible_pages = 10; // Adjust this number as needed
                            $start_page = max(1, $current_page - floor($max_visible_pages / 2));
                            $end_page = min($total_pages, $start_page + $max_visible_pages - 1);

                            for ($i = $start_page; $i <= $end_page; $i++) {
                            ?>
                                <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                            <!-- Next Button -->
                            <li class="page-item <?php echo ($current_page ===  $end_page || $total_pages === 0) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo ($current_page === $total_pages || $total_pages === 0) ? 'disabled' : '?page=' . ($current_page + 1) . '&role=' . $role; ?>" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>


                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <?php include_once "include/modal/category_modal.php" ?>
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <?php include_once "include/layout/footer.php" ?>
    <!-- End Footer -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    </script>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <?php include_once "include/layout/js.php" ?>


</body>

</html>