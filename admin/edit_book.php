<?php
include('../includes/admin_auth.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];
    $country = $_POST['country'];
    $company = $_POST['company'];
    $price = $_POST['price'];
    $barcode = $_POST['barcode'];
    $isbn = $_POST['isbn'];
    $language = $_POST['languages'];
    
    // Extract filename from the image path
    $image = basename($_POST['image']);

    try {
        $sql = "UPDATE books SET book_title = ?, description = ?, author = ?, publication_year = ?, country = ?, company = ?, price = ?, barcode = ?, isbn = ?, languages = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $description, $author, $publication_year, $country, $company, $price, $barcode, $isbn, $languages, $image, $id]);
        header("Location: admin_home.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
