<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<style>
  body {
    background-color: #121212;
    color: #e0e0e0;
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    font-size: 2.5em;
    color: #ffffff;
    text-align: center;
    margin-bottom: 10px;
}

h2 {
    font-size: 1.5em;
    color: #b0b0b0;
    text-align: center;
    margin-bottom: 40px;
}

h3 {
    font-size: 1.2em;
    color: #ffffff;
    margin-top: 40px;
}

h4 {
    font-size: 1.1em;
    color: #b0b0b0;
    margin-top: 20px;
}

p {
    font-size: 1em;
    margin-bottom: 20px;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    margin-bottom: 10px;
}

a {
    color: #42a5f5;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

button, .chat-button {
    background-color: #42a5f5;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    font-size: 1em;
    cursor: pointer;
    margin-top: 20px;
}

button:hover, .chat-button:hover {
    background-color: #1e88e5;
}

form {
    display: flex;
    flex-direction: column;
}

form label {
    margin-top: 10px;
}

form input, form textarea {
    padding: 10px;
    margin-top: 5px;
    background-color: #222222;
    color: #e0e0e0;
    border: 1px solid #424242;
}

form input:focus, form textarea:focus {
    outline: none;
    border-color: #42a5f5;
}

form button {
    align-self: flex-start;
    margin-top: 20px;
}
.back-button {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000; /* Ensures the button is above other content */
}
</style>
<body>
    <div class="container">
        <h1>Customer Service</h1>
        <h2>We're Here to Help You</h2>

        <section>
            <h3>Contact Us</h3>
            <p>If you have any questions or need assistance, feel free to contact us through the following methods:</p>
            <ul>
                <li>Email: <a href="mailto:support@bookstore.com">support@bookstore.com</a></li>
                <li>Phone: 1-800-BOOKS-24</li>
                <li>Address: 123 Book St, Reading Town, BK 56789</li>
            </ul>
        </section>

        <section>
            <h3>Frequently Asked Questions (FAQs)</h3>
            <p>Here are some common questions our customers ask. If you can't find your answer here, please contact us.</p>
            <h4>How can I track my order?</h4>
            <p>You can track your order by logging into your account and navigating to the 'Orders' section. You'll find real-time updates on your shipment status.</p>
            <h4>What is your return policy?</h4>
            <p>We accept returns within 30 days of purchase. The item must be in its original condition. Please visit our <a href="returns.html">Returns Page</a> for more details.</p>
            <h4>How do I cancel my order?</h4>
            <p>To cancel an order, please contact our customer service team as soon as possible. If the order has not been shipped, we will cancel it for you.</p>
        </section>

        <section>
            <h3>Live Chat Support</h3>
            <p>Need immediate assistance? Use our live chat feature available from 9 AM to 6 PM, Monday to Friday.</p>
            <button class="chat-button">Start Live Chat</button>
        </section>

        <section>
            <h3>Feedback</h3>
            <p>Your feedback is important to us. Please let us know how we can improve our services.</p>
            <form action="#" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </section>
    </div>
</body>
<a href="javascript:history.back()" class="btn btn-primary back-button">Back</a>
</html>
