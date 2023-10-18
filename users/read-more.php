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
        echo '<img src="../img/lord.jpeg" alt="Book Title">';
        echo '</div>';
        echo "Book Title: " . $row['book_title'] . "<br>";
        echo "Description: <span id='short-description-" . $bookId . "'>" . $limitedDescription . "</span>";
        echo '<a href="#" class="see-more-link" onclick="toggleDescription(' . $bookId . ')"> See more</a><br>';
        echo '<div id="full-description-' . $bookId . '" style="display:none;">Full Description: ' . $description . '</div>';
        echo "Author: " . $row['author'] . "<br>";
        echo "Publication Year: " . $row['publication_year'] . '<br>';
        echo "Publisher:" . $row['company'] . '<br>';
        echo "Barcode:" . $row['barcode'] . '<br>';
        echo "ISBN:" . $row['isbn'] . '<br>';
        echo '<a href="user_home.php" class="btn btn-primary">Back</a>';
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
    <!-- ... Other head content ... -->

    <link rel="stylesheet" href="../style/detail_style.css">

    <!-- ... -->
</head>
