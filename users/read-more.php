<?php
try {
    include("../includes/db.php"); // Assuming this file contains your database connection details
    include('../includes/user_auth.php');
    
    $pdo = new PDO("mysql:host=localhost;dbname=book_store", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Assuming $id is the book ID you want to retrieve data for
    $id = $_GET['id'];

    $sql = "SELECT * FROM books WHERE id = :id";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch data using a foreach loop
    foreach ($stmt as $row) {
        $bookId = $row['id'];
        $description = $row['description'];
        $limitedDescription = substr($description, 0, 100); // Adjust the character limit as needed
        echo '<div class="book-box">';
        echo '<div class="book">';
        echo '<div class="book-image">';
        echo '<img src="../img/'.$row['image'].'" alt="Book Title">';
        echo '</div>';
        echo '<div class="book-details">';
        echo '<h2>' . $row['book_title'] . '</h2>';
        echo '<p>Description: <span id="short-description-' . $bookId . '">' . $limitedDescription . '...</span>';
        echo '<a href="#" class="see-more-link" onclick="toggleDescription(' . $bookId . ')"> See more</a></p>';
        echo '<div id="full-description-' . $bookId . '" style="display:none;"><p>Full Description: ' . $description . '</p></div>';
        echo '<p>Author: ' . $row['author'] . '</p>';
        echo '<p>Publication Year: ' . $row['publication_year'] . '</p>';
        echo '<p>Publisher: ' . $row['company'] . '</p>';
        echo '<p>Barcode: ' . $row['barcode'] . '</p>';
        echo '<p>ISBN: ' . $row['isbn'] . '</p>';
        echo '<a href="user_home.php" class="btn btn-primary">Back</a>';
        echo '</div>'; // .book-details
        echo '</div>'; // .book
        echo '</div>'; // .book-box
        echo "<hr>";
    }
} catch (PDOException $e) {
    // Log or handle the error appropriately
    echo "Error: " . $e->getMessage();
}
?>

<script>
    function toggleDescription(bookId) {
        var shortDescriptionElement = document.getElementById('short-description-' + bookId);
        var fullDescriptionElement = document.getElementById('full-description-' + bookId);

        if (shortDescriptionElement.style.display === 'none' || shortDescriptionElement.style.display === '') {
            shortDescriptionElement.style.display = 'inline';
            fullDescriptionElement.style.display = 'none';
        } else {
            shortDescriptionElement.style.display = 'none';
            fullDescriptionElement.style.display = 'block';
        }
    }
</script>

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .book-box {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 20px 0;
            overflow: hidden;
            display: flex;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .book-box:hover {
            transform: scale(1.02);
        }

        .book {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .book-image img {
            width: 150px;
            height: auto;
            border-radius: 5px;
            margin-right: 20px;
        }

        .book-details {
            flex: 1;
        }

        .book-details h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        .book-details p {
            margin: 10px 0;
        }

        .see-more-link {
            display: inline-block;
            padding: 5px 10px;
            margin-left: 10px;
            color: #fff;
            background-color: #3498db;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .see-more-link:hover {
            background-color: #2980b9;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-primary {
            color: #fff;
            background-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-secondary {
            color: #fff;
            background-color: #2ecc71;
        }

        .btn-secondary:hover {
            background-color: #27ae60;
        }

        @media (max-width: 768px) {
            .book {
                flex-direction: column;
                align-items: center;
            }

            .book-image img {
                width: 100px;
                margin-bottom: 10px;
            }

            .book-details {
                text-align: center;
            }
        }
    </style>
</head>
