<?php
require '../vendor/autoload.php';
include('../includes/db.php');

if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];
    $paystack = new \Yabacon\Paystack('sk_test_90c19a74f0c8b18b07078ae8b0e81757d93823d7'); // Replace with your secret key

    try {
        $tranx = $paystack->transaction->verify(['reference' => $reference]);
    } catch (\Yabacon\Paystack\Exception\ApiException $e) {
        die('Transaction verification failed: ' . $e->getMessage());
    }

    if ('success' == $tranx->data->status) {
        // Transaction was successful
        $status = 'paid';
        $total_amount = $tranx->data->amount / 100; // Paystack returns amount in kobo
        $order_details = json_encode($tranx->data->metadata); // Assuming order details are stored in metadata

        echo "Transaction was successful. Reference: " . $tranx->data->reference;

        // Insert transaction details into the database
        $sql = "INSERT INTO orders (reference_no, order_details, total_amount, status) VALUES (:reference_no, :order_details, :total_amount, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reference_no', $reference);
        $stmt->bindParam(':order_details', $order_details);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo "Transaction details saved to the database.";
        } else {
            echo "Failed to save transaction details to the database.";
        }
    } else {
        // Transaction was not successful
        $status = 'unpaid'; // or 'refunded' depending on the logic you want to implement

        echo "Transaction was not successful. Status: " . $tranx->data->status;

        // Insert transaction details into the database
        $sql = "INSERT INTO orders (reference_no, order_details, total_amount, status) VALUES (:reference_no, :order_details, :total_amount, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reference_no', $reference);
        $stmt->bindParam(':order_details', $order_details);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo "Transaction details saved to the database.";
        } else {
            echo "Failed to save transaction details to the database.";
        }
    }
} else {
    die('No reference supplied');
}
?>
