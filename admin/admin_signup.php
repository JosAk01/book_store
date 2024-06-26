<?php
include('../includes/db.php');

if (isset($_POST['submit'])) {
  $error = array(); // Initialize an array to store errors

  // Check if the 'name' field is empty
  if (empty($_POST['name'])) {
    $error['name'] = "Name is required";
  }else{
    $statement = $conn->prepare("SELECT * FROM admin WHERE name = :nm");
    $statement->bindParam(":nm",$_POST['name']);
    $statement->execute();
    if($statement->rowCount() > 0){
      $error['name'] = "Name already Exists";
    }
  }

  // Check if the 'email' field is empty
  if (empty($_POST['email'])) {
    $error['email'] = "Email is required";
  }else{
    $statement = $conn->prepare("SELECT * FROM admin WHERE email = :em");
    $statement->bindParam(":em",$_POST['email']);
    $statement->execute();
    if($statement->rowCount() > 0){
      $error['email'] = "Email already Exists";
    }
  }
  if (empty($_POST['phone_number'])) {
    $error['phone_number'] = "Phone Number is required";
  }else{
    $statement = $conn->prepare("SELECT * FROM admin WHERE phone_number = :pn");
    $statement->bindParam(":pn",$_POST['phone_number']);
    $statement->execute();
    if($statement->rowCount() > 0){
      $error['phone_number'] = "Phone Number already Exists";
    }
  }
  // Check if the 'hash' (password) field is empty
  if (empty($_POST['hash'])) {
    $error['password'] = "Password is required";
  }
  
  // Check if 'hash' and 'confirm_hash' match
  if (empty($_POST['confirm_hash'])) {
    $error['confirm_hash'] = "Confirm Password is required";
  } elseif ($_POST['hash'] !== $_POST['confirm_hash']) {
    $error['confirm_hash'] = "Password Mismatch";
  }

  // If there are no errors, you can proceed with processing the form data
  if (empty($error)) {
    $encrypted = password_hash($_POST['hash'], PASSWORD_BCRYPT);
$stmt = $conn->prepare("INSERT INTO admin VALUES (NULL, :nm, :em, :pn, :hsh, NOW(), NOW())");
// Process the form data here, e.g., store it in a database or perform other actions
$data = array(
    ":nm" => $_POST['name'],
    ":em" => $_POST['email'],
    ":pn" => $_POST['phone_number'],
    ":hsh" => $encrypted
);
$stmt->execute($data);
    // After successful processing, you can redirect the user to another page
    header("Location:admin_login.php");
    exit(); // Make sure to exit after redirection to prevent further code execution
  }
}

// If there are errors, you can handle them and display them to the user as needed
// For example, you can loop through $errors and display each error message.
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
  <form action="" method="post">
    <h2>Book Store Signup</h2>
    <label for="name">Name:</label>
    <input name="name" type="text" required>
    <br>
    <label for="email">Email:</label>
    <input name="email" type="text" required>
    <br>
    <label for="phone_number">Phone Number:</label>
    <input name="phone_number" type="number" required>
    <br>
    <label for="hash">Password:</label>
    <input name="hash" type="password" required>
    <br>
    <?php if(isset($error['confirm_hash'])) { ?>
      <p style="color:red"><?php echo $error['confirm_hash']; ?></p>
    <?php } ?>
    
    <label for="confirm_hash">Confirm Password:</label>
    <input name="confirm_hash" type="password" required>
    <br>
    <input name="submit" type="submit" value="Submit">
    <br><br><hr>
    <div class="signup-link">
      <p>Already a user?<a href="admin_login.php"> Login</a></p>
    </div>
  </form>
</body>
</html>
