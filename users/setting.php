<?php
session_start();
include "../includes/user_auth.php";
include '../includes/db.php';
// require_once '../vendor/autoload.php';

// // Gmail API credentials
// $client = new Google_Client();
// $client->setAuthConfig('path/to/credentials.json');
// $client->setAccessType('offline');
// $client->setScopes(Google_Service_Gmail::GMAIL_SEND);

// // Set the access token (you need to implement a proper authentication flow to obtain this)
// $accessToken = 'your_access_token';
// $client->setAccessToken($accessToken);

// // Create Gmail service
// $gmailService = new Google_Service_Gmail($client);

// // Function to send a notification email
// function sendNotificationEmail($to, $subject, $message)
// {
//     global $gmailService;

//     $mime = rtrim(strtr(base64_encode(sprintf(
//         "From: %s\r\nTo: %s\r\nSubject: %s\r\n\r\n%s",
//         'your@gmail.com', // Sender's email address
//         $to,
//         $subject,
//         $message
//     )), '+/', '-_'), '=');

//     $message = new Google_Service_Gmail_Message();
//     $message->setRaw($mime);

//     // Send the email
//     try {
//         $gmailService->users_messages->send('me', $message);
//     } catch (Exception $e) {
//         echo 'Error sending notification: ' . $e->getMessage();
//     }
// }

// if (isset($_POST['submit'])) {
//     // ... (Your existing code)

//     // Send notification email
//     $to = 'recipient@gmail.com'; // Replace with the recipient's email address
//     $subject = 'User Settings Updated';
//     $message = 'User settings have been successfully updated.';

//     sendNotificationEmail($to, $subject, $message);

//     header("location: user_home.php");
//     exit();
// }

if(isset($_GET['id'])){
    $user_id = $_GET['id'];    
} else {
    header("Location: user_login.php");    
    exit();
}

$statement = $conn->prepare("SELECT * FROM users WHERE user_id=:uid");
$statement->bindParam(":uid", $user_id);
$statement->execute();

$record = $statement->fetch(PDO::FETCH_BOTH);
if($statement->rowCount() < 1){
    header("location: user_home.php");
    exit();
}

if(isset($_POST['submit'])){
    $error = array();
    
    if(empty($_POST['name'])) {
        $error['name'] = "Enter Name";    
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
            $statement = $conn->prepare("UPDATE users SET name=:nm, email=:em, hash=:hs WHERE user_id=:uid");
            $statement->bindParam(":nm", $_POST['name']);
            $statement->bindParam(":em", $_POST['email']);
            $statement->bindParam(":hs", $hashed_password);
            $statement->bindParam(":uid", $user_id);

            $statement->execute();
        }

        header("location: user_home.php");

    }		 
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>User Settings</title>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the user ID from PHP and update the href attribute
        var user_id = <?php echo json_encode($user_id); ?>;
        var settingLink = document.getElementById('settingLink');
        settingLink.innerHTML = '<a href="setting.php?id=' + user_id + '"><i class="fas fa-cog"></i> Setting</a>';
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
                <li> <a href="user_home.php" style="color:#fff">Back</a></li>
            </ul>
        </div>
        <div class="main">
            <h2>User Settings</h2>
        <div class="setting" id="profile">
    <h3>Profile Settings</h3>
    <form action="" method="post">
    <?php if(isset($error['name'])) { ?>
      <p class="disappearing-text" style="color:red"><?php echo $error['name']; ?></p>
    <?php } ?>
        <label for="name">Name:</label>
        <!-- Check if $record is set before using its properties -->
        <input type="text" id="name" name="name" >
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
