<?php

// Fungsi untuk menyimpan data ke tabel game
function saveGame($conn, $game, $description, $image) {
    $stmt = $conn->prepare("INSERT INTO game (game, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $game, $description, $image);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>