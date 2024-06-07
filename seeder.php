
<?php
try {
    include("vendor/autoload.php");

    class Language
    {
        const ENGLISH = 'english';
        const FRENCH = 'french';
        const YORUBA = 'yoruba';
        const GERMAN = 'german';
        const KOREAN = 'korean';
    }
    class Image
    {
        const IMAGE1 = 'lord.jpeg';
        const IMAGE2 = 'outsiders.jpeg';
        const IMAGE3 = 'faults.jpg';
        const IMAGE4 = 'night.jpeg';
    }
    // Replace these with your actual database credentials
    $dbHost = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "book_store";

    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $faker = Faker\Factory::create();
     $data = array();
    for ($i = 0; $i < 10; $i++) {
        $bookId = $faker->unique()->randomNumber(1);
        $bookTitle = $faker->sentence(4);
        $shortDescription = $faker->sentence();
        $description = $faker->paragraph(100);
        $author = $faker->title($gender = 'male'|'female') . " " . $faker->name();
        $publicationYear = $faker->date();
        $country = $faker->country();
        $company = $faker->company();
        $price = $faker->numberBetween(2000, 8000) . "NGN";
        $barcode = $faker->ean8();
        $isbn = $faker->ean13();
        $language = $faker->sentences(1);
        $image = $faker->randomElement([
            Image::IMAGE1,
            Image::IMAGE2,
            Image::IMAGE3,
            Image::IMAGE4,
        ]);
        

        $language = $faker->randomElement([
            Language::ENGLISH,
            Language::FRENCH,
            Language::YORUBA,
            Language::GERMAN,
            Language::KOREAN,
        ]);
        $Image = $faker->randomElement([
            Image::IMAGE1,
            Image::IMAGE2,
            Image::IMAGE3,
            Image::IMAGE4,
        ]);

        $sql = "INSERT INTO books (book_title, description, author, publication_year, country, company, price, barcode, isbn, languages, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
       $stmt = mysqli_prepare($conn, $sql);

       mysqli_stmt_bind_param($stmt, "sssssssssss", $bookTitle, $description, $author, $publicationYear, $country, $company, $price, $barcode, $isbn, $language, $image);

        mysqli_stmt_execute($stmt);

    }
   // echo 'seeder sucessful';
// var_dump($data);
// echo(json_encode($data));
   echo "Fake entries inserted successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
