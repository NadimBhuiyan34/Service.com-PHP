<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-white" style="position: fixed;top:0;z-index:1000;width:100%">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="https://img.freepik.com/free-icon/diamond_318-195445.jpg" alt="" style="width:50px;height:50px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link fw-bold" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-bold" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-bold" href="#">Services</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-bold" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item fw-bold" href="#">About</a></li>
              <li><a class="dropdown-item fw-bold" href="#">Contact</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item fw-bold" href="#">Gellary</a></li>
            </ul>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <!-- if is login -->
          <?php
          if (isset($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0) {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcU50X1UOeDaphmUyD6T8ROKs-HjeirpOoapiWbC9cLAqewFy1gthrgUTB9E7nKjRwOVk&usqp=CAU" alt="" class="rounded-circle" style="width:40px;height:40px">
              </a>
              <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                <li class="dropdown-item"><strong>Nadim Bhuiyan</strong></li>
                <hr>
                <li><a class="dropdown-item fw-bold" href="#">My Profile</a></li>
                <li><a class="dropdown-item fw-bold" href="#">Settings</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <form action="logout.php" method="POST">

                    <button class="dropdown-item fw-bold" type="submit">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          <?php
          } else {
          ?>
            <!-- if is not login -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-bold" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registration <i class="fa-solid fa-user-plus"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Survicer</a></li>
              <li><a class="dropdown-item fw-bold" href="#">Users</a></li>
               
              
            </ul>
          </li>
            <!-- <li class="nav-item">
              <a class="nav-link fw-bold" href="">Registration <i class="fa-solid fa-user-plus"></i></a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login <i class="fa-solid fa-right-to-bracket"></i></a>
            </li>
          <?php
          }
          ?>
        </ul>

      </div>
    </div>
  </nav>
</header>
<!-- modal include -->
<?php include("includes/modals/login.php") ?>
<?php include("includes/modals/register.php") ?>

<!-- ajax include -->
<?php include("includes/ajax/login.php") ?>


<!-- <x-auth.modal.login/>
 <x-auth.ajax.login/> -->