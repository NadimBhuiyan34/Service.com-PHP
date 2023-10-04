<?php
//  fetch category
require 'config.php';

// fetch data from table
mysqli_set_charset($connection, "utf8");

$role = isset($_GET['role']) ? $_GET['role'] : 'user'; // Default to 'user' if role is not provided
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 10;
$offset = ($current_page - 1) * $items_per_page;

// Define the default table name and the JOIN condition
$table_name = 'user_profiles';
$join_condition = "users.id = $table_name.user_id";

if ($role === 'servicer') {
    $query = "SELECT users.*, servicer_profiles.*, categories.title, categories.banner_image, AVG(reviews.rating_point) AS average_rating
    FROM users 
    JOIN servicer_profiles ON users.id = servicer_profiles.user_id 
    LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id 
    LEFT JOIN categories ON servicer_profiles.category_id = categories.id 
    GROUP BY users.id, servicer_profiles.user_id, categories.title, categories.banner_image 
    ORDER BY servicer_profiles.user_id DESC 
    LIMIT $items_per_page OFFSET $offset";

}
else{
    $query = "SELECT users.*, user_profiles.* FROM users JOIN user_profiles ON users.id = user_profiles.user_id DESC 
    LIMIT $items_per_page OFFSET $offset";

}

// Prepare the SQL query with the dynamically selected table and JOIN condition


$result = mysqli_query($connection, $query);

