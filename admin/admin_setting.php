<?php
include('../includes/admin_auth.php');
include('../includes/db.php');

if(isset($_GET['id'])){
  $admin_id = $_GET['id'];    
} else {
  header("Location: admin_login.php");    
  exit();
}

$statement = $conn->prepare("SELECT * FROM admin WHERE admin_id=:aid");
$statement->bindParam(":aid", $admin_id);
$statement->execute();

$record = $statement->fetch(PDO::FETCH_BOTH);
if($statement->rowCount() < 1){
  header("location: admin_home.php");
  exit();
}

if(isset($_POST['submit'])){
  $error = array();
  
  if(empty($_POST['admin_name'])) {
      $error['admin_name'] = "Enter Name";    
  }

  if(empty($_POST['email'])) {
      $error['email'] = "Enter Email";
  }

  $error_password = array();

  if (empty($_POST['hash'])) {
      $error_password['hash'] = "Enter Password";
  }

  if (empty($_POST['confirm_hash'])) {
      $error_password['confirm_hash'] = "Confirm Password";
  } elseif ($_POST['hash'] != $_POST['confirm_hash']) {
      $error_password['confirm_hash'] = "Passwords do not match";
  }

  if(empty($error) && empty($error_password)){
      // Hash the password before storing it
      $hashed_password = password_hash($_POST['hash'], PASSWORD_DEFAULT);

      if (!empty($_POST['name']) || !empty($_POST['email']) || !empty($_POST['hash'])) {
          $statement = $conn->prepare("UPDATE admin SET admin_name=:nm, email=:em, hash=:hs WHERE admin_id=:aid");
          $statement->bindParam(":nm", $_POST['admin_name']);
          $statement->bindParam(":em", $_POST['email']);
          $statement->bindParam(":hs", $hashed_password);
          $statement->bindParam(":aid", $admin_id);

          $statement->execute();
      }

      header("Location: message.php?id=" . $_SESSION['admin_id']);


  }		 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Admin Settings</title>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
    var admin_id = <?php echo json_encode($admin_id); ?>;
    var settingLink = document.getElementById('settingLink');

    if (settingLink) {
        settingLink.innerHTML = '<a href="setting.php?id=' + admin_id + '"><i class="fas fa-cog"></i> Setting</a>';
    }
});

    function togglePasswordVisibility(inputId) {
    const passwordInput = document.getElementById(inputId);
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
  }
  setTimeout(function() {
        let disappearingText = document.querySelectorAll('.disappearing-text');
        // console.log(disappearingText)
        // disappearingText.style.display = 'none';
        disappearingText.forEach(element => {
                element.style.display = "none"
        });
        
    }, 2000); // 5000 milliseconds (5 seconds)
</script>
</head>

<body>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 20%;
            height: 100vh;
            background-color: #333;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar li {
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar li:hover {
            background-color: #555;
        }

        .sidebar .active {
            background-color: #555;
        }

        .main {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: scroll;
        }

        .setting {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
        .password-container {
    position: relative;
  }

  .toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
  }
    </style>

    <div class="container">
        <div class="sidebar">
            <h2>Settings</h2>
            <ul>
                <li class="active">Profile</li>
                <li>Security</li>
                <li>Notifications</li>
                <li> <a href="admin_home.php" style="color:#fff">Back</a></li>
            </ul>
        </div>
        <div class="main">
            <h2>User Settings</h2>
        <div class="setting" id="profile">
    <h3>Profile Settings</h3>
    <form action="" method="post">
    <?php if(isset($error['admin_name'])) { ?>
      <p class="disappearing-text" style="color:red"><?php echo $error['admin_name']; ?></p>
    <?php } ?>
        <label for="name">Name:</label>
        <!-- Check if $record is set before using its properties -->
        <input type="text" id="name" name="admin_name" >
        <?php if(isset($error['email'])) { ?>
      <p class="disappearing-text" style="color:red"><?php echo $error['email']; ?></p>
    <?php } ?>
        <label for="email">Email:</label>
        <!-- Check if $record is set before using its properties -->
        <input type="email" id="email" name="email">
        <!-- <button type="submit" name="submit" value="Save Changes">Save Changes</button> -->
</div>

<div class="setting" id="security">
    <h3>Security Settings</h3>
    <?php if(isset($error_password['hash'])) { ?>
      <p class="disappearing-text" style="color:red"><?php echo $error_password['hash']; ?></p>
    <?php } ?>
    <label for="password">New Password:</label>
    <div class="password-container">
        <input type="password" id="password" name="hash">
        <span class="toggle-password" onclick="togglePasswordVisibility('password')">
            &#128065;
        </span>
    </div>
    <?php if(isset($error_password['confirm_hash'])) { ?>
      <p class="disappearing-text" style="color:red"><?php echo $error_password['confirm_hash']; ?></p>
    <?php } ?>
    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirm_hash">
    <button type="submit" name="submit" value="Save Changes">Save Changes</button>
     </form>
            <!-- More settings can be added as needed -->
        </div>
    </div>
</body>

</html>
