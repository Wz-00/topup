<?php
require 'function/conn.php';
// Mengambil data dari tabel game
$sql = "SELECT gid, game, description, image FROM game";
$result = $conn->query($sql);

$ban = "SELECT * FROM banner";
$bn = $conn->query($ban);
?>

<!-- slideshow -->
<link rel="stylesheet" href="css/body.css">
<div class="container my-4 p-4 containbg">
    <div class="banner">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">
                <?php if ($bn->num_rows > 0) : ?>
                    <?php while ($row = $bn->fetch_assoc()) : ?>
                        <?php if ($row['bid'] == 'B001') : ?>
                            <div class="carousel-item active">
                            <?php else : ?>
                                <div class="carousel-item">
                                <?php endif; ?>
                                <a href="index.php?page=transaksi&gid=<?= $row['gid']; ?>">
                                    <img src="<?= $row['banner']; ?>" class="rounded mx-auto d-block w-100" alt="" />
                                </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            <div class="carousel-indicators">
                            <?php
                                $i = 0;
                                $y = 1;
                                if ($resban = mysqli_query($conn, $ban)) :

                                    // Return the number of rows in resban set
                                    $rowcount = mysqli_num_rows($resban);

                                    while ($i < $rowcount) :
                                        if ($i == 0) :
                                            echo '<button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="' . $i . '" class="active" aria-current="true" aria-label="Slide ' . $y . '"></button>';
                                        else :
                                            echo '<button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="' . $i . '" aria-label="Slide' . $y . '"></button>';
                                        endif;
                                        $i++;
                                        $y++;
                                    endwhile;
                                endif;
                                ?>
                            </div>
            </div>
        </div>
        <div class="game my-3 p-3">
            <h1 style="font-size:4vw; color: white; font-family: fantasy; text-align: center;">Pick Your Game</h1>

            <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="col">
                            <div class="card my-3">
                                <a href="index.php?page=transaksi&gid=<?= $row['gid'] ?>">
                                    <img class="card-img-top p-2" src="<?= $row["image"] ?>" alt="Card image cap" style="height: 200px; object-fit:cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-light" style="text-align: center; text-decoration: none;">
                                            <?= $row["game"] ?></h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>