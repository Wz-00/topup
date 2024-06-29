<?php
require 'function/conn.php';

$gid = $_GET['gid'];
$qgame = "SELECT * FROM game WHERE gid = '$gid'";
$rgame = mysqli_query($conn, $qgame);
$rowgame = mysqli_fetch_assoc($rgame);

// Mengambil data item berdasarkan gid
$qitem = "SELECT * FROM item WHERE gid = '$gid'";
$result = $conn->query($qitem);

$qpay = "SELECT * FROM payment";
$respay = $conn->query($qpay);
?>
<link rel="stylesheet" href="css/transaksi.css">
<br>
<div class="container">
    <div class="grid" style="--bs-columns: 3;">
        <!-- Info Game -->
        <div class="g-col-3 g-col-lg-1 ginfo">
            <img src="<?= $rowgame['image'] ?>" alt="" class="img-fluid">
            <div class="p-2">
                <h4 class="text-white"><?= $rowgame['game'] ?></h4>
                <p class="text-white"><?= $rowgame['description'] ?></p>
            </div>
        </div>
        <!-- Form Transaksi -->
        <div class="g-col-3 g-col-lg-2">
            <form id="transaksiForm" action="">
                <!-- Id Game -->
                <div class="mb-4 bgform">
                    <span class="rounded-circle"><b>1</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Masukkan Game ID</span>
                    <div class="mb-3 form-floating">
                        <input type="text" id="gameIdInput" class="form-control" placeholder="Riot ID" required />
                        <label for="floatingInput">ID Game</label>
                    </div>
                </div>
                <!-- Item -->
                <div class="mb-4 bgform">
                    <span class="rounded-circle"><b>2</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Pilih Item</span>
                    <div class="row row-cols-sm-2 row-cols-md-3 gy-3">
                        <?php if ($result->num_rows > 0) : ?>
                            <?php $i = 1; ?>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="btn-check" type="radio" id="<?= $i; ?>" name="item" data-price="<?= $row['price']; ?>" required />
                                        <label class="selected" for="<?= $i; ?>">
                                            <img src="<?= $row['icon']; ?>" alt="" class="mx-auto my-2" style="max-height: 50px;"><br>
                                            <b><?= $row['item'] ?></b>
                                            <p><?= 'Rp.' . number_format($row['price'], 2, ",", "."); ?></p>
                                        </label>
                                    </div>
                                </div>
                                <?php $i++; ?>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <p>Tidak ada item tersedia</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Payment -->
                <div class="mb-4 bgform">
                    <span class="rounded-circle"><b>3</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Pilih Metode Pembayaran</span>
                    <div class="row row-cols-1">
                        <?php if ($respay) : ?>
                            <?php $j = 1; ?>
                            <?php while ($row = $respay->fetch_assoc()) : ?>
                                <div class="col">
                                    <div class="">
                                        <input class="" type="radio" id="pay<?= $j; ?>" name="payment" required />
                                        <label class="payment" for="pay<?= $j; ?>">
                                            <img src="<?= $row['logo'] ?>" alt="" class="Rgambar p-2">
                                            <b><?= $row['method'] ?></b>
                                            <b class="payment-price"></b>
                                        </label>
                                    </div>
                                </div>
                                <?php $j++; ?>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <p>Metode Pembayaran Belum Tersedia</p>
                        <?php endif; ?>

                    </div>
                </div>
                <!-- whatsapp -->
                <div class="mb-4 bgform">
                    <span class="rounded-circle"><b>4</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Konfirmasi No Whatsapp</span>
                    <div class="mb-3 form-floating">
                        <input type="text" id="waInput" class="form-control" placeholder="Masukkan No. Wa" required />
                        <label for="floatingInput">Masukkan No. Wa</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-md mr-2" id="confirmButton">
                            <i class="bi bi-plus-lg"></i> Konfirmasi
                        </button>

                    </div>
                </div>
            </form>

            <!-- Modal -->
            <div class="modal fade" id="myModal1" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"><i class="fa-solid fa-cart-shopping"></i> Detail Pembelian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <table class="table table-striped bordered">
                                    <tr>
                                        <td>ID Game</td>
                                        <td id="modalGameId"></td>
                                    </tr>
                                    <tr>
                                        <td>Kategori Layanan</td>
                                        <td id="modalItem"></td>
                                    </tr>
                                    <tr>
                                        <td>Nominal Layanan</td>
                                        <td id="modalPrice"></td>
                                    </tr>
                                    <tr>
                                        <td>Metode Pembayaran</td>
                                        <td id="modalPaymentMethod"></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor WA</td>
                                        <td id="modalWa"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Pastikan data yang anda masukkan sudah benar. Kesalahan input bukan merupakan tanggung jawab kami</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="confirm"><i class="bi bi-plus-lg"></i><a href="index.php?page=nota" style="text-decoration:none; color:white;"> Konfirmasi</a></button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Fungsi untuk mengubah price dalam metode pembayaran
    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan semua input radio untuk item
        const itemInputs = document.querySelectorAll('input[name="item"]');
        const paymentPriceElements = document.querySelectorAll('.payment-price');

        itemInputs.forEach(input => {
            input.addEventListener('click', function() {
                // Mendapatkan harga dari data attribute
                const price = this.getAttribute('data-price');
                const formattedPrice = 'Rp.' + Number(price).toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                // Mengubah teks di semua elemen payment-price
                paymentPriceElements.forEach(element => {
                    element.textContent = formattedPrice;
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan elemen-elemen yang dibutuhkan
        const form = document.getElementById('transaksiForm');
        const confirmButton = document.getElementById('confirmButton');

        // Fungsi untuk mengecek validasi form
        function validateForm() {
            // Mengecek apakah semua input telah diisi
            const gameIdInput = document.getElementById('gameIdInput');
            const waInput = document.getElementById('waInput');
            const itemInputs = document.querySelectorAll('input[name="item"]:checked');
            const paymentInputs = document.querySelectorAll('input[name="payment"]:checked');

            if (gameIdInput.value.trim() === '' || waInput.value.trim() === '' || itemInputs.length === 0 || paymentInputs.length === 0) {
                return false;
            }
            return true;
        }

        // Menambahkan event listener pada tombol konfirmasi
        confirmButton.addEventListener('click', function(event) {
            // Validasi form
            if (validateForm()) {
                // Jika valid, tampilkan modal konfirmasi
                const modal = new bootstrap.Modal(document.getElementById('myModal1'));
                modal.show();
            } else {
                // Jika tidak valid, tampilkan pesan error atau highlight input yang belum diisi
                alert('Silakan isi semua field terlebih dahulu.');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan elemen-elemen yang dibutuhkan
        const form = document.getElementById('transaksiForm');
        const confirmButton = document.getElementById('confirmButton');
        const modalGameId = document.getElementById('modalGameId');
        const modalItem = document.getElementById('modalItem');
        const modalPrice = document.getElementById('modalPrice');
        const modalPaymentMethod = document.getElementById('modalPaymentMethod');
        const modalWa = document.getElementById('modalWa');

        // Fungsi untuk mengecek validasi form
        function validateForm() {
            // Mengecek apakah semua input telah diisi
            const gameIdInput = document.getElementById('gameIdInput');
            const waInput = document.getElementById('waInput');
            const itemInputs = document.querySelectorAll('input[name="item"]:checked');
            const paymentInputs = document.querySelectorAll('input[name="payment"]:checked');

            if (gameIdInput.value.trim() === '' || waInput.value.trim() === '' || itemInputs.length === 0 || paymentInputs.length === 0) {
                return false;
            }
            return true;
        }

        // Fungsi untuk mengisi data ke dalam modal
        function fillModal() {
            const gameIdInput = document.getElementById('gameIdInput').value.trim();
            const waInput = document.getElementById('waInput').value.trim();
            const selectedItem = document.querySelector('input[name="item"]:checked');
            const selectedPayment = document.querySelector('input[name="payment"]:checked');

            // Mendapatkan harga dan item dari data attribute
            const price = selectedItem.getAttribute('data-price');
            const itemLabel = selectedItem.nextElementSibling.querySelector('b').textContent;
            const paymentMethodLabel = selectedPayment.nextElementSibling.querySelector('b').textContent;

            // Memformat harga
            const formattedPrice = 'Rp.' + Number(price).toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Mengisi data ke dalam modal
            modalGameId.textContent = gameIdInput;
            modalItem.textContent = itemLabel;
            modalPrice.textContent = formattedPrice;
            modalPaymentMethod.textContent = paymentMethodLabel;
            modalWa.textContent = waInput;
        }

        // Menambahkan event listener pada tombol konfirmasi
        confirmButton.addEventListener('click', function(event) {
            // Validasi form
            if (validateForm()) {
                // Jika valid, isi data ke dalam modal dan tampilkan modal konfirmasi
                fillModal();
                const modal = new bootstrap.Modal(document.getElementById('myModal1'));
                modal.show();
            } else {
                // Jika tidak valid, tampilkan pesan error atau highlight input yang belum diisi
                alert('Silakan isi semua field terlebih dahulu.');
            }
        });
    });
</script>