// Calculate total rows for pagination
$total_rows_query = "SELECT COUNT(*) AS total FROM users WHERE role = '$role'";
$total_rows_result = mysqli_query($connection, $total_rows_query);
$total_rows = mysqli_fetch_assoc($total_rows_result)['total'];
$total_pages = ceil($total_rows / $items_per_page);
//  insert category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['editUser'])) {
        include_once('config.php');

        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];
        $experience = $_POST['experience'];
        $status = $_POST['status'];
        $user_id = $_POST['user_id'];
        $role = $_POST['role'];

        // Update data in the `users` table
        $updateUserQuery = "UPDATE `users` SET `name`='[value-2]',`mobile`='[value-5]',`status`='[value-8]' WHERE id = '$user_id'";

        if (mysqli_query($connection, $updateUserQuery)) {
            // Data updated in the `users` table successfully

            // Now, update data in the appropriate profile table based on the role
            if ($role == 'servicer') {
                $updateProfileQuery = "UPDATE `servicer_profiles` SET `id`='[value-1]',`user_id`='[value-2]',`service_id`='[value-3]',`category_id`='[value-4]',`address`='[value-5]',`experience`='[value-6]',`biography`='[value-7]',`profile_image`='[value-8]',`work_image`='[value-9]',`created_at`='[value-10]',`updated_at`='[value-11]' WHERE 1";
            } else {
                $updateProfileQuery = "UPDATE user_profiles SET address = '$address' WHERE user_id = $user_id";
            }

            if (mysqli_query($connection, $updateProfileQuery)) {
                // Data updated in the profile table successfully
                $message = "Record Updated successfully.";
                header("Location: users.php?message=" . urlencode($message) . "&role=" . urlencode($role));
            } else {
                echo "Error updating data in the profile table: " . mysqli_error($connection);
            }
        } else {
            echo "Error updating data in users: " . mysqli_error($connection);
        }
    }

    // edit Data
    // if (isset($_POST["editCategory"])) {

    //     if (isset($_FILES['bannerImage']) && $_FILES['bannerImage']['error'] === UPLOAD_ERR_OK) {
    //         $uploadDir = 'public/category/';

    //         $uploadedFile = $_FILES['bannerImage']['tmp_name'];
    //         $imageName = $_FILES['bannerImage']['name'];
    //         $imagePath = $uploadDir . $imageName;


    //         move_uploaded_file($uploadedFile, $imagePath);
    //     }

    //     $id = $_POST["categoryId"];
    //     $title = $_POST['title'];
    //     $type = $_POST['type'];
    //     $description = $_POST['description'];
    //     $included = $_POST['included'];
    //     $excluded = $_POST['excluded'];
    //     $status = $_POST['status'];
    //     $banner_image = $imageName ??  $_POST['banner_image'];


    //     mysqli_set_charset($connection, "utf8");
    //     $updateQuery = "UPDATE categories SET title='$title', type='$type', description='$description', included='$included', excluded='$excluded', status='$status', banner_image='$banner_image' WHERE id='$id'";

    //     if (mysqli_query($connection, $updateQuery)) {
    //         $message = "Record updated successfully.";

    //         mysqli_close($connection);

    //         // Redirect to the index.php page with the message
    //         header("Location: category.php?message=" . urlencode($message));
    //         exit;
    //     } else {
    //         echo "Error: " . mysqli_error($connection);
    //     }
    // }
    // Delete data
    // if (isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {

    //     $categoryId = mysqli_real_escape_string($connection, $_POST['categoryId']);

    //     // SQL query to delete the question
    //     $deleteQuery = "DELETE FROM categories WHERE id = '$categoryId'";

    //     // Execute the query
    //     if (mysqli_query($connection, $deleteQuery)) {
    //         $message = "Record deleted successfully.";

    //         // Redirect to the index.php page with the message
    //         header("Location: category.php?message=" . urlencode($message));
    //         exit;
    //     } else {
    //         echo "Error deleting question: " . mysqli_error($connection);
    //     }

    //     // Close the database connection
    //     mysqli_close($connection);
    // } else {
    //     $message = "This data not found";

    //     // Redirect to the index.php page with the message
    //     header("Location: category.php?message=" . urlencode($message));
    //     exit;
    // }
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
            <div>
                <h1>Users</h1>

                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </nav>
            </div>
            <div class="text-center p-2">
                <img src="https://otp799999.000webhostapp.com/frontend/image/The-search.png" alt="" style="width:90px !important;height:60px !important" class="text-center">
            </div>

        </div><!-- End Page Title -->

        <section>
            <div class="card">
                <div class="card-header d-flex" style="background-color: hwb(0 90% 7%);">
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
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Status</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serialNumber = 1;

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $serialNumber++; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td>
                                        <?php
                                        $status = $row['status'];
                                        $badgeClass = '';

                                        if ($status == 'Active') {
                                            $badgeClass = 'bg-success';
                                        } elseif ($status == 'Pending') {
                                            $badgeClass = 'bg-primary';
                                        } elseif ($status == 'Inactive') {
                                            $badgeClass = 'bg-danger';
                                        }

                                        echo '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
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
                                        <form action="category.php" method="POST" class="deleteForm">
                                            <input type="hidden" value="<?php echo $row['id']; ?>" name="categoryId">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" name="deleteData">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>


                                    </td>
                                    <!-- edit modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title text-center fw-bold" id="exampleModalLabel" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;">Edit User</h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="background-color: hsl(46, 90%, 47%);">

                                                    <form class="" action="http://localhost/Service.com-PHP/api/profile_update.php" method="POST">

                                                        <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
                                                        <input type="hidden" name="role" value="<?php echo $row['role'] ?>">
                                                        <input type="hidden" name="image" value="<?php echo $row['profile_image'] ?>">
                                                        <input type="hidden" name="verify" value="profileUpdate">

                                                        <div class="row p-5 bg-white rounded-4">
                                                            <div class="mx-auto col-md-12 col-lg-12 col-xl-12 text-center mb-3">
                                                                <img src="https://otp799999.000webhostapp.com/admin/public/profile/<?php echo $row['profile_image']; ?>" alt="" style="border-radius: 50%; width: 100px; height: 100px;">
                                                            </div>
                                                            <div class="col-md-6 col-lg-6 col-xl-6 py-2">
                                                                <label for="name" class="form-label">Name</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
                                                            </div>
                                                            <div class="col-md-6 col-lg-6 col-xl-6 py-2">
                                                                <label for="mobile" class="form-label">Mobile</label>
                                                                <input type="text" name="mobile" class="form-control" id="Mobile" value="<?php echo $row['mobile']; ?>">
                                                            </div>
                                                            <div class="col-12 py-2">
                                                                <label for="address" class="form-label">Address</label>
                                                                <input type="text" name="address" class="form-control" id="address" placeholder="" value="<?php echo $row['address']; ?>">
                                                            </div>
                                                            <?php if ($row['role'] == 'servicer') {
                                                            ?>
                                                                <div class="col-12 py-2">
                                                                    <label for="experience" class="form-label">Experience</label>
                                                                    <input type="text" name="experience" class="form-control" id="experience" placeholder="" value="<?php echo $row['experience']; ?>">
                                                                </div>

                                                                <div class="col-12 py-2">
                                                                    <label for="biography" class="form-label fw-bold">Biography</label>
                                                                    <textarea class="form-control" id="biography" name="biography" placeholder="Enter biography" rows="4"><?php echo $row['biography']; ?></textarea>
                                                                </div>

                                                            <?php } ?>



                                                            <label for="status" class="form-label mt-3 ">Status</label>
                                                            <div class="col-12 d-flex gap-3 mt-2 p-2 rounded-3" style="background-color: hwb(0 96% 3% / 0.684);">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="Active" <?php echo $row['status'] == 'Active' ? 'checked' : '' ?>>
                                                                    <label class="form-check-label fw-bold" for="flexRadioDefault1">
                                                                        Active
                                                                    </label>
                                                                </div>
                                                                <div class="form-check pl-3">
                                                                    <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="Pending" <?php echo $row['status'] == 'Pending' ? 'checked' : '' ?>>
                                                                    <label class="form-check-label fw-bold" for="flexRadioDefault2">
                                                                        Pending
                                                                    </label>
                                                                </div>
                                                                <div class="form-check pl-3">
                                                                    <input class="form-check-input" type="radio" name="status" id="flexRadioDefault3" value="Inactive" <?php echo $row['status'] == 'Inactive' ? 'checked' : '' ?>>
                                                                    <label class="form-check-label fw-bold" for="flexRadioDefault3">
                                                                        Inactive
                                                                    </label>
                                                                </div>
                                                            </div>




                                                        </div>







                                                </div>
                                                <div class="modal-footer mx-auto text-center">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" name="profileUpdate">Save Change</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end edit modal -->
                                    <!-- show modal -->
                                    <div class="modal fade" id="showModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title text-center fw-bold" id="exampleModalLabel" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;">View User Information</h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="background-color: hsl(46, 90%, 47%);">

                                                    <form class="" method="POST">



                                                        <div class="row p-5 bg-white rounded-4">
                                                            <div class="mx-auto col-md-12 col-lg-12 col-xl-12 text-center mb-3">
                                                                <img src="https://otp799999.000webhostapp.com/admin/public/profile/<?php echo $row['profile_image']; ?>" alt="" style="border-radius: 50%; width: 100px; height: 100px;">
                                                            </div>
                                                            <div class="col-md-6 col-lg-6 col-xl-6 py-2">
                                                                <label for="name" class="form-label fw-bold">Name</label>
                                                                <input type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" disabled>
                                                            </div>
                                                            <div class="col-md-6 col-lg-6 col-xl-6 py-2">
                                                                <label for="mobile" class="form-label fw-bold">Mobile</label>
                                                                <input type="text" class="form-control" id="Mobile" value="<?php echo $row['mobile']; ?>" disabled>
                                                            </div>
                                                            <div class="col-12 py-2">
                                                                <label for="address" class="form-label fw-bold">Address</label>
                                                                <input type="text" class="form-control" id="address" placeholder="" value="<?php echo $row['address']; ?>" disabled>
                                                            </div>
                                                            <?php if ($row['role'] == 'servicer') {
                                                            ?>
                                                                
                                                                
                                                                <div class="col-12 py-2">
                                                                    <label for="experience" class="form-label fw-bold">Experience</label>
                                                                    <input type="text" class="form-control" id="experience" placeholder="" value="<?php echo $row['experience']; ?>" disabled>
                                                                </div>
                                                                <div class="col-12 py-2">
                                                                    <label for="biography" class="form-label fw-bold">Biography</label>
                                                                    <textarea class="form-control" id="biography" name="biography" placeholder="Enter biography" rows="4" disabled><?php echo $row['biography']; ?></textarea>
                                                                </div>



                                                            <?php } ?>



                                                            <div class="col-12 py-2">
                                                                <label for="experience" class="form-label fw-bold">Status</label>
                                                                <input type="text" class="form-control" id="experience" placeholder="" value="<?php echo $row['status']; ?>" disabled>
                                                            </div>




                                                        </div>







                                                </div>
                                                <div class="modal-footer mx-auto text-center">

                                                    <button type="submit" class="btn btn-danger" name="editCategory">Close</button>
                                                </div>
                                                </form>
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
                                    <a class="page-link" href="?page=<?php echo $i; ?>&role=<?php echo $role; ?>"><?php echo $i; ?></a>
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

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <?php include_once "include/layout/js.php" ?>


</body>

</html>