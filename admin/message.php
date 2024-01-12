<?php
include('../includes/db.php');
include('../includes/admin_auth.php');

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];
} else {
    header("Location: admin_home.php");
    exit();
}

$statement = $conn->prepare("SELECT * FROM admin WHERE admin_id=:aid");
$statement->bindParam(":aid", $admin_id);
$statement->execute();

$query = "SELECT admin_name, email FROM admin WHERE admin_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $admin_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Now, you have both the admin's name and email in the $row array
$admin_name = $row['admin_name'];
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
  <p>Dear <?php echo $row['admin_name']?>,</p>
  <p>Your email was successfully changed to <?php echo $row['email']?>.</p>
  <p>Have a nice day!</p>
  
  <a href="admin_home.php">
    <button class="done-button">Done</button>
  </a>
</div>


</body>
</html>
