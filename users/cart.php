<?php
include('../includes/db.php');
include('../includes/user_auth.php');
// Handle incoming cart data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cartData = json_decode(file_get_contents("php://input"), true);

    foreach ($cartData as $item) {
        $bookId = $item['bookId'];
        $bookQuantity = $item['bookQuantity'];
        $bookTotal = $item['bookTotal'];

        
        // Insert the data into the database (update the SQL query as needed)
        $sql = "INSERT INTO orders (book_id, quantity, total) VALUES (:bookId, :bookQuantity, :bookTotal)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':bookId', $bookId);
        $stmt->bindParam(':bookQuantity', $bookQuantity);
        $stmt->bindParam(':bookTotal', $bookTotal);

        if ($stmt->execute()) {
            // Data inserted successfully
        } else {
            // Handle the error
            echo "Error: " . $stmt->errorCode() . "<br>";
            print_r($stmt->errorInfo());
        }
    }

    $faker = Faker\Factory::create();
    //  $data = array();
    for ($i = 0; $i < 10; $i++) {

         
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Shopping Cart</h1>
    <div class="shopping-cart">
        <div class="column-labels" id="">
            <label class="book-image">Image</label>
            <label class="book-details">Title</label>
            <label class="book-price">Price</label>
            <label class="book-quantity">Quantity</label>
            <label class="book-removal">Removal</label>
            <label class="book-line-price">Total</label>
        </div>
     <div id="cart_summary">
        

        <!-- <div class="book">
            <div class="book-image">
                <img src="../img/outsiders.jpeg">
            </div>
            <div class="book-details">
                <div class="book-title">Nemo enim cumque unde.</div>
                <p class="book-description">Aspernatur ipsum aperiam sit nihil ducimus enim animi. Et saepe possimus numquam quisquam dolore.</p>
            </div>
            <div class="book-price">25</div>
            <div class="book-quantity">
                <input type="number" value="1" min="1">
            </div>
            <div class="book-removal">
                <button class="remove-book">
                    Remove
                </button>
            </div>
            <div class="book-line-price">25</div>
        </div> -->
     </div>

    </div>

    
        <div class="total">
            <div class="totals-item">
              <label>Subtotal:</label>
              <div class="totals-value" id="cart-subtotal">0.00</div>
            </div>
            <div class="totals-item">
              <label>Tax (0.075%):</label>
              <div class="totals-value" id="cart-tax" >0.00</div>
            </div>
            <div class="totals-item totals-item-total">
              <label>Grand Total:</label>
              <div class="totals-value" id="cart-total">0.00</div>
            </div>
        </div>

        <button class="checkout" id="checkoutButton">Checkout</button>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="cart_script.js"></script>
    <!-- Add hidden input fields for bookQuantity and bookTotal -->
<input type="hidden" id="hiddenBookQuantity" value="1">
<input type="hidden" id="hiddenBookTotal" value="0">
<button class="back" id="back">Back</button>
<script>
    let bookCart = sessionStorage.getItem('book-cart');
    let cart_summary = document.getElementById('cart_summary');
    let checkoutItems = [];

    bookCart = JSON.parse(bookCart);

    bookCart.forEach(element => {
        // console.log(element);
        const book_id = element.book_id;
        let book_title = element.book_title;
        const book_image = element.image;
        const book_price = element.price;
        let bookQuantity = 1; // Default value

        // Calculate the total for this item (initialize as 0)
        let bookTotal = book_price * bookQuantity;

        // Create an object to represent the cart item
        const cartItem = {
            bookId: book_id,
            bookTitle: book_title,
            bookImage: book_image,
            bookPrice: book_price,
            bookQuantity: bookQuantity,
            bookTotal: bookTotal
        };

        // Add the cart item to the checkoutItems array
        checkoutItems.push(cartItem);

        // console.log(checkoutItems)
        // Update the UI to display the item
        cart_summary.innerHTML += '<div class="book"> <div class="book-image"><img src="../img/' + book_image + '"> </div>  <div class="book-details"> <div class="book-title">' + book_title + '</div> </div> <div class="book-price">' + book_price + '</div> <div class="book-quantity"> <input type="number" value="1" min="1" onchange="updateHiddenFields(' + checkoutItems.length + ', this.value)"></div><div class="book-removal"> <button class="remove-book"> Remove</button></div> <div class="book-line-price">' + book_price + '</div> </div>';
    });

    // Function to update hidden fields when quantity changes
    function updateHiddenFields(index, newValue) {
        const bookPrice = checkoutItems[index - 1].bookPrice;
        const bookQuantity = parseInt(newValue, 10);
        const bookTotal = (bookPrice * bookQuantity).toFixed(2); // Rounded to 2 decimal places
        checkoutItems[index - 1].bookQuantity = bookQuantity;
        checkoutItems[index - 1].bookTotal = bookTotal;

        // Update the hidden input fields
        document.getElementById('hiddenBookQuantity').value = bookQuantity;
        document.getElementById('hiddenBookTotal').value = bookTotal;
    }
    // Add an event listener to the checkout button
    document.getElementById('checkoutButton').addEventListener('click', function() {
        // You can access the selected cart items in the checkoutItems array here
        // ajax call
        var dataToSend = {
            checkoutItems: checkoutItems
        };

        console.log('Data to send:', dataToSend);
        $.ajax({
            type: "POST",
            url: "store_checkout_items.php",
            data: 'dataToSend',
            success: function(responseData) {
              console.log(responseData)
                alert("data saved")
            },
            error: function(error) {
                console.log(error);
            }
        })


        //Using sessionStorage
        // sessionStorage.setItem('checkoutItems', JSON.stringify(checkoutItems));


        // window.location.href = 'checkout.php';
    });
    document.getElementById('back').addEventListener('click', function(){
        window.location.href = 'user_home.php';
    });
</script>

</body>
</html>
