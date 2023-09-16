<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Book Store</title>
    <link rel="stylesheet" type="text/css" href="../style/style_dashboard.css">

</head>
<body>
    <header>
        <h1>Welcome, Admin</h1>
        <a href="logout.php">Logout</a>
    </header>
    
    <nav>
        <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="#books">Books</a></li>
            <li><a href="#orders">Orders</a></li>
            <li><a href="#customers">Customers</a></li>
            <li><a href="#analytics">Sales Analytics</a></li>
            <li><a href="#inventory">Inventory</a></li>
            <li><a href="#profile">Profile</a></li>
        </ul>
    </nav>

    <main>
        <section id="dashboard">
            <h2>Dashboard Overview</h2>
            <p>Total Books: 500</p>
            <p>Total Sales: $10,000</p>
            <p>New Orders: 5</p>
        </section>

        <section id="books">
            <h2>Book Management</h2>
            <ul>
                <li><a href="add_book.php">Add New Book</a></li>
                <li><a href="manage_books.php">Manage Books</a></li>
                <li><a href="update_book_info.php">Update Book Information</a></li>
            </ul>
        </section>

        <section id="orders">
            <h2>Order Management</h2>
            <ul>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="process_orders.php">Process Orders</a></li>
            </ul>
        </section>

        <section id="customers">
            <h2>Customer Management</h2>
            <ul>
                <li><a href="manage_customers.php">Manage Customers</a></li>
                <li><a href="view_customer_orders.php">View Customer Orders</a></li>
            </ul>
        </section>

        <section id="analytics">
            <h2>Sales Analytics</h2>
            <!-- Add charts/graphs for sales analytics here -->
        </section>

        <section id="inventory">
            <h2>Inventory Management</h2>
            <!-- Add inventory management options here -->
        </section>

        <section id="profile">
            <h2>User Profile</h2>
            <ul>
                <li><a href="edit_profile.php">Edit Profile</a></li>
                <li><a href="change_password.php">Change Password</a></li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Book Store</p>
    </footer>
</body>
</html>
