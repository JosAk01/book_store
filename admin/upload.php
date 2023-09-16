<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Image Upload</title>
    <style>
        /* Style for the image upload container */
        .content {
            margin: 2rem;
            padding: 2rem;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .image-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        /* Style for the image preview */
        .image-preview {
            width: 150px;
            height: 150px;
            border: 2px dashed #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            border-radius: 50%;
        }

        #image-preview {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover; /* Maintains aspect ratio and fills the container */
            border-radius: 15%;
        }

        /* Style for the file label */
        .file-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            margin-top: 10px;
        }

        .file-label i {
            font-size: 32px;
            margin-bottom: 5px;
        }

        /* Hide the file input */
        #file-input {
            display: none;
        }

        .admin-info h3 {
            font-size: 1.2rem;
            margin-top: 20px;
        }

        .admin-info p {
            font-size: 1rem;
            margin: 10px 0;
        }

        .profile {
            text-align: center;
        }

        .profile h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }


input[type="submit"] {
  background-color: #007BFF;
  color: #fff;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 3px;
  margin-top: 10px;
}

input[type="submit"]:hover {
  background-color: #0056b3;
}
    </style>
</head>
<body>
    <form action="../admin/profile.php" method="post">
<main class="content">
    <h2>Admin Profile</h2>
    <div class="image-upload-container">
        <div class="image-preview">
            <img src="placeholder.png" alt="Image Preview" id="image-preview">
        </div>
        <label for="file-input" class="file-label">
            <i class="fas fa-camera"></i>
            <span>Choose an image</span>
        </label>
        <input type="file" id="file-input" accept="image/*">
        <input type="submit" id="save-button" value="Submit">
    </div>
    <div class="admin-info">
        <h3>Admin Name</h3>
        <p>Email: admin@example.com</p>
        <p>Role: Administrator</p>
        <!-- Add more admin-specific details as needed -->
    </div>
</main>
    </form>
</body>
</html>
