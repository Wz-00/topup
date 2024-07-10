<?php
require 'function/conn.php';
require 'function/banner.php';
$bid = $_GET['bid'];
$qbanner = "SELECT * FROM banner WHERE bid = '$bid'";
$rbanner = mysqli_query($conn, $qbanner);
$rowbanner = mysqli_fetch_assoc($rbanner);

if (isset($_POST["submit"])) {

    if (edit_banner($_POST) > 0) {
        echo "<script>
        alert('Berhasil mengupdate banner!');
        document.location.href = 'index.php?page=promo';
        </script>";
    } else {
        echo "<script>
        alert('Gagal mengupdate banner!');
        </script>";
    }
}
?>
<link rel="stylesheet" href="css/promo.css">
<div class="container my-3">
    <div class="konten mx-auto p-3">
        <form action="" method="POST">
            <h3 class="text-center text-light">Edit Your Banner</h3>
            <div class="banner">
                <img src="<?= htmlspecialchars($rowbanner['banner']) ?>" alt="" class="img-fluid" id="preview_banner">
            </div>
            <div class="row mt-2">
                <div class="col">
                    <?php
                    $querygame = "SELECT * FROM game";
                    $resultgame = mysqli_query($conn, $querygame);
                    ?>
                    <select name="game" id="game" class="form-control" data-bid="<?= $rowbanner['gid']; ?>">
                        <option value="" selected disabled>Pilih Game</option>
                        <?php                        
                        while ($rowgame = mysqli_fetch_assoc($resultgame)) {
                            echo "<option value='" . $rowgame['game'] . "'>" . $rowgame['game'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <input type="file" accept=".jpg" name="banner" id="image" onchange="previewImage('image', 'preview_banner')" data-bid="<?= $bid; ?>" hidden>
                    <button id="selector_image" name="selector_image" class="select_image">Pilih Gambar</button>
                </div>
            </div>
            <div class="text-center tombol"><button type="submit" name="submit">Submit</button></div>
            <input type="hidden" name="bid" value="<?= $bid; ?>">
            <input type="hidden" id="gid" value="">
        </form>
    </div>
</div>
<script>
    // Menambahkan event listener untuk tombol select image
    document.getElementById('selector_image').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    function previewImage(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>