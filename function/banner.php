<?php
function edit_banner($edit_B)
{
    global $conn;
    // ambil data dari form edit
    $bid = $edit_B["bid"];
    $banner = $edit_B["banner"];
    $gid = $edit_B["gid"];

    $query = "UPDATE banner SET gid='$gid', banner='$banner' WHERE bid='$bid'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}
?>