<?php
$dbHost = 'localhost';
$dbName = 'book_store';
$dbUser = 'root';
$dbPass = '';

session_start();

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Function to get user details by ID
    function getUserById($userId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Check if the user ID is provided in the URL
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
        $user = getUserById($userId);

        if (!$user) {
            // Handle case where user is not found
            $_SESSION['notification'] = 'User not found.';
            header("Location: users.php");
            exit;
        }
    } else {
        // Handle case where user ID is not provided
        $_SESSION['notification'] = 'User ID not provided.';
        header("Location: users.php");
        exit;
    }

    // Check if the form is submitted for updating user details
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Perform necessary updates to the user details in the database

        // Example: Update user's name and email
        $newName = $_POST['new_name'];
        $newEmail = $_POST['new_email'];

        $stmtUpdate = $pdo->prepare("UPDATE users SET name = :newName, email = :newEmail WHERE user_id = :userId");
        $stmtUpdate->bindParam(':newName', $newName);
        $stmtUpdate->bindParam(':newEmail', $newEmail);
        $stmtUpdate->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($stmtUpdate->execute()) {
            // Set a success message and redirect to user list
            $_SESSION['notification'] = 'User details updated successfully.';
            header("Location: users.php");
            exit;
        } else {
            // Handle update failure
            $_SESSION['notification'] = 'Update failed.';
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Add your styles here -->
</head>
<body>

<h2>Edit User</h2>

<!-- Display notification if any -->
<?php if (isset($_SESSION['notification'])): ?>
    <p><?php echo $_SESSION['notification']; ?></p>
    <?php unset($_SESSION['notification']); ?>
<?php endif; ?>

<!-- Display the current user details in a form for editing -->
<form method="post">
    <label for="new_name">New Name:</label>
    <input type="text" id="new_name" name="new_name" value="<?php echo $user['name']; ?>" required>

    <label for="new_email">New Email:</label>
    <input type="email" id="new_email" name="new_email" value="<?php echo $user['email']; ?>" required>

    <button type="submit">Update</button>
</form>

</body>
</html>
