<?php
//  fetch category
require 'config.php';
session_start();
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
// fetch data from table
mysqli_set_charset($connection, "utf8");

$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 10;
$offset = ($current_page - 1) * $items_per_page;

$query = "SELECT * FROM categories ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
$result = mysqli_query($connection, $query);

// Calculate total pages for pagination
$total_rows_query = "SELECT COUNT(*) AS total FROM categories";
$total_rows_result = mysqli_query($connection, $total_rows_query);
$total_rows = mysqli_fetch_assoc($total_rows_result)['total'];
$total_pages = ceil($total_rows / $items_per_page);



//  insert category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['addCategory'])) {
        include_once('config.php');
        // $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        //     echo "Document Root: $documentRoot"; 

        $uploadDir = 'public/category/';

        $uploadedFile = $_FILES['bannerImage']['tmp_name'];
        $imageName = $_FILES['bannerImage']['name'];
        $imagePath = $uploadDir . $imageName;


        move_uploaded_file($uploadedFile, $imagePath);

        $title = $_POST['title'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $included = $_POST['included'];
        $excluded = $_POST['excluded'];
        $status = $_POST['status'];

        $Insertquery = "INSERT INTO `categories`(`title`, `type`, `description`, `included`, `excluded`, `banner_image`, `status`) VALUES ('$title','$type','$description','$included','$excluded','$imageName','$status')";


        if ($connection->query($Insertquery)) {
            $message = "Record inserted successfully.";


            header("Location:category.php?message=" . urlencode($message));
            exit;
        } else {
            $message = "Something is wrong.";


            header("Location:category.php?message=" . urlencode($message));
            exit;
        }
    }
    // edit Data
    if (isset($_POST["editCategory"])) {

        if (isset($_FILES['bannerImage']) && $_FILES['bannerImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'public/category/';

            $uploadedFile = $_FILES['bannerImage']['tmp_name'];
            $imageName = $_FILES['bannerImage']['name'];
            $imagePath = $uploadDir . $imageName;


            move_uploaded_file($uploadedFile, $imagePath);
        }

        $id = $_POST["categoryId"];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $included = $_POST['included'];
        $excluded = $_POST['excluded'];
        $status = $_POST['status'];
        $banner_image = $imageName ??  $_POST['banner_image'];


        mysqli_set_charset($connection, "utf8");
        $updateQuery = "UPDATE categories SET title='$title', type='$type', description='$description', included='$included', excluded='$excluded', status='$status', banner_image='$banner_image' WHERE id='$id'";

        if (mysqli_query($connection, $updateQuery)) {
            $message = "Record updated successfully.";

            mysqli_close($connection);

            // Redirect to the index.php page with the message
            header("Location: category.php?message=" . urlencode($message));
            exit;
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
    // Delete data
    if (isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {

        $categoryId = mysqli_real_escape_string($connection, $_POST['categoryId']);

        // SQL query to delete the question
        $deleteQuery = "DELETE FROM categories WHERE id = '$categoryId'";

        // Execute the query
        if (mysqli_query($connection, $deleteQuery)) {
            $message = "Record deleted successfully.";

            // Redirect to the index.php page with the message
            header("Location: category.php?message=" . urlencode($message));
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
                <h1>Category</h1>

                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fa-solid fa-plus"></i> Add New
                        </button>
                    </div>
                    <div class="form-group mb-0">
                        <label for="statusFilter" class="me-2 text-dark">Filter by Status <i class="fa-solid fa-filter"></i></label>
                        <select class="form-select" id="statusFilter">
                            <option value="all">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
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
                                <th>Category Title</th>
                                <th>Image</th>
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
                                    <td><?php echo $row['title']; ?></td>
                                    <td><img src="public/category/<?php echo $row['banner_image']; ?>" alt="" style="width:80px;height:80px">
                                    </td>
                                    <td><span class="badge <?php echo $row['status'] == 'Active' ? 'bg-success' : 'bg-danger'; ?>"><?php echo $row['status']; ?></span></td>

                                    <!-- Action row -->
                                    <td class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id'] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#showModal<?php echo $row['id'] ?>">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <form action="category.php" method="POST" class="deleteForm">
                                            <input type="hidden" value="<?php echo $row['id']; ?>" name="categoryId">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" name="deleteData">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>


                                    </td>
                                    <!-- edit modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark  text-center">
                                                    <h3 class="modal-title text-white text-center mx-auto" id="exampleModalLabel">Edit Category
                                                    </h3>
                                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                </div>
                                                <div class="modal-body bg-dark-light">
                                                    <form id="offerForm" action="category.php" enctype="multipart/form-data" method="POST">
                                                        <input type="hidden" name="categoryId" value="<?php echo $row['id'] ?>">
                                                        <input type="hidden" name="banner_image" value="<?php echo $row['banner_image'] ?>">
                                                        <div class="card p-2 rounded-4">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                <div class="mx-auto text-center">
                                                                   
                                                                   <img src="public/category/<?php echo $row['banner_image']; ?>" alt="" style="width:120px;height:120px" class="mx-auto pb-3">
                                                                   

                                                                </div>
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="title" class="form-label fw-bold">Title</label>
                                                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title'] ?>" required>
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="type" class="form-label fw-bold">Type</label>
                                                                    <input type="text" class="form-control" id="type" name="type" value="<?php echo $row['type'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="description" class="form-label fw-bold">Description</label>
                                                                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $row['description'] ?></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="included" class="form-label fw-bold">Included Items</label>
                                                                    <textarea class="form-control" id="included" name="included" rows="3"><?php echo $row['included'] ?></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="excluded" class="form-label fw-bold">Excluded Items</label>
                                                                    <textarea class="form-control" id="excluded" name="excluded" rows="3"><?php echo $row['excluded'] ?></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="bannerImage" class="form-label fw-bold">Banner Image</label>
                                                                    <input type="file" class="form-control" id="bannerImage" name="bannerImage" accept="image/*">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label fw-bold">Status</label>
                                                                    <select class="form-select" id="status" name="status" required>
                                                                        <option value="">Select status</option>
                                                                        <option value="Active" <?php if ($row['status'] == 'Active') echo 'selected="selected"'; ?>>Active</option>
                                                                        <option value="Inactive" <?php if ($row['status'] == 'Inactive') echo 'selected="selected"'; ?>>Inactive</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer mx-auto">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" name="editCategory">Save Change</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end edit modal -->
                                    <!-- show modal -->
                                    <div class="modal fade" id="showModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark  text-center">
                                                    <h3 class="modal-title text-white text-center mx-auto" id="exampleModalLabel">Show Category
                                                    </h3>
                                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                </div>
                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <div class="row">

                                                            <div class="col-12 mx-auto">
                                                                <button type="button" class="btn btn-primary">
                                                                    Status <span class="badge <?php echo $row['status'] === 'Active' ? 'bg-success' : 'bg-danger'; ?>"><?php echo $row['status']; ?></span>
                                                                </button>

                                                                <div class="mx-auto text-center">
                                                                    <img src="public/category/<?php echo $row['banner_image']; ?>" alt="" style="width:120px;height:120px" class="mx-auto pb-3">

                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="col-6">
                                                                <label for="formGroupExampleInput" class="form-label fw-bold">Title</label>
                                                                <input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $row['title']; ?>" disabled>
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="formGroupExampleInput" class="form-label fw-bold">Type</label>
                                                                <input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $row['type']; ?>" disabled>
                                                            </div>
                                                            <div class="col-12 pt-3">
                                                                <label for="formGroupExampleInput" class="form-label fw-bold">Description</label>
                                                                <hr>
                                                                <p><?php echo $row['description']; ?></p>
                                                            </div>
                                                            <div class="col-12 pt-3">
                                                                <label for="formGroupExampleInput" class="form-label fw-bold">Included</label>
                                                                <hr>
                                                                <p><?php echo $row['included']; ?></p>
                                                            </div>
                                                            <div class="col-12 pt-3">
                                                                <label for="formGroupExampleInput" class="form-label fw-bold">Excluded</label>
                                                                <hr>
                                                                <p><?php echo $row['excluded']; ?></p>
                                                            </div>
                                                        </div>

                                                    </div>

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
        <?php include_once "include/modal/category_modal.php" ?>
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <?php include_once "include/layout/footer.php" ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <?php include_once "include/layout/js.php" ?>
   

</body>

</html>