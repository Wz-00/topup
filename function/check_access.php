<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    echo "Anda tidak memiliki akses ke halaman ini.";
    exit;
}
?>
