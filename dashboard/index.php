<?php
require __DIR__ . '/../function/check_access.php';
require 'function/input.php';

$sql = "SELECT * FROM game";
$result = $conn->query($sql);

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $game = $_POST['game'];
  $description = $_POST['description'];

  // Proses upload gambar
  $target_dir = "asset/game/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  if ($check !== false && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $image = $target_file;
  } else {
    $image = ""; // Atau bisa diisi dengan path default atau error handling
  }

  $gid = saveGame($conn, $game, $description, $image);

  if ($gid) {
    echo "<script>
    alert('Game berhasil ditambahkan!');
    window.location.href = 'index.php?page=game/edit&gid=$gid';
    </script>";
  } else {
    echo "<script>
    alert('Terjadi kesalahan saat menambahkan game. GID: $gid');
    </script>";
    error_log("Failed to get GID after insert.");
  }
}
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
  <link rel="stylesheet" href="css/adminpage.css">
</head>

<body>
  <div class="container containbg my-4 p-3">
    <div class="content">
      <div class="chart">
        <canvas id="myChart" style="background-color: white;"></canvas>
      </div>
    </div>
    <div class="row" id="dataContainer">
      <!-- Game -->
      <?php
      $data_count = 0;
      if ($result->num_rows > 0) :
        while ($row = $result->fetch_assoc()) :
          $data_count++;
          if ($data_count <= 4) : ?>
            <div class="col-xl-6 col-lg-6 my-2">
              <div class="card">
                <div class="card-statistic-3 p-4">
                  <div class="card-icon card-icon-large"><i class="fa-solid fa-gamepad"></i></div>
                  <div class="mb-4">
                    <h5 class="card-title mb-0"><?= $row["game"] ?></h5>
                  </div>
                  <div class="row align-items-center mb-2 d-flex">
                    <div class="col-4">
                      <h2 class="d-flex align-items-center mb-0">
                        3,243
                      </h2>
                    </div>
                    <div class="col-2 text-right">
                      <span>12.5% <i class="fa fa-arrow-up"></i></span>
                    </div>
                    <div class="col-4">
                      <a href="index.php?page=game&gid=<?= $row['gid'] ?>" class="btn btn-primary btn-md mr-2 float-end"><i class="fa-solid fa-circle-info"></i> Detail</a>
                    </div>
                  </div>
                  <div class="progress mt-1" data-height="8" style="height: 8px;">
                    <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                  </div>
                </div>
              </div>
            </div>
      <?php endif;
        endwhile;
      endif;
      ?>
    </div>

    <?php if ($result->num_rows > 4) : ?>
      <div class="row">
        <div class="collapse mt-2 col-12" id="collapseExample">
          <div class="row" id="extraDataContainer">
            <?php
            $result->data_seek(4); // Mengatur pointer ke data kelima
            while ($row = $result->fetch_assoc()) : ?>
              <div class="col-xl-6 col-lg-6 my-2">
                <div class="card">
                  <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fa-solid fa-gamepad"></i></div>
                    <div class="mb-4">
                      <h5 class="card-title mb-0"><?= $row["game"] ?></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                      <div class="col-4">
                        <h2 class="d-flex align-items-center mb-0">
                          3,243
                        </h2>
                      </div>
                      <div class="col-2 text-right">
                        <span>12.5% <i class="fa fa-arrow-up"></i></span>
                      </div>
                      <div class="col-4">
                        <a href="index.php?page=game&gid=<?= $row['gid'] ?>" class="btn btn-primary btn-md mr-2 float-end"><i class="fa-solid fa-circle-info"></i> Detail</a>
                      </div>
                    </div>
                    <div class="progress mt-1" data-height="8" style="height: 8px;">
                      <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
      <div class="col-12 text-center show-more-container">
        <hr class="hr-text" data-content="Show More">
      </div>
    <?php endif; ?>
    <br>

    <!-- modal Add game -->
    <div class="modal fade" id="addgame" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add Game</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="uploadForm" class="container" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <table class="table table-striped bordered">
                <!-- sesuaikan dengan button yang ditekan/ ambil dari database -->
                <tr>
                  <td>Game</td>
                  <td><input type="text" placeholder="Nama Game" name="game" id="game"></td>
                </tr>
                <tr>
                  <td>Description</td>
                  <td><textarea name="description" id="description" placeholder="Deskripsi" maxlength="500"></textarea></td>
                </tr>
                <tr>
                  <td>Image</td>
                  <td><button class="select-image btn btn-primary">Select Image</button></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <input type="file" name='image' id="image" accept=".jpg" hidden required>
                    <div class="img-area" data-img="">
                      <i class='bx bxs-cloud-upload icon'></i>
                      <h3>Upload Image</h3>
                      <p>Image size must be less than <span>20MB</span></p>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
              <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
  <button type="button" class="tombol" data-bs-toggle="modal" data-bs-target="#addgame">
    <i class="fa-solid fa-plus"></i> Add more game
  </button>
  <div class="text-center pb-3 text-light">
    <p>Copyright © 2036 Menosa Store. All rights reserved.</p>
  </div>
  <script src="js/modal.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    // fungsi show more
    $(document).ready(function() {
      $('.show-more-container').click(function() {
        var $this = $(this);
        $('#collapseExample').collapse('toggle');
        if ($this.find('.hr-text').attr('data-content') === 'Show More') {
          $this.find('.hr-text').attr('data-content', 'Show Less');
        } else {
          $this.find('.hr-text').attr('data-content', 'Show More');
        }
      });
    });
    const ctx = document.getElementById("myChart");

    // chart
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["January", "Februay", "March", "April", "May", "June"],
        datasets: [{
          label: "Monthly Revenue",
          //   cokot ti database berdasarkan bulan
          data: [2400000, 1440000, 3120000, 1500000, 705000, 0],
          borderWidth: 1,
        }, ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  </script>
</body>

</html>