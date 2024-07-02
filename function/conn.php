<?php 
$conn = mysqli_connect("localhost", "root", "", "topup");
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;

    }
    return $rows;
}
// fungsi untuk mengambil id dari session usermane
function getUserIdByUsername($conn, $username) {
    $stmt = $conn->prepare('SELECT uid FROM user WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        return $user['uid'];
    } else {
        return false;
    }
}
?>