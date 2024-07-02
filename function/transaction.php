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
    $user_id = getUserIdByUsername($conn, $_SESSION['username']);
    $uid = isset($user_id) ? $user_id : NULL;

    // Debugging output
    echo "UID from session: " . json_encode($uid) . "<br>";

    // Query untuk memasukkan data ke tabel transaction
    $query = "INSERT INTO `transaction` (`uid`, `pid`, `gid`, `itemid`, `wa number`, `status`, `IDGame`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        return;
    }

    $stmt->bind_param('ssssssss', $uid, $pid, $gid, $itemid, $wa, $status, $gameid, $waktu);
    // Check for execute errors
    if (!$stmt->execute()) {
        echo "Error executing statement: " . $stmt->error;
        return false;
    }

    // Ambil ID transaksi yang baru saja dimasukkan
    $query_tid = "SELECT `tid` FROM `transaction` WHERE `uid` = ? AND `pid` = ? AND `gid` = ? AND `itemid` = ? AND `wa number` = ? AND `status` = ? AND `IDGame` = ? AND `created_at` = ? ORDER BY `tid` DESC LIMIT 1";
    $stmt_tid = $conn->prepare($query_tid);

    if (!$stmt_tid) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }

    $stmt_tid->bind_param('ssssssss', $uid, $pid, $gid, $itemid, $wa, $status, $gameid, $waktu);
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
