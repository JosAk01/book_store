<?php
include('../includes/admin_auth.php');
include('../includes/db.php');

$admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : null;

// Count the total number of admin records in the database
$query_admins = "SELECT COUNT(*) as total_admins FROM users";
$stmt_admins = $conn->prepare($query_admins);
$stmt_admins->execute();
$result_admins = $stmt_admins->fetch(PDO::FETCH_ASSOC);

// Count for books
$query_books = "SELECT COUNT(*) as total_books FROM books";
$stmt_books = $conn->prepare($query_books);
$stmt_books->execute();
$result_books = $stmt_books->fetch(PDO::FETCH_ASSOC);

if ($result_admins && $result_books) {
    // Total number of admin records
    $total_admins = $result_admins['total_admins'];
    $total_books = $result_books['total_books'];
} else {
    // Handle the case where the count query fails (e.g., display an error)
    echo "Failed to retrieve the total number of admins.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
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

        .side-bar {
            width: 250px;
            background-color: #002060;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .sidebar .logo {
            text-align: center;
        }
        .side-bar ul {
            list-style: none;
            padding: 0;
        }

        .side-bar li {
            margin: 20px 0;
        }

        .side-bar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .side-bar a:hover {
            background-color: #34495e;
        }

        main {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
            margin-top: 5vh;
        }

        .admin-dashboard {
            display: flex;
            justify-content: space-around;
        }

        .dashboard-item {
            text-align: center;
            background-color: #002060;
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
        .details {
            border: 2px solid #002060;
            background-color: gray;
            margin-top: 20px;
            border-radius: 5px;
            height: auto;
        }
        .filter-sort {
            text-align: left;
            font-weight: bold;
            padding: 8px 2px;
        }
        .book-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .book-item {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .book-item img {
            width: 100px;
            height: auto;
            margin-right: 20px;
            border-radius: 5px;
        }

        .book-info {
            display: flex;
            flex-direction: column;
        }

        .book-info h3 {
            margin: 0;
            margin-bottom: 5px;
        }

        .book-info p {
            margin: 0;
            margin-bottom: 5px;
            color: #555;
        }

        .book-info span {
            font-weight: bold;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }

        .edit-btn, .delete-btn, .read-btn {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #e53935;
        }
        .read-btn, .read-more {
            background-color: #002060;
            color: white;
            text-decoration: none;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #ffffff;
            margin: 5% auto;
            padding: 20px;
            border: 2px solid #6c63ff;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal h2 {
            color: #6c63ff;
        }

        .modal label {
            display: block;
            margin-top: 10px;
            color: #333;
        }

        .modal input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            background-color: #6c63ff;
            color: white;
            font-size: 16px;
        }

        .modal button:hover {
            background-color: #5751d1;
        }
        /* Style for image path input */
        #edit-image-path {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }

        /* Style for image preview */
        #edit-image-preview {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
<div class="container">

    <div class="side-bar">
        <div class="logo">
            <h2>BookStore</h2>
        </div>
        <ul>
            <li><a class="active" ><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Inbox</a></li>
            <li><a href="users.php"><i class="fa fa-user"></i> Users</a></li>
            <li id="settingLink"><a href="admin_setting.php?id=<?php echo  $_SESSION['admin_id']; ?>"><i class="fas fa-cog"></i> Setting</a></li>
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
                <p><?php echo $total_admins; ?></p>
            </div>

            <div class="dashboard-item">
                <i class="fas fa-shopping-cart"></i>
                <h3>Total Book Purchased</h3>
                <p>789</p>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-book"></i>
                <h3>Total Book Available</h3>
                <p><?php echo $total_books; ?></p>
            </div>
        </div>
        <div class="details">
            <div class="header">
                <div class="filter-sort">Filter & Sort</div>
                <span><?php echo $total_books; ?> Items</span>
            </div>
            <div class="book-list">
                <div class="book-item">
                    <img src="../img/lord.jpeg" alt="Book Image">
                    <div class="book-info">
                        <h3>We of the Never-Never</h3>
                        <p>Vintage Classics</p>
                        <p>Aeneas Gunn</p>
                        <span>$54.00</span>
                        <div class="buttons">
                            <button class="edit-btn" onclick="openEditModal('We of the Never-Never', 'Aeneas Gunn', '54.00', '../img/lord.jpeg')">Edit</button>
                            <button class="delete-btn" onclick="openDeleteModal()">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PHP code to fetch and display book details -->
            <?php
            try {
                $sql = "SELECT * FROM books"; // Modify this query based on your database structure and conditions
                $stmt = $conn->query($sql);

                foreach ($stmt as $row) {
                    $id = $row['id'];
                    $limitedDescription = substr($row['description'], 0, 500) . '...';

                    echo '<div class="book-list">';
                    echo '<div class="book-item">';
                    echo '<img src="../img/' . $row['image'] . '" alt="Book Image">';
                    echo '<div class="book-info">';
                    echo '<h2>' . $row['book_title'] . '</h2>';
                    echo '<p style="font-family: \'Bebas Neue\', sans-serif;">' . $limitedDescription . '</p>';
                    echo '<p style="color:red; margin-top: 10px;">PRICE: $' . $row['price'] . '</p>';
                    echo '<div class="buttons">
                            <button class="edit-btn" onclick="openEditModal(\'' . $row['book_title'] . '\', \'' . $row['description'] . '\', \'' . $row['author'] . '\', \'' . $row['publication_year'] . '\', \'' . $row['country'] . '\', \'' . $row['company'] . '\', \'' . $row['price'] . '\', \'' . $row['barcode'] . '\', \'' . $row['isbn'] . '\', \'' . $row['languages'] . '\', \'../img/' . $row['image'] . '\', ' . $id . ')">Edit</button>
                            <button class="delete-btn" onclick="openDeleteModal(' . $id . ')">Delete</button>
                            <button class="read-btn" ><a href="read-more.php?id=' . $id . '" class="read-more"> Read More</a></button>
                          </div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </main>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Book</h2>
        <form id="editForm" method="POST" action="edit_book.php">
            <input type="hidden" id="edit-book-id" name="id">
            <label for="title">Title</label>
            <input type="text" id="edit-title" name="title">
            <label for="description">Description</label>
            <input type="text" id="edit-description" name="description">
            <label for="author">Author</label>
            <input type="text" id="edit-author" name="author">
            <label for="publication_year">Publication Year</label>
            <input type="text" id="edit-publication_year" name="publication_year">
            <label for="country">Country</label>
            <input type="text" id="edit-country" name="country">
            <label for="company">Company</label>
            <input type="text" id="edit-company" name="company">
            <label for="price">Price</label>
            <input type="text" id="edit-price" name="price">
            <label for="barcode">Barcode</label>
            <input type="text" id="edit-barcode" name="barcode">
            <label for="isbn">ISBN</label>
            <input type="text" id="edit-isbn" name="isbn">
            <label for="languages">Language</label>
            <input type="text" id="edit-languages" name="languages">
            <label for="edit-image-path">Image Path</label>
            <input type="text" id="edit-image-path" name="image" readonly>
            <label for="edit-image-upload">Upload New Image</label>
            <input type="file" id="edit-image-upload" accept="image/*" onchange="previewImage(this)">
            <img id="edit-image-preview" src="#" alt="Preview" style="display: none;">
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Are you sure you want to delete this book?</h2>
        <form id="deleteForm" method="POST" action="delete_book.php">
            <input type="hidden" id="delete-book-id" name="id">
            <button type="submit">Yes</button>
            <button type="button" onclick="closeDeleteModal()">No</button>
        </form>
    </div>
</div>

<script src="../includes/script.js">
</script>
</body>
</html>
