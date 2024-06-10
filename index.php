<?php
session_start();

require 'admin/template/header.php';

if (!empty($_SESSION['role'])) {
    $role = $_SESSION['role'];

    if ($role == "admin") {
        if (!empty($_GET['page'])) {
            include 'dashboard/' . $_GET['page'] . '/index.php';
        } else {
            include 'dashboard/index.php';
        }
    } else {
        if (!empty($_GET['page'])) {
            include 'admin/module/' . $_GET['page'] . '/index.php';
        } else {
            include 'admin/template/body.php';
        }
        include 'admin/template/footer.php';
    }
} else {
    if (!empty($_GET['page'])) {
        include 'admin/module/' . $_GET['page'] . '/index.php';
    } else {
        include 'admin/template/body.php';
    }
    include 'admin/template/footer.php';
}


?>
