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
        // echo "Transaction was successful. Reference: " . $tranx->data->reference;

        // Insert transaction details into the database
        $sql = "INSERT INTO orders (reference_no, order_details, total_amount, status) VALUES (:reference_no, :order_details, :total_amount, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reference_no', $reference);
        $stmt->bindParam(':order_details', $order_details);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            // echo "Transaction details saved to the database.";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .receipt-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
            margin: 20px;
            border: 1px solid #ddd;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-header h2 {
            color: #333333;
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
        }

        .receipt-header p {
            color: #777777;
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        .receipt-body {
            border-top: 1px solid #eeeeee;
            border-bottom: 1px solid #eeeeee;
            padding: 15px 0;
            margin-bottom: 20px;
        }

        .receipt-body h3 {
            color: #333333;
            font-size: 18px;
            margin-bottom: 10px;
            text-align: left;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .product-item h4 {
            font-size: 14px;
            color: #333333;
            margin: 0;
            text-transform: capitalize;
        }

        .product-item p {
            font-size: 14px;
            color: #777777;
            margin: 0;
        }

        .total-container {
            padding-top: 10px;
            margin-bottom: 20px;
        }

        .total-container p {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            color: #333333;
            margin: 0;
        }

        footer {
            text-align: center;
            font-size: 12px;
            color: #aaaaaa;
            margin-top: 15px;
        }

        .print-button {
            background-color: #28a745; /* Green color */
            color: #ffffff; /* White text */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .print-button:hover {
            background-color: #218838; /* Darker green */
        }

        @media print {
            .print-button {
                display: none; /* Hide the button during printing */
            }
            body {
                background-color: #ffffff; /* White background for printing */
                margin: 0;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none; /* Remove box shadow for printing */
                border: none; /* Remove border for printing */
                margin: 0;
                width: 100%;
            }
            .receipt-header h2, .receipt-header p, .receipt-body h3, .product-item h4, .product-item p, .total-container p, footer {
                color: #000000; /* Black text for better printing */
            }
        }
    </style>
</head>
<body>
<div id="receipt" class="receipt-container">
    <div class="receipt-header">
        <h2>Book Store</h2>
        <p>Thank you for your order!</p>
        <p>Reference No: <?php echo htmlspecialchars($reference); ?></p>
        <p>Date: <?php echo date("d/m/Y"); ?></p>
        <p>Contact Info: +234 9068881812</p>
    </div>
    <div class="receipt-body">
        <h3>Details</h3>
        <?php
        $order_items = json_decode($order_details, true);
        $custom_fields = $order_items['custom_fields'];
        foreach ($custom_fields as $field) {
            $item_details = json_decode($field['value'], true);
            ?>
            <div class="product-item">
                <div>
                    <h4><?php echo htmlspecialchars($item_details['item']); ?></h4>
                    <p>Qty: <?php echo htmlspecialchars($item_details['quantity']); ?></p>
                </div>
                <p><?php echo htmlspecialchars(number_format($item_details['price'], 2)); ?> ₦</p>
            </div>
        <?php } ?>
    </div>
    <div class="total-container">
        <p>Subtotal <span><?php echo htmlspecialchars(number_format($total_amount, 2)); ?> ₦</span></p>
        <p>Total <span><?php echo htmlspecialchars(number_format($total_amount, 2)); ?> ₦</span></p>
    </div>
    <footer>
        Lorem ipsum dolor sit amet consectetur adipisicing.
    </footer>
</div>
<button class="print-button" onclick="printReceipt()">Download Receipt</button>
<script>
    function printReceipt() {
        window.print();
    }
</script>
</body>
</html>
