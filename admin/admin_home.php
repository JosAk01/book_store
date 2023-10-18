<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="../users/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>

    // Fetch the cart count from session storage and update the cart count in the navbar
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cart-count').innerText = sessionStorage.getItem('cartCount') || 0;
    });
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
body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        overflow: hidden;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    #header {
        background-color: #333;
        color: white;
        padding: 10px;
        text-align: center;
        width: 100%;
    }

    .side-bar {
        width: 20%;
        background-color: #2c3e50;
        padding-top: 20px;
        height: 100%;
        color: white;
        overflow-y: auto;
    }

    .side-bar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .side-bar li {
        padding: 15px;
        text-align: center;
        cursor: pointer;
    }

    .side-bar a {
        text-decoration: none;
        color: white;
    }

    .side-bar a:hover {
        background-color: #34495e;
    }

    main {
        width: 70%;
        padding: 20px;
        box-sizing: border-box;
        overflow-y: auto;
        margin-left: 20%;
        margin-top: 5vh;
    }

    .admin-dashboard {
        display: flex;
        justify-content: space-around;
        margin-top: 50px;
    }

    .dashboard-item {
        text-align: center;
        background-color: #3498db;
        padding: 20px;
        color: white;
        border-radius: 5px;
        flex: 1;
        margin: 0 10px;
    }

    .dashboard-item i {
        font-size: 40px;
        margin-bottom: 10px;
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
        <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart <div class="cart-count-circle"><span id="cart-count">0</span></div></a></li>
        <li><a href="#"><i class="fas fa-envelope"></i> Inbox</a></li>
        <li><a href="#"><i class="fas fa-cog"></i> Setting</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> LogOut</a></li>

        
    </ul>
</div>
       <main>
       <div class="admin-dashboard">
                <div class="dashboard-item">
                    <i class="fas fa-eye"></i>
                    <h3>Today's Views</h3>
                    <p>1,234</p>
                </div>

                <div class="dashboard-item">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Earnings</h3>
                    <p>$1,234.56</p>
                </div>

                <div class="dashboard-item">
                    <i class="fas fa-users"></i>
                    <h3>Total Users</h3>
                    <p>5,678</p>
                </div>

                <div class="dashboard-item">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Total Book Purchased</h3>
                    <p>789</p>
                </div>
            </div>
        
        </main>
    </div>
</body>
</html>