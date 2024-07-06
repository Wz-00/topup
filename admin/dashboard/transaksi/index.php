<?php
require 'function/conn.php';
require 'function/transaction.php';

$gid = $_GET['gid'];
$qgame = "SELECT * FROM game WHERE gid = '$gid'";
$rgame = mysqli_query($conn, $qgame);
$rowgame = mysqli_fetch_assoc($rgame);

// Mengambil data item berdasarkan gid
$qitem = "SELECT * FROM item WHERE gid = '$gid'";
$result = $conn->query($qitem);

$qpay = "SELECT * FROM payment";
$respay = $conn->query($qpay);

// Cek apakah tombol submit pada modal sudah ditekan
if (isset($_POST['submit_transaction'])) {
    // Tambahkan transaksi dan dapatkan ID transaksi
    $tid = add_transaction($_POST);

    if ($tid) {
        echo "<script>
        alert('Transaksi berhasil!');
        window.location.href = 'index.php?page=nota&tid=$tid';
        </script>";
    } else {
        echo "<script>
        alert('Gagal melakukan transaksi! ID: $tid');
        </script>";
    }
}

?>
<link rel="stylesheet" href="css/transaksi.css">
<br>
<div class="container containbg my-2 p-4">
    <div class="grid" style="--bs-columns: 3;">
        <!-- Info Game -->
        <div class="g-col-3 g-col-lg-1">
            <div class="ginfo p-3">
                <img src="<?= $rowgame['image'] ?>" alt="" class="img-fluid">
                <div class="p-2">
                    <h4 class="text-white"><?= $rowgame['game'] ?></h4>
                    <p class="text-white"><?= $rowgame['description'] ?></p>
                </div>
            </div>
        </div>
        <!-- Form Transaksi -->
        <div class="g-col-3 g-col-lg-2">
            <form id="transaksiForm" action="" method="POST">
                <!-- Id Game -->
                <div class="mb-4 bgform">
                    <span class="rounded-circle number"><b>1</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Masukkan Game ID</span>
                    <div class="mb-3 form-floating">
                        <input type="text" id="floatingInput" name="game_id" class="form-control" placeholder="Riot ID" required />
                        <label for="floatingInput" class="text-black">ID Game</label>
                    </div>
                </div>
                <!-- Item -->
                <div class="mb-4 bgform">
                    <span class="rounded-circle number"><b>2</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Pilih Item</span>
                    <div class="row row-cols-sm-2 row-cols-md-3 gy-3">
                        <?php if ($result->num_rows > 0) : ?>
                            <?php $i = 1; ?>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="btn-check" type="radio" id="<?= $i; ?>" name="item" value="<?= $row['itemid']; ?>" data-price="<?= $row['price']; ?>" required />
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
                    <span class="rounded-circle number"><b>3</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Pilih Metode Pembayaran</span>
                    <div class="row row-cols-1">
                        <?php if ($respay) : ?>
                            <?php $j = 1; ?>
                            <?php while ($row = $respay->fetch_assoc()) : ?>
                                <div class="col">
                                    <div class="">
                                        <input class="" type="radio" id="pay<?= $j; ?>" name="payment" data-pid="<?= $row['pid']; ?>" required />
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
                    <span class="rounded-circle number"><b>4</b></span>
                    <span style="font-size: 25px; font-weight: bold;">Konfirmasi No Whatsapp</span>
                    <div class="mb-3 form-floating">
                        <input type="number" id="floatingInputWa" name="wa_number" class="form-control" placeholder="Masukkan No. Wa" required />
                        <label for="floatingInputWa" class="text-black">Masukkan No. Wa</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" id="confirmButton" class="tombol">
                            <i class="bi bi-plus-lg"></i> Konfirmasi
                        </button>
                    </div>
                </div>
                <!-- Hidden inputs -->
                <input type="hidden" name="gid" value="<?= $gid; ?>" />
                <input type="hidden" id="itemid" name="itemid" value="" />
                <input type="hidden" id="pid" name="pid" value="" />
                <input type="hidden" name="submit_transaction" value="1" />
            </form>
            <!-- Modal -->
            <div class="modal fade" id="myModal1" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"><i class="fa-solid fa-cart-shopping"></i> Detail Pembelian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped bordered">
                                <tr>
                                    <td>ID Game</td>
                                    <td id="modalGameId">N/A</td>
                                </tr>
                                <tr>
                                    <td>Kategori Layanan</td>
                                    <td id="modalItem">N/A</td>
                                </tr>
                                <tr>
                                    <td>Nominal Layanan</td>
                                    <td id="modalPrice">N/A</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td id="modalPaymentMethod">N/A</td>
                                </tr>
                                <tr>
                                    <td>Nomor WA</td>
                                    <td id="modalWa">N/A</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Pastikan data yang anda masukkan sudah benar. Kesalahan input bukan merupakan tanggung jawab kami</td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="modalConfirmButton"><i class="bi bi-plus-lg"></i> Konfirmasi</button>
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('transaksiForm');
        const confirmButton = document.getElementById('confirmButton');
        const modalConfirmButton = document.getElementById('modalConfirmButton');
        let modalConfirmed = false;

        // Fungsi untuk mengecek validasi form
        function validateForm() {
            const gameIdInput = document.getElementById('floatingInput');
            const waInput = document.getElementById('floatingInputWa');
            const itemInputs = document.querySelectorAll('input[name="item"]:checked');
            const paymentInputs = document.querySelectorAll('input[name="payment"]:checked');

            if (gameIdInput.value.trim() === '' || waInput.value.trim() === '' || itemInputs.length === 0 || paymentInputs.length === 0) {
                return false;
            }
            return true;
        }

        // Fungsi untuk mengisi data ke dalam modal
        function fillModal() {
            const gameIdInput = document.getElementById('floatingInput').value.trim();
            const waInput = document.getElementById('floatingInputWa').value.trim();
            const selectedItem = document.querySelector('input[name="item"]:checked');
            const selectedPayment = document.querySelector('input[name="payment"]:checked');

            const itemLabel = selectedItem.nextElementSibling.querySelector('b').textContent;
            const paymentMethodLabel = selectedPayment.nextElementSibling.querySelector('b').textContent;
            const price = selectedItem.getAttribute('data-price');
            const formattedPrice = 'Rp.' + Number(price).toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            document.getElementById('modalGameId').textContent = gameIdInput;
            document.getElementById('modalItem').textContent = itemLabel;
            document.getElementById('modalPrice').textContent = formattedPrice;
            document.getElementById('modalPaymentMethod').textContent = paymentMethodLabel;
            document.getElementById('modalWa').textContent = waInput;

            document.getElementById('itemid').value = selectedItem.value;
            document.getElementById('pid').value = selectedPayment.getAttribute('data-pid');
        }

        // Event listener untuk button konfirmasi yang membuka modal
        confirmButton.addEventListener('click', function(event) {
            if (validateForm()) {
                fillModal();
                const modal = new bootstrap.Modal(document.getElementById('myModal1'));
                modal.show();
            } else {
                alert('Silakan isi semua field terlebih dahulu.');
            }
        });

        // Event listener untuk button konfirmasi di dalam modal
        modalConfirmButton.addEventListener('click', function(event) {
            modalConfirmed = true;
            form.submit();
        });

        // Event listener untuk tombol cancel dan close di dalam modal
        document.querySelectorAll('.btn-close, .btn-default').forEach(button => {
            button.addEventListener('click', function() {
                modalConfirmed = false;
            });
        });

        // Submit form hanya jika modal telah dikonfirmasi
        form.addEventListener('submit', function(event) {
            if (!modalConfirmed) {
                event.preventDefault();
            }
        });
    });
</script>