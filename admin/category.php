<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Profile</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include_once "include/css.php" ?>

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
    <?php include_once "include/topbar.php" ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include_once "include/sidebar.php" ?>
    <!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Category</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
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
                                <th>Category Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                 
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>fd</td>
                                <td>fdf</td>
                                <td>df</td>
                                <td><span class="badge bg-success">Approved</span></td>
                                 
                                <!-- Action row -->
                                <td class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#showModal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <form action="" method="POST">
                                        <input type="hidden" value="1">
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
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" accept-charset="UTF-8">
                                                    <div class="form-group">
                                                        <label for="question">Question:</label>
                                                        <textarea class="form-control" id="question" name="question" rows="3">dfdffd</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="answerA">Answer A:</label>
                                                        <input type="text" class="form-control" id="answerA" name="answerA" value="dgsds">
                                                    </div>

                                                    <input type="hidden" name="quid" value="dfjghjdfks">

                                                    <div class="form-group">
                                                        <label for="answerB">Answer B:</label>
                                                        <input type="text" class="form-control" id="answerB" name="answerB" value="dsjds">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="answerC">Answer C:</label>
                                                        <input type="text" class="form-control" id="answerC" name="answerC" value="sdghsd">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="answerD">Answer D:</label>
                                                        <input type="text" class="form-control" id="answerD" name="answerD" value="sdhjds">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="correctAnswer">Correct Answer:</label>
                                                        <select class="form-control" id="correctAnswer" name="correctAnswer">
                                                            <option value="" class="disabled">Select Correct Answer</option>
                                                            <option value="1" selected>A</option>
                                                            <option value="2">B</option>
                                                            <option value="3">C</option>
                                                            <option value="4">D</option>
                                                        </select>
                                                    </div>



                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary btn-sm" name="editQuestion">Save Change <i class="fa-solid fa-paper-plane"></i></button>
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

                        </tbody>
                    </table>

                </div>
            </div>
        </section>
        <?php include_once "include/modal/category.php" ?>
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <?php include_once "include/footer.php" ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <?php include_once "include/js.php" ?>


</body>

</html>