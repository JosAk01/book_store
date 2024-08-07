<?php
include('../includes/db.php'); // Adjust the path as needed

if (isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);
    
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=book_store", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Increment view count
        $sql = "UPDATE books SET view_count = view_count + 1 WHERE id = :book_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->execute();
        
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No book ID provided']);
}
?>
