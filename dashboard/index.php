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
  <style>
    .content {
      display: flex;
      justify-content: center;
      padding: 20px 0;
    }

    .chart {
      max-width: 800px;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="content">
    <div class="chart">
      <canvas id="myChart"></canvas>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <!-- valorant -->
      <div class="col-xl-6 col-lg-6">
        <div class="card l-bg-cherry">
          <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fa-solid fa-gamepad"></i></div>
            <div class="mb-4">
              <h5 class="card-title mb-0">Valorant</h5>
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
              <!-- modal -->
              <div class="col-4">
                <button type="button" class="btn btn-primary btn-md mr-2 float-end" data-bs-toggle="modal" data-bs-target="#myModal1">
                  <i class="fa-solid fa-circle-info"></i> Detail
                </button>
              </div>
            </div>
            <div class="progress mt-1 " data-height="8" style="height: 8px;">
              <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- PUBG -->
      <div class="col-xl-6 col-lg-6">
        <div class="card l-bg-blue-dark">
          <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fa-solid fa-gamepad"></i></div>
            <div class="mb-4">
              <h5 class="card-title mb-0">PUBG Mobile</h5>
            </div>
            <div class="row align-items-center mb-2 d-flex">
              <div class="col-4">
                <h2 class="d-flex align-items-center mb-0">
                  15.07k
                </h2>
              </div>
              <div class="col-2 text-right">
                <span>9.23% <i class="fa fa-arrow-up"></i></span>
              </div>
              <!-- modal -->
              <div class="col-4">
                <button type="button" class="btn btn-primary btn-md mr-2 float-end" data-bs-toggle="modal" data-bs-target="#myModal1">
                  <i class="fa-solid fa-circle-info"></i> Detail
                </button>
              </div>
            </div>
            <div class="progress mt-1 " data-height="8" style="height: 8px;">
              <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- Dota -->
      <div class="col-xl-6 col-lg-6">
        <div class="card l-bg-blue-dark">
          <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fa-solid fa-gamepad"></i></div>
            <div class="mb-4">
              <h5 class="card-title mb-0">Dota</h5>
            </div>
            <div class="row align-items-center mb-2 d-flex">
              <div class="col-4">
                <h2 class="d-flex align-items-center mb-0">
                  15.07k
                </h2>
              </div>
              <div class="col-2 text-right">
                <span>9.23% <i class="fa fa-arrow-up"></i></span>
              </div>
              <!-- modal -->
              <div class="col-4">
                <button type="button" class="btn btn-primary btn-md mr-2 float-end" data-bs-toggle="modal" data-bs-target="#myModal1">
                  <i class="fa-solid fa-circle-info"></i> Detail
                </button>
              </div>
            </div>
            <div class="progress mt-1 " data-height="8" style="height: 8px;">
              <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- mobile legend -->
      <div class="col-xl-6 col-lg-6">
        <div class="card l-bg-blue-dark">
          <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fa-solid fa-gamepad"></i></div>
            <div class="mb-4 col8">
              <h5 class="card-title mb-0">Mobile Legends</h5>
            </div>
            <div class="row align-items-center mb-2 d-flex">
              <div class="col-4">
                <h2 class="d-flex align-items-center mb-0">
                  15.07k
                </h2>
              </div>
              <div class="col-2 text-center">
                <span>9.23% <i class="fa fa-arrow-up"></i></span>
              </div>
              <!-- modal -->
              <div class="col-4">
                <button type="button" class="btn btn-primary btn-md mr-2 float-end" data-bs-toggle="modal" data-bs-target="#myModal1">
                  <i class="fa-solid fa-circle-info"></i> Detail
                </button>
              </div>
            </div>
            <div class="progress mt-1 " data-height="8" style="height: 8px;">
              <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="myModal1" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title"><i class="fa-solid fa-gamepad"></i> Detail Game</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
              <div class="modal-body">
                <table class="table table-striped bordered">
                  <!-- sesuaikan dengan button yang ditekan/ ambil dari database -->
                  <tr>
                    <td>Game</td>
                    <td>Valorant</td>
                  </tr>
                  <tr>
                    <td>Description</td>
                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique excepturi mollitia nesciunt asperiores vero labore, facere consectetur esse rerum ipsam natus minus minima aliquid corporis eveniet? Natus ipsam asperiores totam.</td>
                  </tr>
                  <tr>
                    <td>Image</td>
                    <td>image.png</td>
                  </tr>
                </table>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-warning" name="edit"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    const ctx = document.getElementById("myChart");

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