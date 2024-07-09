<?php

// Fungsi untuk menyimpan data ke tabel game
function saveGame($conn, $game, $description, $image) {
    $stmt = $conn->prepare("INSERT INTO game (game, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $game, $description, $image);

    if ($stmt->execute()) {
        // Mengambil gid yang baru saja dimasukkan
        $stmt = $conn->prepare("SELECT gid FROM game WHERE game = ? AND description = ? AND image = ? ORDER BY gid DESC LIMIT 1");
        $stmt->bind_param("sss", $game, $description, $image);
        $stmt->execute();
        $stmt->bind_result($gid);
        $stmt->fetch();
        $stmt->close();
        return $gid;
    } else {
        error_log("Insert failed: " . $stmt->error);
        return false;
    }

    $stmt->close();
}
?>
