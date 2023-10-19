<?php
//  fetch category
require 'config.php';
session_start();
require 'config.php';
if(!isset( $_SESSION['user_id']))
{
  header("Location: index.php");
}
// fetch data from table
mysqli_set_charset($connection, "utf8");

$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 10;
$offset = ($current_page - 1) * $items_per_page;

$query = "SELECT * FROM services ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
$services = mysqli_query($connection, $query);

// Calculate total pages for pagination
$total_rows_query = "SELECT COUNT(*) AS total FROM services";
$total_rows_result = mysqli_query($connection, $total_rows_query);
$total_rows = mysqli_fetch_assoc($total_rows_result)['total'];
$total_pages = ceil($total_rows / $items_per_page);



//  insert category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['addService'])) {


        $categoryId = $_POST['categoryId'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $included = $_POST['included'];
        $excluded = $_POST['excluded'];
        $charge = $_POST['charge'];
        $status = $_POST['status'];

        $Insertquery = "INSERT INTO `services`(`category_id`,`title`, `type`, `description`, `included`, `excluded`, `charge`, `status`) VALUES ('$categoryId','$title','$type','$description','$included','$excluded','$charge','$status')";


        if ($connection->query($Insertquery)) {
            $message = "Record inserted successfully.";


            header("Location:service.php?message=" . urlencode($message));
            exit;
        } else {
            $message = "Something is wrong.";


            header("Location:category.php?message=" . urlencode($message));
            exit;
        }
    }
    // edit Data
    if (isset($_POST["editService"])) {


        $id = $_POST["serviceId"];
        $category_id = $_POST["categoryId"];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $included = $_POST['included'];
        $excluded = $_POST['excluded'];
        $charge = $_POST['charge'];
        $status = $_POST['status'];



        mysqli_set_charset($connection, "utf8");
        $updateQuery = "UPDATE services SET category_id='$category_id',title='$title', type='$type', description='$description', included='$included', excluded='$excluded', status='$status', charge='$charge' WHERE id='$id'";

        if (mysqli_query($connection, $updateQuery)) {
            $message = "Record updated successfully.";

            mysqli_close($connection);

            // Redirect to the index.php page with the message
            header("Location: service.php?message=" . urlencode($message));
            exit;
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
    // Delete data
    if (isset($_POST['serviceId']) && !empty($_POST['serviceId'])) {

        $serviceId = mysqli_real_escape_string($connection, $_POST['serviceId']);

        // SQL query to delete the question
        $deleteQuery = "DELETE FROM services WHERE id = '$serviceId'";

        // Execute the query
        if (mysqli_query($connection, $deleteQuery)) {
            $message = "Record deleted successfully.";

            // Redirect to the index.php page with the message
            header("Location: service.php?message=" . urlencode($message));
            exit;
        } else {
            echo "Error deleting question: " . mysqli_error($connection);
        }

        // Close the database connection
        mysqli_close($connection);
    } else {
        $message = "This data not found";

        // Redirect to the index.php page with the message
        header("Location: category.php?message=" . urlencode($message));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin-Service</title>
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
                <h1>Search</h1>

                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ol>
                </nav>
            </div>
            <div class="text-center p-2">
                <img src="https://otp799999.000webhostapp.com/frontend/image/The-search.png" alt="" style="width:100px !important;height:75px !important" class="text-center">
            </div>

        </div><!-- End Page Title -->

        <section>
            <div class="card p-3">
                <div class="card-header d-flex">
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fa-solid fa-plus"></i> Add New
                        </button>
                    </div>

                </div>
                <div class="card-body table-responsive">

                    <table id="example" class="display table " style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Service Title</th>
                                <th>Description</th>
                                <th>Charge</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serialNumber = 1;

                            while ($service = mysqli_fetch_assoc($services)) { ?>
                                <tr>
                                    <td><?php echo $serialNumber++; ?></td>
                                    <td><?php echo $service['title']; ?></td>
                                    <td><?php echo $service['description']; ?></td>
                                    <td><?php echo $service['charge']; ?></td>
                                    <td><span class="badge <?php echo $service['status'] === 'Active' ? 'bg-success' : 'bg-danger'; ?>"><?php echo $service['status']; ?></span></td>

                                    <!-- Action row -->
                                    <td class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#showModal">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <form action="service.php" method="POST" class="deleteForm">
                                            <input type="hidden" value="<?php echo $service['id']; ?>" name="serviceId">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" name="deleteData">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>


                                    </td>
                                    <!-- edit modal -->
                                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="offerForm" action="service.php" enctype="multipart/form-data" method="POST">
                                                        <input type="hidden" name="serviceId" value="<?php echo $service['id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="category" class="form-label">Category</label>
                                                            <select class="form-select" id="category" name="categoryId" required>
                                                                <option value="">Select Category</option>
                                                                <?php
                                                                $query = "SELECT * FROM categories ORDER BY id DESC";
                                                                $categories = mysqli_query($connection, $query);
                                                                while ($category = mysqli_fetch_assoc($categories)) {
                                                                ?>
                                                                    <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $service['category_id'] ? 'selected' : ''; ?>>
                                                                        <?php echo $category['title']; ?>
                                                                    </option>

                                                                <?php
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $service['title']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="type" class="form-label">Type</label>
                                                            <input type="text" class="form-control" id="type" name="type" value="<?php echo $service['type']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $service['description']; ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="included" class="form-label">Included Items</label>
                                                            <textarea class="form-control" id="included" name="included" rows="3"><?php echo $service['included']; ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="excluded" class="form-label">Excluded Items</label>
                                                            <textarea class="form-control" id="excluded" name="excluded" rows="3"><?php echo $service['excluded']; ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="charge" class="form-label">Charge</label>
                                                            <input type="number" class="form-control" id="charge" name="charge" value="<?php echo $service['charge']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-select" id="status" name="status" required>
                                                                <option value="">Select status</option>
                                                                <option value="Active" <?php echo $service['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                                                <option value="Inactive" <?php echo $service['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                                            </select>
                                                        </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="editService">Save</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end edit modal -->
                                    <!-- show modal -->
                                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Show Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label"><strong>Email address :</strong> dksufgywerjhfgwejh </label>
                                                        <hr>
                                                        <label for="exampleFormControlInput1" class="form-label"><strong>Email address :</strong> dksufgywerjhfgwejh </label>
                                                        <hr>
                                                        <label for="exampleFormControlInput1" class="form-label"><strong>Email address :</strong> dksufgywerjhfgwejh </label>
                                                        <label for="exampleFormControlInput1" class="form-label"><strong>Email address :</strong> dksufgywerjhfgwejh </label>

                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>

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
                                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
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
                            <li class="page-item <?php echo ($current_page === $total_pages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <?php include_once "include/modal/service_modal.php" ?>
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <?php include_once "include/layout/footer.php" ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <?php include_once "include/layout/js.php" ?>


</body>

</html>