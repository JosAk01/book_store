<?php
include('../includes/db.php');
include('../includes/admin_auth.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    header("Location: user_home.php");
    exit();
}

$statement = $conn->prepare("SELECT * FROM users WHERE user_id=:uid");
$statement->bindParam(":uid", $user_id);
$statement->execute();

$query = "SELECT name, email FROM users WHERE user_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Now, you have both the admin's name and email in the $row array
$admin_name = $row['name'];
$admin_email = $row['email'];

// You can use $admin_name and $admin_email as needed in your code
?>

<!DOCTYPE html>
<html>
<head>
<style>
  .card {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    text-align: center;
    font-size: 18px;
  }
  .success-text {
    color: #4CAF50;
    font-weight: bold;
  }
  .done-button {
    background-color: #0074e4;
    color: white;
    font-size: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .done-button:hover {
    background-color: #0054b8;
  }
</style>
</head>
<body>

<div class="card">
  <p class="success-text">Success!</p>
  <p>Dear <?php echo $row['name']?>,</p>
  <p>Your email was successfully changed to <?php echo $row['email']?>.</p>
  <p>Have a nice day!</p>
  
  <a href="user_home.php">
    <button class="done-button">Done</button>
  </a>
</div>


</body>
</html>
