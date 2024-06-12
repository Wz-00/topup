<?php
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'guest'; // default role jika belum login atau tidak ada role yang terdefinisi
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menosa Store</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        .mySlides {
            display: none;
            padding-top: 20px;
        }

        .w3-left,
        .w3-right,
        .w3-badge {
            cursor: pointer
        }

        .w3-badge {
            height: 13px;
            width: 13px;
            padding: 0
        }

        body {
            background-color: #363062;
        }

        .row {
            padding-bottom: 10px;
        }

        .waves {
            display: grid;
            grid-template-columns: auto;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .w3-display-container {
            padding-top: 10vh;
        }

        .w3-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            padding: 10px 0;
        }

        /* .mySlides {display:none; padding-top:20px;}
        .w3-left, .w3-right, .w3-badge {cursor:pointer}
        .w3-badge {height:13px;width:13px;padding:0}
        body {
                background-color: #363062;
            }
        .row {
            padding-bottom: 10px;
        }
        .waves {
            display: grid;
            grid-template-columns: auto;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .w3-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            padding: 10px 0;
        }

        .footer{
            background-color: #F5E8C7;
        }
        .fkiri img {
            height: 90px;
        } */
        .footer {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary bg-light">

        <a href='index.php' class='navbar-brand'>
            <img src="asset/logo.jpg" class="navbar-logo" alt="logo">
            <b>MenosaStore</b>
        </a>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <?php if ($role != 'admin') : ?>
                <li class='nav-item'><a href="" class="nav-link">Cek Pesanan</a></li>
            <?php else : ?>
                <li class='nav-item'><a href="index.php?page=revenue" class="nav-link">Revenue</a></li>
            <?php endif; ?>
        </ul>
        <?php if (isset($_SESSION['username'])) { ?>
            <div class="profile-dropdown">
                <div onclick="toggle()" class="profile-dropdown-btn">
                    <span>
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo $_SESSION['username']; // Tampilkan nama pengguna dari data pengguna
                        }
                        ?>

                        <i class="fa-solid fa-angle-down"></i>
                    </span>
                </div>

                <ul class="profile-dropdown-list">
                    <li class="profile-dropdown-list-item">
                        <a href="index.php?page=profile">
                            <i class="fa-regular fa-user"></i>
                            Profile
                        </a>
                    </li>

                    <li class="profile-dropdown-list-item open-modal-btn" id="openModalBtn">
                        <a href="#">
                            <i class="fa-regular fa-bell"></i>
                            Notification
                        </a>
                    </li>

                    <li class="profile-dropdown-list-item">
                        <a href="">
                            <i class="fa-regular fa-circle-question"></i>
                            Help & Support
                        </a>
                    </li>
                    <hr />

                    <li class="profile-dropdown-list-item">
                        <a href="logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Log out
                        </a>
                    </li>
                </ul>
            </div>
        <?php } else {
            echo '<a href="login.php" class="guest">Login</a>
               ';
        }
        ?>
    </nav>
    <script>
        // dropdown profile
        let profileDropdownList = document.querySelector(".profile-dropdown-list");
        let btn = document.querySelector(".profile-dropdown-btn");

        let classList = profileDropdownList.classList;

        const toggle = () => classList.toggle("active");

        window.addEventListener("click", function(e) {
            if (!btn.contains(e.target)) classList.remove("active");
        });
    </script>