<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}

try {
    // Database credentials
    $dbHost = 'localhost';
    $dbName = 'book_store';
    $dbUser = 'root';
    $dbPass = '';

    // Database connection
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Form data processing
    $jsonInput = file_get_contents('php://input');
    $jsonData = json_decode($jsonInput, true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($jsonData['book'])) {
        $postdata = $jsonData['book'];

        foreach ($postdata as $book) {
            $checkoutId = generateUniqueID();
            
            // Insert book details
            $stmt = $pdo->prepare("INSERT INTO items ( book_id, book_title, book_image, book_price, book_quantity, book_total, checkout_id) VALUES (  :bookId, :bookTitle, :bookImage, :bookPrice, :bookQuantity, :bookTotal, :checkoutId)");
            $stmt->bindParam(':bookId', $book['bookId']);
            $stmt->bindParam(':bookTitle', $book['bookTitle']);
            $stmt->bindParam(':bookImage', $book['bookImage']);
            $stmt->bindParam(':bookPrice', $book['bookPrice']);
            $stmt->bindParam(':bookQuantity', $book['bookQuantity']);
            $stmt->bindParam(':bookTotal', $book['bookTotal']);
            $stmt->bindParam(':checkoutId', $checkoutId);
            $stmt->execute();
        }

        $response = [
            'status' => 'success',
            'message' => 'Form submitted successfully',
            'data' => $jsonData['book']
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid request method or missing book data'
        ];
    }
} catch (PDOException $e) {
    $response = [
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ];
}

echo json_encode($response);

// Function to generate a unique random number
function generateUniqueID($length = 10) {
  $timestamp = time();
  $randomPart = mt_rand(10000, 99999); // You can adjust the range as needed
  $uniqueID = base_convert($timestamp . $randomPart, 10, 36);

  return $uniqueID;
}
?>
