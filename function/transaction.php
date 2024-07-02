<?php
require_once 'function/conn.php';
function add_transaction($data) {
    global $conn;

    // Ambil data dari form
    $gid = $data["gid"];
    $itemid = $data["itemid"];
    $pid = $data["pid"];
    $wa = $data["wa_number"];
    $gameid = $data["game_id"];
    $status = "Menunggu Pembayaran";
    $waktu = date("Y-m-d H:i:s");

    // Ambil uid dari session jika user sudah login, jika tidak biarkan kosong
    $uid = isset($_SESSION['username']) ? getUserIdByUsername($conn, $_SESSION['username']) : NULL;

    if ($uid) {
        // Query untuk memasukkan data ke tabel transaction dengan uid
        $query = "INSERT INTO `transaction` (`uid`, `pid`, `gid`, `itemid`, `wa number`, `status`, `IDGame` , `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssssss', $uid, $pid, $gid, $itemid, $wa, $status, $gameid, $waktu);
    } else {
        // Query untuk memasukkan data ke tabel transaction tanpa uid
        $query = "INSERT INTO `transaction` (`pid`, `gid`, `itemid`, `wa number`, `status`, `IDGame`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssss', $pid, $gid, $itemid, $wa, $status, $gameid, $waktu);
    }

    // Check for execute errors
    if (!$stmt->execute()) {
        echo "Error executing statement: " . $stmt->error;
        return false;
    }

    // Ambil ID transaksi yang baru saja dimasukkan
    $query_tid = "SELECT `tid` FROM `transaction` WHERE `pid` = ? AND `gid` = ? AND `itemid` = ? AND `wa number` = ? AND `status` = ? AND `IDGame` = ? AND `created_at` = ? ORDER BY `tid` DESC LIMIT 1";
    if ($uid) {
        $query_tid = "SELECT `tid` FROM `transaction` WHERE `uid` = ? AND " . substr($query_tid, 26);
        $stmt_tid = $conn->prepare($query_tid);
        $stmt_tid->bind_param('ssssssss', $uid, $pid, $gid, $itemid, $wa, $status, $gameid, $waktu);
    } else {
        $stmt_tid = $conn->prepare($query_tid);
        $stmt_tid->bind_param('sssssss', $pid, $gid, $itemid, $wa, $status, $gameid, $waktu);
    }
    $stmt_tid->execute();
    $result_tid = $stmt_tid->get_result();
    $tid_row = $result_tid->fetch_assoc();

    if ($tid_row) {
        return $tid_row['tid'];
    } else {
        return false;
    }
}
?>