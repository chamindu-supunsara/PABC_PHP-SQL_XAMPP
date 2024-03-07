<?php
session_start(); // Initialize session

// Include necessary files
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['loginGuard'])) {
    die("User not logged in.");
}

// Fetch data from the database
$email = $_SESSION['loginGuard'];
$sql = "SELECT * FROM accounts WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

$data = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sen_email = $_SESSION['loginGuard'];
        $sql = "SELECT * FROM bills WHERE email = '$sen_email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
    }
}

// Create CSV file
if (!empty($data)) {
    // Output BOM
    echo "\xEF\xBB\xBF";

    // Set headers for CSV download
    header('Content-Type: text/csv;');
    header('Content-Disposition: attachment; filename="mobile_bills_transactions.csv"');

    // Open output stream
    $output = fopen("php://output", "w");

    // Add CSV headers
    fputcsv($output, array('Provider', 'Acc No', 'Mobile No', 'Amount'));

    // Loop through data and add rows to CSV
    foreach ($data as $row) {
        fputcsv($output, array($row['type'], $row['accountno'], $row['mobileno'], $row['amount']));
    }

    // Close output stream
    fclose($output);
    exit; // Ensure no further content is outputted
} else {
    echo "No transactions found";
    exit; // Ensure no further content is outputted
}
?>
