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
    $query = "SELECT
    users.name,
    users.mobile,
    users.role,
    users.status,
    users.created_at,
    servicer_profiles.*,
    categories.id AS categoryId,
    categories.title AS category_title,
    categories.banner_image AS category_banner,
    IFNULL(ROUND(AVG(reviews.rating_point), 2), 0) AS average_rating
    FROM
        users
    JOIN
        servicer_profiles ON users.id = servicer_profiles.user_id
    LEFT JOIN
        categories ON servicer_profiles.category_id = categories.id
    LEFT JOIN
        reviews ON servicer_profiles.user_id = reviews.servicer_id
    GROUP BY
        users.id,
        servicer_profiles.id,
        category_title,
        category_banner
    ORDER BY
        servicer_profiles.id DESC
    LIMIT $items_per_page OFFSET $offset;
";
} else {

    $query = "SELECT users.*, user_profiles.*
    FROM users
    JOIN user_profiles ON users.id = user_profiles.user_id
    ORDER BY user_profiles.created_at DESC
    LIMIT $items_per_page OFFSET $offset;
    ";
}

// Prepare the SQL query with the dynamically selected table and JOIN condition

$result = mysqli_query($connection, $query);

// Calculate total rows for pagination
$total_rows_query = "SELECT COUNT(*) AS total FROM users WHERE role = '$role'";
$total_rows_result = mysqli_query($connection, $total_rows_query);
$total_rows = mysqli_fetch_assoc($total_rows_result)['total'];
$total_pages = ceil($total_rows / $items_per_page);

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
            <option value="Pending">Pending</option>
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
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
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
                                        <form action="user_crud.php" method="POST" class="deleteForm">
                                            <input type="hidden" value="<?php echo $row['user_id']; ?>" name="user_id">
                                            <input type="hidden" value="<?php echo $row['role']; ?>" name="role">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" name="deleteUser">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>


                                    </td>
                                    <!-- edit modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: rgb(223, 226, 217);">
                                                    <h3 class="modal-title text-center fw-bold mx-auto" id="exampleModalLabel" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;">
                                                        Edit <?php echo ucfirst($row['role']); ?> Profile
                                                    </h3>
                                                    <i class="fa-solid fa-user-pen fa-fade fa-2xl"></i>

                                                </div>
                                                <div class="modal-body" style="background-color: hwb(207 4% 12%);">

                                                    <form class="" action="user_crud.php" method="POST">

                                                        <input type="hidden" name="id" value="<?php echo $row['user_id'] ?>">
                                                        <input type="hidden" name="role" value="<?php echo $row['role'] ?>">
                                                        <input type="hidden" name="image" value="<?php echo $row['profile_image'] ?>">
                                                        <input type="hidden" name="verify" value="profileUpdate">
                                                        <input type="hidden" name="role" value="<?php echo $row['role'] ?>">

                                                        <div class="row p-5 bg-white rounded-4">
                                                            <?php
                                                            if ($row['role'] == 'servicer') {


                                                                $rating = $row['average_rating']; // Assuming $row['average_rating'] contains the rating point (e.g., 4.5)

                                                                // Check if the rating is greater than 0 and not null
                                                                if ($rating !== null && $rating > 0) {
                                                                    $fullStars = floor($rating); // Get the number of full stars (e.g., 4)
                                                                    $halfStar = $rating - $fullStars; // Get the fraction part (e.g., 0.5 for half a star)
                                                                } else {
                                                                    // Set default values when rating is null or 0
                                                                    $fullStars = 0;
                                                                    $halfStar = 0;
                                                                }
                                                            }
                                                            ?>

                                                            <div class="mx-auto col-md-12 col-lg-12 col-xl-12 text-center mb-3">
                                                                <div style="display: inline-block; vertical-align: top;">
                                                                    <img src="https://otp799999.000webhostapp.com/admin/public/profile/<?php echo $row['profile_image']; ?>" alt="" style="border-radius: 50%; width: 100px; height: 100px;">
                                                                    <br>
                                                                    <span class="badge rounded-pill bg-success"><?php echo $row['role'] ?></span>
                                                                </div>
                                                                <?php if ($row['role'] == 'servicer') : ?>
                                                                    <div>
                                                                        <?php if ($rating !== null && $rating > 0) : ?>
                                                                            <p>Rating: <strong><?php echo $row['average_rating'] ?></strong>
                                                                                <?php
                                                                                // Display full stars
                                                                                for ($i = 0; $i < $fullStars; $i++) {
                                                                                    echo '<i class="fa-solid fa-star text-warning"></i> ';
                                                                                }

                                                                                // Display half-star if applicable
                                                                                if ($halfStar >= 0.5) {
                                                                                    echo '<i class="fa-solid fa-star-half-stroke text-warning"></i> ';
                                                                                }
                                                                                ?>
                                                                            </p>
                                                                        <?php else : ?>
                                                                            <p>No Rating Available</p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <h6 class="fw-bold text-primary ">Created Date: <?php echo $row['created_at'] ?></h6>

                                                            <div class="col-md-6 col-lg-6 col-xl-6 py-2">
                                                                <label for="name" class="form-label fw-bold">Name</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
                                                            </div>
                                                            <div class="col-md-6 col-lg-6 col-xl-6 py-2">
                                                                <label for="mobile" class="form-label fw-bold">Mobile</label>
                                                                <input type="text" name="mobile" class="form-control" id="Mobile" value="<?php echo $row['mobile']; ?>">
                                                            </div>
                                                            <div class="col-12 py-2">
                                                                <label for="address" class="form-label fw-bold">Address</label>
                                                                <input type="text" name="address" class="form-control" id="address" placeholder="" value="<?php echo $row['address']; ?>">
                                                            </div>
                                                            <?php if ($row['role'] == 'servicer') {
                                                            ?>


                                                                <div class="col-6 py-2">
                                                                    <label for="experience" class="form-label fw-bold">Service Category</label>
                                                                    <select class="form-select" aria-label="Default select example" name="category">
                                                                        <option selected>Open this select menu</option>
                                                                        <?php
                                                                        $categoryQuery = "SELECT * FROM categories ORDER BY id DESC";
                                                                        $categories = mysqli_query($connection, $categoryQuery);

                                                                        while ($category = mysqli_fetch_assoc($categories)) { ?>
                                                                            <option value="<?php echo $category['title'] ?>" <?php echo $category['id'] == $row['category_id'] ? 'selected' : ''; ?>><?php echo $category['title'] ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                </div>
                                                                <div class="col-6 py-2">
                                                                    <label for="experience" class="form-label fw-bold">Experience</label>
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
                                                <div class="modal-header" style="background-color: hsla(207, 88%, 91%, 0.841);">
                                                    <h3 class="modal-title text-center fw-bold mx-auto" id="exampleModalLabel" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;">
                                                        View <?php echo ucfirst($row['role']); ?> Profile
                                                    </h3>
                                                    <i class="fa-solid fa-users-viewfinder fa-fade fa-2xl"></i>

                                                </div>
                                                <div class="modal-body" style="background-color: hwb(196 5% 11%);">

                                                    <form class="" method="POST">



                                                        <div class="row p-5 bg-white rounded-4">

                                                            <?php
                                                            if ($row['role'] == 'servicer') {


                                                                $rating = $row['average_rating']; // Assuming $row['average_rating'] contains the rating point (e.g., 4.5)

                                                                // Check if the rating is greater than 0 and not null
                                                                if ($rating !== null && $rating > 0) {
                                                                    $fullStars = floor($rating); // Get the number of full stars (e.g., 4)
                                                                    $halfStar = $rating - $fullStars; // Get the fraction part (e.g., 0.5 for half a star)
                                                                } else {
                                                                    // Set default values when rating is null or 0
                                                                    $fullStars = 0;
                                                                    $halfStar = 0;
                                                                }
                                                            }
                                                            ?>

                                                            <div class="mx-auto col-md-12 col-lg-12 col-xl-12 text-center mb-3">
                                                                <div style="display: inline-block; vertical-align: top;">
                                                                    <img src="https://otp799999.000webhostapp.com/admin/public/profile/<?php echo $row['profile_image']; ?>" alt="" style="border-radius: 50%; width: 100px; height: 100px;">
                                                                    <br>
                                                                    <span class="badge rounded-pill bg-success"><?php echo $row['role'] ?></span>
                                                                </div>
                                                                <div style="">
                                                                    <?php if ($row['role'] == 'servicer') : ?>
                                                                        <div>
                                                                            <?php if ($rating !== null && $rating > 0) : ?>
                                                                                <p>Rating: <strong><?php echo $row['average_rating'] ?></strong>
                                                                                    <?php
                                                                                    // Display full stars
                                                                                    for ($i = 0; $i < $fullStars; $i++) {
                                                                                        echo '<i class="fa-solid fa-star text-warning"></i> ';
                                                                                    }

                                                                                    // Display half-star if applicable
                                                                                    if ($halfStar >= 0.5) {
                                                                                        echo '<i class="fa-solid fa-star-half-stroke text-warning"></i> ';
                                                                                    }
                                                                                    ?>
                                                                                </p>
                                                                            <?php else : ?>
                                                                                <p>No Rating Available</p>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                             <h6 class="fw-bold text-primary ">Created Date: <?php echo $row['created_at'] ?></h6>


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


                                                                <div class="col-6 py-2">
                                                                    <label for="experience" class="form-label fw-bold">Experience</label>
                                                                    <input type="text" class="form-control" id="experience" placeholder="" value="<?php echo $row['experience']; ?>" disabled>
                                                                </div>
                                                                <div class="col-6 py-2">
                                                                    <label for="experience" class="form-label fw-bold">Service Category</label>
                                                                    <input type="text" class="form-control" id="experience" placeholder="" value="<?php echo $row['category_title']; ?>" disabled>
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