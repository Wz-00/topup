<?php
require "function/conn.php";

// Ambil data game berdasarkan gid yang diterima
$gid = isset($_GET['gid']) ? mysqli_real_escape_string($conn, $_GET['gid']) : '';
$game = query("SELECT * FROM game WHERE gid = '$gid'")[0];

// Proses form submit untuk update game dan item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $game_name = mysqli_real_escape_string($conn, $_POST['game_name']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $current_game_image = mysqli_real_escape_string($conn, $_POST['current_game_image']);
    $game_image = $_FILES['game_image'];

    // Proses upload gambar game jika dipilih
    if ($game_image['name']) {
        $game_image_path = 'asset/game/' . basename($game_image['name']);
        if (!move_uploaded_file($game_image['tmp_name'], $game_image_path)) {
            die("Error uploading game image.");
        }
    } else {
        $game_image_path = $current_game_image;
    }

    // Update data game
    $update_game_query = "UPDATE game SET game = '$game_name', description = '$deskripsi', image = '$game_image_path' WHERE gid = '$gid'";
    if (!mysqli_query($conn, $update_game_query)) {
        die("Error updating game: " . mysqli_error($conn));
    }

    // Hapus item yang ditandai untuk dihapus
    if (isset($_POST['deleted_item_id'])) {
        $deleted_item_ids = $_POST['deleted_item_id'];
        foreach ($deleted_item_ids as $deleted_item_id) {
            $deleted_item_id = mysqli_real_escape_string($conn, $deleted_item_id);
            $delete_item_query = "DELETE FROM item WHERE itemid = '$deleted_item_id'";
            if (!mysqli_query($conn, $delete_item_query)) {
                die("Error deleting item: " . mysqli_error($conn));
            }
        }
    }

    // Update atau insert item
    if (isset($_POST['item_id'])) {
        $item_ids = $_POST['item_id'];
        $item_names = $_POST['item_name'];
        $item_prices = $_POST['item_price'];
        $current_item_images = $_POST['current_item_image'];
        $item_images = $_FILES['item_image'];

        foreach ($item_ids as $key => $item_id) {
            $item_name = mysqli_real_escape_string($conn, $item_names[$key]);
            $item_price = mysqli_real_escape_string($conn, $item_prices[$key]);
            $current_item_image = mysqli_real_escape_string($conn, $current_item_images[$key]);

            // Proses upload gambar item jika dipilih
            if ($item_images['name'][$key]) {
                $item_image_path = 'asset/icon/' . basename($item_images['name'][$key]);
                if (!move_uploaded_file($item_images['tmp_name'][$key], $item_image_path)) {
                    die("Error uploading item image.");
                }
            } else {
                $item_image_path = $current_item_image;
            }

            if (!empty($item_id)) {
                $update_item_query = "UPDATE item SET item = '$item_name', price = '$item_price', icon = '$item_image_path' WHERE itemid = '$item_id'";
                if (!mysqli_query($conn, $update_item_query)) {
                    die("Error updating item: " . mysqli_error($conn));
                }
            } else {
                $insert_item_query = "INSERT INTO item (gid, item, price, icon) VALUES ('$gid', '$item_name', '$item_price', '$item_image_path')";
                if (!mysqli_query($conn, $insert_item_query)) {
                    die("Error inserting item: " . mysqli_error($conn));
                }
            }
        }
    }

    // Script to use JavaScript for redirect
    echo '<script>
        alert("Update berhasil dilakukan.");
        window.location.href = "index.php?page=game&gid=' .$game['gid']. '";
    </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game</title>
    <link rel="stylesheet" href="css/game.css">
</head>

