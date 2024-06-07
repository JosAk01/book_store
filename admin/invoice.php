<?php
include('../includes/db.php');
include('../includes/user_auth.php');

// Fetch orders from database
$sql = "SELECT * FROM orders";
$stmt = $conn->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Delete an order
if (isset($_POST['delete_order'])) {
    $orderId = $_POST['order_id'];
    $deleteSql = "DELETE FROM orders WHERE id = :orderId";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(':orderId', $orderId);
    $deleteStmt->execute();
    header('Location: invoice.php'); // Redirect to refresh the page
    exit;
}

// Update order status
if (isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    $updateSql = "UPDATE orders SET status = :newStatus WHERE id = :orderId";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(':newStatus', $newStatus);
    $updateStmt->bindParam(':orderId', $orderId);
    $updateStmt->execute();
    header('Location: invoice.php'); // Redirect to refresh the page
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status {
            color: green;
            font-weight: bold;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .button {
            padding: 5px 10px;
            border: none;
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            border-radius: 3px;
            text-align: center;
        }
        .button.delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Orders Invoice</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reference No</th>
                    <th>Order Details</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['reference_no']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_details']); ?></td>
                    <td><?php echo htmlspecialchars($order['total_amount']); ?></td>
                    <td class="status"><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($order['updated_at']); ?></td>
                    <td class="actions">
                        <form method="post" action="">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                            <input type="submit" name="delete_order" value="Delete" class="button delete">
                        </form>
                        <form method="post" action="">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="Pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Completed" <?php if ($order['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                <option value="Cancelled" <?php if ($order['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                            </select>
                            <input type="submit" name="update_status" value="Update" class="button">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
