<?php
require __DIR__ . '../../../function/check_access.php';
require 'function/transaction.php';
$transaksi = "SELECT 
                 t.tid, 
                 t.IDGame,
                 t.created_at,
                 u.username,
                 p.method,
                 p.number,
                 i.price, 
                 g.game, 
                 t.status,
                 i.item
             FROM 
                 transaction t
             INNER JOIN 
                 payment p ON t.pid = p.pid
             INNER JOIN 
                 user u ON t.uid = u.uid
             INNER JOIN 
                 game g ON t.gid = g.gid
             INNER JOIN 
                 item i ON t.itemid = i.itemid WHERE t.status='Menunggu Pembayaran' || t.status='Prosess' ";
$result = $conn->query($transaksi);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tid = $_POST['tid'];
    $current_status = $_POST['current_status'];

    if (UpdateTransaksi($tid, $current_status) > 0) {
        if ($current_status = 'Menunggu Pembayaran') {
            echo "<script>
            alert('Pembayaran sudah diterima!');
            </script>";
        } elseif ($current_status = 'Prosess') {
            echo "<script>
            alert('Transaksi Berhasil!');
            document.location.href = 'index.php?page=revenue';
            </script>";
        } else {
        }
    } else {
        echo "<script>
            alert('Gagal mengupdate status!');            
        </script>";
    }
}
?>

<link rel="stylesheet" href="css/revenue.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card my-3">
                <div class="card-body">
                    <h4 class="header-title pb-3 mt-0">Transaction List</h4>
                    <!-- Ambil dari database -->
                    <!-- jika status sukses, badge primary. jika status belum selesai, badge warning. jika status dibatalkan, badge danger -->
                    <table class="table table-hover table-dark" id="example">
                        <thead>
                            <tr class="align-self-center">
                                <th scope="col">Game</th>
                                <th scope="col">Game ID</th>
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Payment Type</th>
                                <th scope="col">Item</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Transaction</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) : ?>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $row['game']; ?></td>
                                        <td><?= $row['IDGame']; ?></td>
                                        <td><?= $row['tid']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['method']; ?></td>
                                        <td><?= $row['item']; ?></td>
                                        <td><?= 'Rp.' . number_format($row['price'], 2, ",", "."); ?></td>
                                        <td><span class="badge text-bg-warning" style="width: 100%; font-weight: 100px; font-size:14px"><?= $row['status']; ?></span></td>
                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" name="tid" value="<?= $row['tid']; ?>">
                                                <input type="hidden" name="current_status" value="<?= $row['status']; ?>">
                                                <?php if ($row['status'] == 'Menunggu Pembayaran') : ?>
                                                    <button type="submit" class="btn btn-primary" onclick="javascript:return confirm('Apakah User dengan Id Transaksi <?= $row['tid']; ?> sudah menyelesaikan pembayaran ?');">Konfirmasi</button>
                                                <?php elseif ($row['status'] == 'Prosess') : ?>
                                                    <button type="submit" class="btn btn-primary" onclick="javascript:return confirm('Apakah anda sudah men-topup game dengan id transaksi <?= $row['tid']; ?>?');">Konfirmasi</button>
                                                <?php else : ?>
                                                <?php endif; ?>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        $('#example').DataTable();
    });
</script>
</body>

</html>