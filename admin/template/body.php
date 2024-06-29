<?php
require 'function/conn.php';
// Mengambil data dari tabel game
$sql = "SELECT gid, game, description, image FROM game";
$result = $conn->query($sql);
?>
?>

<!-- slideshow -->
<link rel="stylesheet" href="css/content.css">
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner mt-4">
        <div class="carousel-item active">
            <a href="index.php?page=transaksi">
                <img src="asset/banner/promo5.jpg" class="rounded mx-auto d-block w-75" alt="" />
            </a>
        </div>
        <div class="carousel-item">
            <a href="index.php?page=transaksi">
                <img src="asset/banner/promo6.jpg" class="rounded mx-auto d-block w-75" alt="">
            </a>
        </div>
        <div class="carousel-item">
            <a href="index.php?page=transaksi">
                <img src="asset/banner/promo7.jpg" class="rounded mx-auto d-block w-75" alt="">
            </a>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- wave -->
<div class="waves" style="margin-bottom: -3px; z-index: 99;">
    <svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 250" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0">
                <stop stop-color="rgba(67, 85, 133, 1)" offset="0%"></stop>
                <stop stop-color="rgba(67, 85, 133, 1)" offset="100%"></stop>
            </linearGradient>
        </defs>
        <path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,25L34.3,37.5C68.6,50,137,75,206,83.3C274.3,92,343,83,411,104.2C480,125,549,175,617,183.3C685.7,192,754,158,823,150C891.4,142,960,158,1029,175C1097.1,192,1166,208,1234,200C1302.9,192,1371,158,1440,141.7C1508.6,125,1577,125,1646,112.5C1714.3,100,1783,75,1851,75C1920,75,1989,100,2057,120.8C2125.7,142,2194,158,2263,175C2331.4,192,2400,208,2469,208.3C2537.1,208,2606,192,2674,170.8C2742.9,150,2811,125,2880,108.3C2948.6,92,3017,83,3086,91.7C3154.3,100,3223,125,3291,116.7C3360,108,3429,67,3497,50C3565.7,33,3634,42,3703,54.2C3771.4,67,3840,83,3909,79.2C3977.1,75,4046,50,4114,33.3C4182.9,17,4251,8,4320,16.7C4388.6,25,4457,50,4526,87.5C4594.3,125,4663,175,4731,187.5C4800,200,4869,175,4903,162.5L4937.1,150L4937.1,250L4902.9,250C4868.6,250,4800,250,4731,250C4662.9,250,4594,250,4526,250C4457.1,250,4389,250,4320,250C4251.4,250,4183,250,4114,250C4045.7,250,3977,250,3909,250C3840,250,3771,250,3703,250C3634.3,250,3566,250,3497,250C3428.6,250,3360,250,3291,250C3222.9,250,3154,250,3086,250C3017.1,250,2949,250,2880,250C2811.4,250,2743,250,2674,250C2605.7,250,2537,250,2469,250C2400,250,2331,250,2263,250C2194.3,250,2126,250,2057,250C1988.6,250,1920,250,1851,250C1782.9,250,1714,250,1646,250C1577.1,250,1509,250,1440,250C1371.4,250,1303,250,1234,250C1165.7,250,1097,250,1029,250C960,250,891,250,823,250C754.3,250,686,250,617,250C548.6,250,480,250,411,250C342.9,250,274,250,206,250C137.1,250,69,250,34,250L0,250Z"></path>
    </svg>
</div>
<!-- content -->
<div style="background-color: #435585;">
    <h1 style="font-size:4vw; color: white; font-family: fantasy; text-align: center;">Pick Your Game</h1>
    <div class="container">
        <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="col">
                        <div class="card " style="width: 12.625rem;">
                            <a href="index.php?page=transaksi&gid=<?= $row['gid'] ?>">
                                <img class="card-img-top" src="<?= $row["image"] ?>" alt="Card image cap" style="height: 200px; object-fit:cover;">
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: center; text-decoration: none;"><?= $row["game"] ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>