<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="kard my-3 p-3">
                <div class="kard-body">
                    <h3 class="text-center"><?= htmlspecialchars($game['game']) ?></h3>
                    <div class="grid" style="--bs-columns: 3;">
                        <div class="g-col-3 g-col-md-1">
                            <div class="kiri">
                                <img id="preview_game" src="<?= htmlspecialchars($game['image']) ?>" alt="" class="img-fluid GameBanner">
                                <input type="file" id="game_image" name="game_image" accept="image/*" style="display:none;" onchange="previewImage('game_image', 'preview_game')">
                                <button type="button" id="game_image_button" class="change text-center text-light">Select Image</button>
                                <div class="p-2">
                                    <div class="form my-3">
                                        <label for="game_name">Nama Game</label>
                                        <input type="text" id="game_name" name="game_name" value="<?= htmlspecialchars($game['game']) ?>" class="form-control" placeholder="Nama Game">
                                    </div>
                                    <div class="form">
                                        <label for="deskripsi" class="mb-3">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" style="height: 315px;"><?= htmlspecialchars($game['description']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="g-col-3 g-col-md-2 text-center">
                            <div class="item mb-3 p-4">
                                <h3>ITEM</h3>
                                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-2" id="itemContainer">
                                    <?php
                                    $item_query = "SELECT * FROM item WHERE gid = '$gid'";
                                    $iitem = mysqli_query($conn, $item_query);
                                    if ($iitem && mysqli_num_rows($iitem) > 0) :
                                        while ($row2 = mysqli_fetch_assoc($iitem)) :
                                            $itemId = isset($row2['itemid']) ? $row2['itemid'] : '';
                                            $itemIcon = isset($row2['icon']) ? $row2['icon'] : 'default-icon.png';
                                            $itemName = isset($row2['item']) ? $row2['item'] : '';
                                            $itemPrice = isset($row2['price']) ? $row2['price'] : 0;
                                    ?>
                                            <div class="col item-col">
                                                <div class="kartu p-1 my-1">
                                                    <img id="preview_item_<?= htmlspecialchars($itemId) ?>" src="<?= htmlspecialchars($itemIcon) ?>" alt="" class="img-fluid mx-auto my-1" style="max-height: 50px;">
                                                    <input type="file" id="item_image_<?= htmlspecialchars($itemId) ?>" name="item_image[]" accept="image/*" style="display:none;" onchange="previewImage('item_image_<?= htmlspecialchars($itemId) ?>', 'preview_item_<?= htmlspecialchars($itemId) ?>')">
                                                    <button type="button" class="change text-center text-light" data-input-id="item_image_<?= htmlspecialchars($itemId) ?>">Select Icon</button>
                                                    <div class="row text-center">
                                                        <div class="col">Item</div>
                                                        <div class="col">Harga</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col text-start form-floating">
                                                            <input type="text" id="item_name_<?= htmlspecialchars($itemId) ?>" name="item_name[]" value="<?= htmlspecialchars($itemName) ?>" style="width: 100%;" class="form-control mt-0 py-0">
                                                        </div>
                                                        <div class="col text-end form-floating">
                                                            <input type="number" id="item_price_<?= htmlspecialchars($itemId) ?>" name="item_price[]" value="<?= htmlspecialchars($itemPrice) ?>" style="width: 100%;" class="form-control py-0">
                                                        </div>
                                                    </div>
                                                    <button type="button" class="close-btn" onclick="hapusItem(this)">x</button>
                                                </div>
                                                <input type="hidden" name="item_id[]" value="<?= htmlspecialchars($itemId) ?>">
                                                <input type="hidden" name="current_item_image[]" value="<?= htmlspecialchars($itemIcon) ?>">
                                            </div>
                                    <?php
                                        endwhile;
                                    endif;
                                    ?>
                                </div>
                                <button type="button" id="tambahItem" class="change text-center text-light">Tambah Item</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="gid" value="<?= htmlspecialchars($game['gid']) ?>">
            <input type="hidden" name="current_game_image" value="<?= htmlspecialchars($game['image']) ?>">
            <span class="edit"><button class="text-center text-light" type="submit">Submit</button></span>
            <div class="text-center pb-3 text-light">
                <p>Copyright © 2036 Menosa Store. All rights reserved.</p>
            </div>
        </form>
    </div>

    <script>
        // Menambahkan event listener untuk tombol select image
        document.getElementById('game_image_button').addEventListener('click', function () {
            document.getElementById('game_image').click();
        });

        document.querySelectorAll('.change[data-input-id]').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById(button.getAttribute('data-input-id')).click();
            });
        });

        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('tambahItem').addEventListener('click', function () {
            const container = document.getElementById('itemContainer');
            const newItemId = Date.now();

            const itemCol = document.createElement('div');
            itemCol.classList.add('col', 'item-col');

            itemCol.innerHTML = `
                <div class="kartu p-1 my-1">
                    <img id="preview_item_${newItemId}" src="default-icon.png" alt="" class="img-fluid mx-auto my-1" style="max-height: 50px;">
                    <input type="file" id="item_image_${newItemId}" name="item_image[]" accept="image/*" style="display:none;" onchange="previewImage('item_image_${newItemId}', 'preview_item_${newItemId}')">
                    <button type="button" class="change text-center text-light" data-input-id="item_image_${newItemId}">Select Icon</button>
                    <div class="row text-center">
                        <div class="col">Item</div>
                        <div class="col">Harga</div>
                    </div>
                    <div class="row">
                        <div class="col text-start form-floating">
                            <input type="text" id="item_name_${newItemId}" name="item_name[]" style="width: 100%;" class="form-control mt-0 py-0">
                        </div>
                        <div class="col text-end form-floating">
                            <input type="number" id="item_price_${newItemId}" name="item_price[]" style="width: 100%;" class="form-control py-0">
                        </div>
                    </div>
                    <button type="button" class="close-btn" onclick="hapusItem(this)">x</button>
                </div>
                <input type="hidden" name="item_id[]" value="">
                <input type="hidden" name="current_item_image[]" value="default-icon.png">
            `;

            container.appendChild(itemCol);

            itemCol.querySelector('.change[data-input-id]').addEventListener('click', function () {
                document.getElementById(this.getAttribute('data-input-id')).click();
            });
        });

        function hapusItem(button) {
            const itemCol = button.closest('.item-col');
            const itemIdInput = itemCol.querySelector('input[name="item_id[]"]');
            
            if (itemIdInput) {
                itemIdInput.closest('.item-col').setAttribute('data-deleted', 'true');
                itemIdInput.name = "deleted_item_id[]"; // Mengubah nama input agar bisa diakses saat submit
            }

            itemCol.style.display = 'none'; // Sembunyikan elemen
        }
    </script>
</body>

</html>
