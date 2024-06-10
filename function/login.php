<?php
require "function/conn.php";

// Fungsi untuk memeriksa login pengguna
function loginUser($username, $password) {
    global $conn;

    // Query untuk mengambil data pengguna berdasarkan username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah pengguna ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Periksa kecocokan kata sandi
        if (password_verify($password, $row['password'])) {
            return $row; // Login berhasil, kembalikan data pengguna
        }
    }
    return false; // Login gagal
}


function adduser($add_user){
    global $conn;
    // ambil data dari form insert
    $username = $add_user["username"];
    $email = $add_user["email"];
    $password = $add_user["password"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();

    return $stmt->affected_rows;
}

?>