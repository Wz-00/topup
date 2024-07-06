<?php
require "function/conn.php";
// $game = isset($_GET['gid']) ? $_GET['gid'] : '';
$gid = $_GET['gid'];
$game = query("SELECT * FROM game where gid = '$gid'")[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="css/game.css">
</head>

<body>
    <div class="container">
        <div class="kard my-3 p-4">
            <div class="kard-body">
                <h3 class="text-center"><?= $game['game'] ?></h3>
                <div class="grid" style="--bs-columns: 3;">
                    <div class="g-col-3 g-col-md-1">
                        <div class="kiri">
                            <img src="<?= $game['image'] ?>" alt="" class="img-fluid GameBanner">
                            <p class="p-3"><?= $game['description'] ?></p>
                        </div>
                    </div>
                    <div class="g-col-3 g-col-md-2 text-center">
                        <div class="canva mb-3">
                            <h3 class="p-2">Total Profit</h3>
                            <canvas id="myChart" style="width: 100%; background-color:white; border-radius:15px"></canvas>
                        </div>

                        <div class="item my-4 p-4">
                            <h3>ITEM</h3>
                            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                <?php
                                $item = "SELECT * FROM item WHERE gid = '$gid'";
                                $iitem = $conn->query($item);
                                if ($iitem) :
                                    while ($row2 = $iitem->fetch_assoc()) :
                                ?>
                                        <div class="col">
                                            <div class="kartu p-1 my-1">
                                                <img src="<?= $row2['icon'] ?>" alt="" class="img-fluid mx-auto my-1" style="max-height: 50px;"><br>
                                                <b><?= $row2['item'] ?></b>
                                                <p><?= 'Rp.' . number_format($row2['price'], 2, ",", ".") ?></p>
                                            </div>
                                        </div>
                                <?php
                                    endwhile;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="edit"><button>Edit This Game</button></span>
        <div class="text-center pb-3 text-light">
            <p>Copyright © 2036 Menosa Store. All rights reserved.</p>
        </div>
    </div>
    <script>
        const xValues = ["Jan", "Feb", "Mar", "Apr", "May", "June"];
        const yValues = [789000, 1232500, 4999000, 991500, 1953550, 10500500];

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: yValues,
                }, ],
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 700000,
                            max: 12000000
                        }
                    }],
                },
            },
        });
    </script>
</body>

</html>