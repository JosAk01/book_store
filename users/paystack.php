<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paystack</title>
</head>
<body>
<form id="paymentForm">
  <div>
    <label for="email">Email</label>
    <input type="email" id="email" required />
  </div>
  <div>
    <label for="amount">Amount</label>
    <input type="number" id="amount" required />
  </div>
  <div>
    <button type="button" onclick="payWithPaystack()"> Pay </button>
  </div>
</form>

<!-- Include the Paystack script -->
<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
  function payWithPaystack() {
    var handler = PaystackPop.setup({
      key: 'pk_test_e77ee04a3320937331b6a7ecb39ac1e5b8878aa8', // Replace with your public key
      email: document.getElementById('email').value,
      amount: document.getElementById('amount').value * 100, // The amount value is in kobo
      currency: 'NGN', // Changed to NGN
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // Generate a random reference number
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
</script>
</body>
</html>
