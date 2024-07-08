<?php
require 'function/conn.php'; // Include your database connection script
?>

<link rel="stylesheet" href="css/search.css">

<div class="pt-5"></div>
<div class="pt-5 pb-5">
    <div class="content align-self-center mx-auto">
        <div class="d-flex flex-columns">
            <div class="container">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?page=search'); ?>">
                    <p class="text-center text-light my-3" style="font-size:16px; font-weight:bold;">Cek Status Pesanan</p>
                    <div class="mb-3 form-floating">
                        <input type="text" id="floatingInput" name="tid" class="form-control" placeholder="">
                        <label for="floatingInput">Masukkan ID Pesanan anda</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="tombol">Cek Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the transaction ID
    $tid = mysqli_real_escape_string($conn, $_POST['tid']);

    // Query to retrieve transaction details based on tid
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

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("s", $tid);

        // Execute statement
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if there are results
        if ($result->num_rows > 0) {
            // Fetch data
            $row = $result->fetch_assoc();
?>
            <div class="pb-5">
                <div class="content align-self-center mx-auto">
                    <div class="d-flex flex-columns">
                        <div class="container">
                            <p class="text-center text-light my-3" style="font-size:16px; font-weight:bold;">Detail Pemesanan</p>
                            <div class="row text-light">
                                <div class="col">
                                    <b>ID Game</b>
                                    <p><?= $row['IDGame']; ?></p>
                                    <b>Metode Pembayaran</b>
                                    <p><?= $row['method']; ?></p>
                                    <b>No. Rekening/ No. Virtual Account</b>
                                    <p><?= $row['number']; ?></p>
                                    <b>Jumlah Pembayaran</b>
                                    <p><?= 'Rp.' . number_format($row['price'], 2, ",", "."); ?></p>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo "<div class='pb-5'>
                    <div class='content align-self-center mx-auto'>
                        <div class='d-flex flex-columns'>
                            <div class='container'>
                                <p class='text-center text-light my-3' style='font-size:16px; font-weight:bold;'>Detail Pemesanan</p>
                                <p class='text-center text-light my-3'>No results found for Transaction ID: $tid</p>
                            </div>
                        </div>
                    </div>
                </div>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Failed to prepare statement";
    }
}
?>
