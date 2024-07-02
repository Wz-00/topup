<?php
require 'function/conn.php';
?>
<link rel="stylesheet" href="css/nota.css">
<div class="container py-5">
    <h3><b>Detail Pembayaran</b></h3>
    <div class="nota greetings">
        <b>Terima Kasih</b>
        <p>Pesanan anda berhasil dibuat. Masa berlaku untuk No. Transaksi ini 24 jam, segera lakukan pembayaran agar pesanan segera diproses.</p>
        <p>Simpan No. Transaksi anda untuk Cek Status Pesanan!</p>
    </div>
    <div class="nota detail">
        <div class="row">
            <!-- bagian yang diisi n/a nantinya dibuat menggunakan pemanggilan php -->
            <?php
            $tytid = isset($_GET['tid']) ? $_GET['tid'] : '';
            if (!empty($tytid)) {
                $sql = "SELECT 
                 t.tid, 
                 t.IDGame,
                 t.created_at,
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
                 game g ON t.gid = g.gid
             INNER JOIN 
                 item i ON t.itemid = i.itemid
                 WHERE 
                t.tid = ?";

                // Mempersiapkan statement
                if ($stmt = $conn->prepare($sql)) {
                    // Mengikat parameter
                    $stmt->bind_param("s", $tytid);

                    // Menjalankan statement
                    $stmt->execute();

                    // Mengambil hasil
                    $result = $stmt->get_result();

                    // Memeriksa apakah ada hasil
                    if ($result->num_rows > 0) {
                        // Menampilkan hasil
                        $row = $result->fetch_assoc();
            ?>
                        <div class="col">
                            <b>ID Game</b>
                            <p><?= $row['IDGame']; ?></p>
                            <b>Metode Pembayaran</b>
                            <p><?= $row['method']; ?></p>
                            <b>No. Rekening/ No. Virtual Account</b>
                            <p><?= $row['number']; ?></p>
                            <b>Jumlah Pembayaran</b>
                            <p><?= $row['price']; ?></p>
                            <b>Keterangan/ No. Token/ No. Voucher</b>
                            <p><?= $row['status']; ?></p>
                        </div>
                        <div class="col">
                            <b>No. Transaksi</b>
                            <p><?= $row['tid']; ?></p>
                            <b>Waktu Transaksi</b>
                            <p><?= $row['created_at']; ?></p>
                            <b>Rincian Pemesanan</b>
                            <p><?= $row['game'] . '-' . $row['item']; ?></p>
                        </div>
            <?php
                    } else {
                        echo "No results found for Transaction ID: $tytid";
                    }

                    // Menutup statement
                    $stmt->close();
                } else {
                    echo "Failed to prepare statement";
                }
            } else {
                echo "Transaction ID is not provided";
            }
            ?>
        </div>
    </div>
</div>