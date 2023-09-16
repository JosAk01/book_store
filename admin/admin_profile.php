<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/profile_style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Image Upload</title>
</head>
<body>
    <form action="../admin/profile.php" method="post" enctype="multipart/form-data">
        <main class="content">
            <h2>Admin Profile</h2>
            <div class="profile-image">
                <img src="profile.png" alt="" id="profile-image">
            </div>
            <div class="image-upload-container">
                <div class="image-preview">
                    <img src="placeholder.png" alt="Image Preview" id="image-preview">
                </div>
                <label for="file-input" class="file-label">
                    <i class="fas fa-camera"></i>
                    <span>Choose an image</span>
                </label>
                <input type="file" id="file-input" name="file-input" accept="image/*">
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

    <script>
        const fileInput = document.getElementById('file-input');
        const imagePreview = document.getElementById('image-preview');
        
        fileInput.addEventListener('change', () => {
            const selectedFile = fileInput.files[0];
        
            if (selectedFile) {
                const reader = new FileReader();
        
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                };
        
                reader.readAsDataURL(selectedFile);
            }
        });
    </script>
</body>
</html>
