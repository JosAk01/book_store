$(document).ready(function () {
  /* set rates + misc */
  var taxRate = 0.075;
  var fadeTime = 300;
  var grandTotal = 0; // Initialize the grand total variable

  /* Assign actions */
  $('.book-quantity input').change(function () {
    updateQuantity(this);
  });

  $('.book-removal button').click(function () {
    removeItem(this);
  });

  /* Recalculate cart */
  function recalculateCart() {
    var subtotal = 0;

    /* Sum up row totals */
    $('.book').each(function () {
      subtotal += parseFloat($(this).children('.book-line-price').text());
    });

    /* Calculate totals */
    var tax = subtotal * taxRate;
    grandTotal = subtotal + tax; // Update the grand total variable

    /* Update totals display */
    $('.totals-value').fadeOut(fadeTime, function () {
      $('#cart-subtotal').html(subtotal.toFixed(2));
      $('#cart-tax').html(tax.toFixed(2));
      $('#cart-total').html(grandTotal.toFixed(2)); // Update the grand total display
      if (grandTotal == 0) {
        $('.checkout').fadeOut(fadeTime);
      } else {
        $('.checkout').fadeIn(fadeTime);
      }
      $('.totals-value').fadeIn(fadeTime);
    });
  }

  /* Update quantity */
  function updateQuantity(quantityInput) {
    /* Calculate line price */
    var bookRow = $(quantityInput).closest('.book');
    var price = parseFloat(bookRow.find('.book-price').text());
    var quantity = $(quantityInput).val();
    var linePrice = price * quantity;

    /* Update line price display and recalc cart totals */
    bookRow.find('.book-line-price').fadeOut(fadeTime, function () {
      $(this).text(linePrice.toFixed(2));
      recalculateCart();
      $(this).fadeIn(fadeTime);
    });
  }

  /* Remove item from cart */
  function removeItem(removeButton) {
    /* Remove row from DOM and recalculate cart total */
    var bookRow = $(removeButton).closest('.book');
    bookRow.slideUp(fadeTime, function () {
      bookRow.remove();
      recalculateCart();
    });
  }

  recalculateCart(); // Call this function to set the initial grand total
});
