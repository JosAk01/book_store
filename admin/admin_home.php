<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store Admin Dashboard</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>Book Store Admin</h1>
            <ul>
                <li><a href="admin_home.php">Dashboard</a></li>
                <li><a href="add_book.php">Books</a></li>
                <li><a href="order.php">Orders</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <aside class="sidebar">
        <ul>
            <li><a href="#">DashBoard</a></li>
            <li><a href="admin_profile.php">Profile</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="">Books </a></li>
            <li><a href="#">Total Books Purchased <span class="purchase-count"></span></a></li>
        </ul>
    </aside>

    <main class="content">
        <div class="welcome">
            <h2>Welcome to the Book Store Admin Dashboard</h2>
            <p>Here, you can manage books, orders, and users for your book store.</p>
        </div>

        <!-- Dashboard sections -->
        <div class="dashboard-container">
    <div class="dashboard-section">
        <i class="fas fa-chart-line dashboard-icon"></i>
        <div class="dashboard-content">
            <h3>Today's Views</h3>
            <p class="dashboard-info">22,520</p>
        </div>
    </div>

    <div class="dashboard-section">
        <i class="fas fa-dollar-sign dashboard-icon"></i>
        <div class="dashboard-content">
            <h3>Earnings</h3>
            <p class="dashboard-info">$22,520</p>
        </div>
    </div>

    <div class="dashboard-section">
        <i class="fas fa-users dashboard-icon"></i>
        <div class="dashboard-content">
            <h3>Total Users</h3>
            <p class="dashboard-info user-count">500</p>
        </div>
    </div>

    <div class="dashboard-section">
        <i class="fas fa-book dashboard-icon"></i>
        <div class="dashboard-content">
            <h3>Total Books Purchased</h3>
            <p class="dashboard-info purchase-count">2,500</p>
        </div>
    </div>
</div>

    </main>
   
</body>
</html>
