<?php
include('../includes/admin_auth.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        header("Location: admin_homepage.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
