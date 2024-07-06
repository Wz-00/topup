<?php
require __DIR__ . '../../../function/check_access.php';
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
                 item i ON t.itemid = i.itemid WHERE t.status='Berhasil' || t.status='Gagal' ";
$result = $conn->query($transaksi);
?>
<link rel="stylesheet" href="css/revenue.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card my-3">
                <div class="card-body">
                    <h5 class="header-title pb-3 mt-0">Payments List</h5>
                    <div class="table-responsive">
                        <!-- Ambil dari database -->
                        <!-- jika status sukses, badge primary. jika status belum selesai, badge warning. jika status dibatalkan, badge danger -->
                        <table class="table table-dark table-hover mb-0" id="example">
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
                                            <?php if ($row['status'] == 'Berhasil') : ?>
                                                <td><span class="badge text-bg-success" style="width: 100%; font-weight: 100px; font-size:14px"><?= $row['status']; ?></span></td>
                                            <?php elseif ($row['status'] == 'Gagal') : ?>
                                                <td><span class="badge text-bg-danger" style="width: 100%; font-weight: 100px; font-size:14px"><?= $row['status']; ?></span></td>
                                            <?php else : ?>
                                                <td><span class="badge text-bg-warning"><?= $row['status']; ?></span></td>
                                            <?php endif; ?>
                                            
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        // Inisialisasi DataTables
        $('#example').DataTable();
    });
</script>
</body>

</html>