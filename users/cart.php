<?php
include('../includes/db.php');
include('../includes/user_auth.php');

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

        <div class="book">
        <div class="book-image">
            <img src="../img/night.jpeg">
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
        </div>
        <!-- YOU CAN ADD MORE-->

        <div class="totals">
            <div class="totals-item">
              <label>Subtotal</label>
              <div class="totals-value" id="cart-subtotal">25</div>
            </div>
            <div class="totals-item">
              <label>Tax (5%)</label>
              <div class="totals-value" id="cart-tax" >1.25</div>
            </div>
            <div class="totals-item totals-item-total">
              <label>Grand Total</label>
              <div class="totals-value" id="cart-total">26.25</div>
            </div>
        </div>

        <button class="checkout">Checkout</button>
    </div>
    <script>
        let bookCart = sessionStorage.getItem('book-cart');

        bookCart = JSON.parse(bookCart);

        console.log(bookCart);
    </script>
</body>
</html>