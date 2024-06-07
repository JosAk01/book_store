<?php
include('../includes/user_auth.php');

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
// if(isset($_GET['user_id'])){
//     $user_id = $_GET['user_id'];}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    
</script>
<style>
    .cart-count-circle {
  display: inline-block;
  background-color: red;
  color: white;
  border-radius: 50%;
  padding: 0.2em 0.5em; /* Adjust as needed for size */
  margin-left: 5px; /* Adjust as needed for spacing */
}
.cart-button {
    position: relative;
}
#cart-count {
    font-weight: bold;
}
.modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Style for the overlay background */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Style for the button */
        .logout-button {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none; /* Added to remove underline for the link */
        }
</style>
</head>
<body>
    <div class="container">
        <div id="header">
        <h1 id="logo">Book Store</h1>
        </div>

<div class="side-bar">
    <ul>
        <li><a class="active" href="user_home.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart <div class="cart-count-circle"><span id="cart-count"><?php echo $cartCount; ?></span></div></a></li>
        <li id="settingLink"><a href="setting.php?id=<?php echo  $_SESSION['user_id']; ?>"><i class="fas fa-cog"></i> Setting</a></li>
        <li><a href="#"><i class="fas fa-envelope"></i> Inbox</a></li>
        <li><a href="#"><i class="fa fa-file-invoice"></i>Invoice</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> LogOut</a></li>
    </ul>
</div>

        <main class="main">
        <?php
try {
    include("../includes/db.php"); // Assuming this file contains your database connection details

    $pdo = new PDO("mysql:host=localhost;dbname=book_store", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM books"; // Modify this query based on your database structure and conditions

    $stmt = $pdo->query($sql);

    foreach ($stmt as $row) {
        $id = $row['id'];

        // Display only the first 100 characters of the description
        $limitedDescription = substr($row['description'], 0, 500) . '...';

        // HTML code
        echo '<div class="book-box">';
        echo '<div class="book">';
        echo '<div class="book-image">';
        echo '<img src="../img/'.$row['image'].'" alt="Book Image">';
        echo '</div>';
        echo '<div class="book-details">';
        echo '<h2>' . $row['book_title'] . '</h2>';
        echo '<p style="font-family: \'Bebas Neue\', sans-serif;">' . $limitedDescription . '</p>';

        // Other book details...

        // Read More link with dynamic book_id
        echo '<a href="read-more.php?id=' . $id . '" class="read-more"><i class="fas fa-book"></i> Read More</a>';
        // Add some spacing (for example, a non-breaking space)
        echo '&nbsp;';
        // echo '<a href="javascript:void(0)"  onclick="addToCart(' . $id . ')" class="add-to-cart btn btn-primary"><i class="fas fa-shopping-cart"></i>Add to cart</a>';
        // Add to Cart button with two different hrefs
        echo '<a href="javascript:void(0)" class="btn btn-primary add-to-cart" data-id="' . $row['id'] . '" data-title="' . $row['book_title'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] . '">Add to Cart</a>';
        echo '<p style="color:red; margin-top: 10px;">PRICE: NGN - ' . $row['price'] . '</p>';

        // Closing HTML tags
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} catch (PDOException $e) {
    // Log or handle the error appropriately
    echo "Error: " . $e->getMessage();
}
?>




        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>