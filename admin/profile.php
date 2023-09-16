<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["file-input"]) && $_FILES["file-input"]["error"] == 0) {
        $targetDir = "../img";  // Specify your desired upload directory
        $targetFile = $targetDir . basename($_FILES["file-input"]["name"]);
    
        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $targetFile)) {
            // Image saved successfully; update the profile image
            copy($targetFile, "profile.png");  // Replace with your desired profile image path
            unlink($targetFile);  // Remove the temporary uploaded file
            echo "Image saved successfully!";
        } else {
            echo "Failed to move the uploaded image.";
        }
    } else {
        echo "No image selected or an error occurred.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary meta tags, stylesheets, and other headers -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="your-styles.css">
    <title>Image Upload Result</title>
</head>
<body>
    <div class="result">
        
        <a href="../admin/admin_home.php">Back to Admin Home</a>
    </div>
</body>
</html>
