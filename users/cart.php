<?php
include('../includes/db.php');
include('../includes/user_auth.php');

// Fetch user ID from session
$userId = $_SESSION['user_id'];

// Fetch user email from database
$sql = "SELECT email FROM users WHERE user_id = :userId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$userEmail = $user['email'];
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
        <div class="column-labels">
            <label class="book-image">Image</label>
            <label class="book-details">Title</label>
            <label class="book-price">Price</label>
            <label class="book-quantity">Quantity</label>
            <label class="book-removal">Removal</label>
            <label class="book-line-price">Total</label>
        </div>
        <div id="cart_summary"></div>
    </div>

    <div class="total">
        <div class="totals-item">
            <label>Subtotal:</label>
            <div class="totals-value" id="cart-subtotal">0.00</div>
        </div>
        <div class="totals-item">
            <label>Tax (0.075%):</label>
            <div class="totals-value" id="cart-tax">0.00</div>
        </div>
        <div class="totals-item totals-item-total">
            <label>Grand Total:</label>
            <div class="totals-value" id="cart-total">0.00</div>
        </div>
    </div>

    <button class="checkout" id="checkoutButton">Checkout</button>

    <!-- Hidden input fields for email and grand total -->
    <input type="hidden" id="email" value="<?php echo htmlspecialchars($userEmail); ?>">
    <input type="hidden" id="amount" value="">
    <input type="hidden" id="metadata" value="">

    <button class="back" id="back">Back</button>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="cart_script.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
    let bookCart = sessionStorage.getItem('book-cart');
    let cart_summary = document.getElementById('cart_summary');
    let checkoutItems = [];
    let grandTotal = 0;

    if (bookCart) {
        bookCart = JSON.parse(bookCart);

        bookCart.forEach((element, index) => {
            const book_id = element.book_id;
            const book_title = element.book_title;
            const book_image = element.image;
            const book_price = parseFloat(element.price);
            const bookQuantity = 1; // Default value

            // Calculate the total for this item
            let bookTotal = book_price * bookQuantity;
            grandTotal += bookTotal; // Add to grand total

            // Create an object to represent the cart item
            const cartItem = {
                item: book_title,
                quantity: bookQuantity,
                price: book_price
            };

            // Add the cart item to the checkoutItems array
            checkoutItems.push(cartItem);

            // Update the UI to display the item
            cart_summary.innerHTML += `
                <div class="book">
                    <div class="book-image"><img src="../img/${book_image}"></div>
                    <div class="book-details">
                        <div class="book-title">${book_title}</div>
                    </div>
                    <div class="book-price">${book_price.toFixed(2)}</div>
                    <div class="book-quantity">
                        <input type="number" value="${bookQuantity}" min="1" onchange="updateHiddenFields(${index + 1}, this.value)">
                    </div>
                    <div class="book-removal">
                        <button class="remove-book" onclick="removeBook(${index})">Remove</button>
                    </div>
                    <div class="book-line-price">${bookTotal.toFixed(2)}</div>
                </div>`;
        });

        // Update the grand total in the hidden input field
        document.getElementById('amount').value = Math.round(grandTotal * 100); // Convert to kobo and round to integer
        document.getElementById('cart-total').innerText = grandTotal.toFixed(2);

        // Update the metadata input field with the checkoutItems JSON string
        document.getElementById('metadata').value = JSON.stringify(checkoutItems);
    }

    // Function to update hidden fields when quantity changes
    function updateHiddenFields(index, newValue) {
        const bookPrice = checkoutItems[index - 1].price;
        const bookQuantity = parseInt(newValue, 10);
        const bookTotal = (bookPrice * bookQuantity).toFixed(2); // Rounded to 2 decimal places
        checkoutItems[index - 1].quantity = bookQuantity;

        // Update the grand total
        let newGrandTotal = 0;
        checkoutItems.forEach(item => {
            newGrandTotal += item.price * item.quantity;
        });

        document.getElementById('cart-total').innerText = newGrandTotal.toFixed(2);
        document.getElementById('amount').value = Math.round(newGrandTotal * 100); // Convert to kobo and round to integer

        // Update the metadata input field with the updated checkoutItems JSON string
        document.getElementById('metadata').value = JSON.stringify(checkoutItems);
    }

    // Function to remove a book from the cart
    function removeBook(index) {
        checkoutItems.splice(index, 1); // Remove the item from checkoutItems
        bookCart.splice(index, 1); // Remove the item from bookCart
        sessionStorage.setItem('book-cart', JSON.stringify(bookCart)); // Update session storage
        location.reload(); // Reload the page to update the UI
    }

    // Add an event listener to the checkout button
    document.getElementById('checkoutButton').addEventListener('click', function() {
        fetch('store_checkout_items.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({book: checkoutItems})
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Redirect to the Paystack payment page
            payWithPaystack();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Paystack payment function
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: 'pk_test_e77ee04a3320937331b6a7ecb39ac1e5b8878aa8', // Replace with your public key
            email: document.getElementById('email').value,
            amount: parseInt(document.getElementById('amount').value, 10), // Ensure amount is an integer
            currency: 'NGN',
            ref: '' + Math.floor((Math.random() * 1000000000) + 1), // Generate a random reference number
            metadata: {
                custom_fields: checkoutItems.map((item, index) => ({
                    display_name: `Item ${index + 1}`,
                    variable_name: `item_${index}`,
                    value: JSON.stringify(item)
                }))
            },
            callback: function(response) {
                // Redirect to the verification page
                window.location.href = 'verify_transaction.php?reference=' + response.reference;
            },
            onClose: function() {
                alert('Transaction was not completed, window closed.');
            }
        });
        handler.openIframe();
    }

    document.getElementById('back').addEventListener('click', function() {
        window.location.href = 'user_home.php';
    });
</script>
</body>
</html>
