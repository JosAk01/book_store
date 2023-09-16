<?php
session_start();
include('../includes/db.php');

if (isset($_POST['submit'])) {
    $error = array();

    if (empty($_POST['email'])) {
        $error['email'] = "Input Email";
    }

    if (empty($_POST['hash'])) {
        $error['hash'] = "Input Password";
    }

    if (empty($error)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:em");
        $stmt->bindParam(":em", $_POST['email']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_BOTH);

        if ($stmt->rowCount() > 0 && password_verify($_POST['hash'], $row['hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            header("location: user_home.php");
            exit();
        } elseif ($stmt->rowCount() == 0) {
            // Display an error message for the email field
            $error_message = "Email is incorrect";
        } else {
            // Display a general error message for the password field
            $error_message = "Password is incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<form action="user_login.php" method="post">
    <h2>Book Store Login</h2>
    <?php
    if (isset($error_message)) {
        echo '<p id="disappearing-text" style="color: red;">' . htmlspecialchars($error_message) . '</p>';
    }
    ?>
    <script>
    // JavaScript code to make the text disappear after 5 seconds
    setTimeout(function() {
        var disappearingText = document.getElementById('disappearing-text');
        disappearingText.style.display = 'none';
    }, 3000); // 5000 milliseconds (5 seconds)
</script>
    <label for="email">Email:</label>
    <input name="email" type="text" required>
    <br>
    <label for="hash">Password:</label>
    <input name="hash" type="password" required>
    <br>
    <input name="submit" type="submit" value="Submit">
    <br><br><hr>
    <div class="signup-link">
        <p>Not a member?<a href="user_signup.php"> Signup</a></p>
    </div>
</form>
</body>
</html>

