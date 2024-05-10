<?php
include('../includes/db.php');
include('../vendor/autoload.php');

$faker = Faker\Factory::create();
// $data = array();
for ($i = 0; $i < 10; $i++) {
  $data[$i]['reference_no'] = $faker->ean8();
  $data[$i]['orders_details'] = $faker->paragraph(10);
  $data[$i]['total_amount'] = $faker->randomFloat(1, 20, 30) . "$";
  $data[$i]['created_at'] = $faker->date();
  $data[$i]['updated_at'] = $faker->time();
  $data[$i]['status'] = $faker->sentence(2);
}
echo(json_encode($data));
?>

try {
    // ... (database connection code remains the same)

    $pdo->beginTransaction(); // Start a transaction

    $sqlCheckout = "INSERT INTO items (checkout_id) VALUES (:checkoutId)";
    $stmtCheckout = $pdo->prepare($sqlCheckout);
    $stmtCheckout->bindParam(':checkoutId', $checkoutId);

    $sql = "INSERT INTO items (checkout_id, book_id, book_title, book_image, book_price, book_quantity, book_total) VALUES (:checkoutId, :bookId, :bookTitle, :bookImage, :bookPrice, :bookQuantity, :bookTotal)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':checkoutId', $checkoutId);
    $stmt->bindParam(':bookId', $bookId);
    $stmt->bindParam(':bookTitle', $bookTitle);
    $stmt->bindParam(':bookImage', $book['bookImage']);
    $stmt->bindParam(':bookPrice', $book['bookPrice']);
    $stmt->bindParam(':bookQuantity', $book['bookQuantity']);
    $stmt->bindParam(':bookTotal', $book['bookTotal']);

    foreach ($postdata as $book) {
        try {
            $checkoutId = generateUniqueID();
            $stmtCheckout->execute();

            // Check if key exists before accessing the value
            $bookId = isset($book['bookId']) ? $book['bookId'] : null;
            $bookTitle = isset($book['bookTitle']) ? $book['bookTitle'] : null;
            $bookImage = isset($book['bookImage']) ? $book['bookImage'] : null;
            $bookPrice = isset($book['bookPrice']) ? $book['bookPrice'] : null;
            $bookQuantity = isset($book['bookQuantity']) ? $book['bookQuantity'] : null;
            $bookTotal = isset($book['bookTotal']) ? $book['bookTotal'] : null;

            $stmt->execute();
        } catch (PDOException $e) {
            // Roll back the transaction on error
            $pdo->rollBack();

            $response = [
                'status' => 'error',
                'message' => "Error inserting book: " . $e->getMessage()
            ];

            // You may want to exit the loop on error or handle it appropriately
            break;
        }
    }

    // Commit the transaction if no errors occurred
    $pdo->commit();

    $response = [
        'status' => 'success',
        'message' => "Form submitted successfully",
        'data' => $jsonData['book']
    ];
} catch (PDOException $e) {
    $response = [
        'status' => 'error',
        'message' => "Database connection error: " . $e->getMessage()
    ];
}
function generateUniqueID() {
  // Generate a unique ID based on the current timestamp and more entropy
  $uniqueId = uniqid();

  // Extract the timestamp part (10 characters) from the unique ID
  $timestampPart = substr($uniqueId, 0, 10);

  // Generate a random alphanumeric component (you can adjust the length as needed)
  $randomPart = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 6);

  // Combine timestamp and random component to create a unique ID
  $uniqueID = $timestampPart . $randomPart;

  return $uniqueID;
}