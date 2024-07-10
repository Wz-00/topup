<?php
require 'function/conn.php';
$ban = "SELECT * FROM banner";
$bn = $conn->query($ban);
?>
<link rel="stylesheet" href="css/promo.css">

<div class="container my-4 ">
<div class="konten mx-auto p-3">
    <h3 class="text-center text-light">Your Banner</h3>
    <div class="banner">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">
                <?php
                if ($bn->num_rows > 0) :
                    while ($row = $bn->fetch_assoc()) :
                        if ($row['bid'] == 'B001') : ?>
                            <div class="carousel-item active">
                            <?php else : ?>
                                <div class="carousel-item">
                                <?php endif; ?>
                                <a href="index.php?page=promo/edit&bid=<?= $row['bid']; ?>">
                                    <img src="<?= $row['banner']; ?>" class="rounded mx-auto d-block w-100" alt="" />
                                </a>
                                </div>
                        <?php
                    endwhile;
                endif;?>
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
                                if ($result = mysqli_query($conn, $ban)) :

                                    // Return the number of rows in result set
                                    $rowcount = mysqli_num_rows($result);

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
        <div class="text-center tombol"><button data-bs-toggle="modal" data-bs-target="#addbanner">Tambah Banner</button></div>
    </div>
    </div>
    <!-- modal Add Banner -->
    <div class="modal fade" id="addbanner" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add Banner</h5>
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
    <div class="text-center pb-3 text-light">
    <p>Copyright © 2036 Menosa Store. All rights reserved.</p>
  </div>
  <script src="js/modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>

    </html>