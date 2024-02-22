<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Page Title</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Bootstrap JS, Popper.js, and jQuery (if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-4">
                <a href="../page/home.php" class="fw-bold text-decoration-none fs-4 ">
                    Easywork
                </a>
            </div>
            <div class="col-sm-8">
                <ul class="nav justify-content-end nav-pills">
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['username'])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bolder <?php echo ($currentPage == 'home') ? 'active' : ''; ?>" aria-current="page" href="../page/home.php">Home</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link fw-bolder dropdown-toggle <?php echo ($currentPage == 'plan') ? 'active' : ''; ?>" data-bs-toggle="dropdown" role="button" aria-expanded="false">Plan</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" <?php echo ($currentPage == 'plan') ? 'active' : ''; ?>" href="../page/plan.php">Plan</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bolder  <?php echo ($currentPage == 'member') ? 'active' : ''; ?>" href="../member/member_form.php?page=1">Members</a>
                        </li>

                        <li class="nav-item">

                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" style="padding-left: 10px;" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="data:image/jpeg;base64,<?= base64_encode($_SESSION["image_data"]) ?>" class="rounded-circle shadow-4" style="width: 50px; height: 50px; object-fit: cover; margin-top: -12px; " alt="Avatar" />
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <!-- Add dropdown menu items here -->
                                    <a class="dropdown-item" href="../member/member_detail.php?page=<?php echo $_SESSION['userId']; ?>">Profile</a>
                                    <a class="dropdown-item" href="#">Setting</a>
                                    <a class="dropdown-item" href="../auth/logout.php">Log out</a>
                                </div>
                            </div>

                        <?php } else {
                        ?>
                            <a class="nav-link fw-bolder" href="../auth/login.php">Login</a>

                        <?php } ?>
                        </li>

                </ul>

            </div>
            <hr class="my-4">
        </div>
    </div>
</body>

</html>