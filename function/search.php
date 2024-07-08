<?php

require_once 'function/conn.php';

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags($input));
}

// Initialize variables
$tid = isset($_POST['tid']) ? sanitizeInput($_POST['tid']) : '';
$result = null;

if (!empty($tid)) {
    // SQL query to retrieve transaction details
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

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("s", $tid);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if there are results
        if ($result->num_rows > 0) {
            // Fetch the result
            $row = $result->fetch_assoc();

            // Prepare the response data
            $response = [
                'success' => true,
                'html' => '
                    <div class="col">
                        <b>ID Game</b>
                        <p>' . $row['IDGame'] . '</p>
                        <b>Metode Pembayaran</b>
                        <p>' . $row['method'] . '</p>
                        <b>No. Rekening/ No. Virtual Account</b>
                        <p>' . $row['number'] . '</p>
                        <b>Jumlah Pembayaran</b>
                        <p>' . 'Rp.' . number_format($row['price'], 2, ",", ".") . '</p>
                        <b>Keterangan/ No. Token/ No. Voucher</b>
                        <p>' . $row['status'] . '</p>
                    </div>
                    <div class="col">
                        <b>No. Transaksi</b>
                        <p>' . $row['tid'] . '</p>
                        <b>Waktu Transaksi</b>
                        <p>' . $row['created_at'] . '</p>
                        <b>Rincian Pemesanan</b>
                        <p>' . $row['game'] . '-' . $row['item'] . '</p>
                    </div>
                ',
            ];
        } else {
            // Prepare the response data if no results found
            $response = [
                'success' => false,
                'message' => "No results found for Transaction ID: $tid",
            ];
        }

        // Close the statement
        $stmt->close();
    } else {
        // Prepare the response data if statement preparation fails
        $response = [
            'success' => false,
            'message' => "Failed to prepare statement",
        ];
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    // Prepare the response data if tid is not provided
    $response = [
        'success' => false,
        'message' => "Transaction ID is not provided",
    ];

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>