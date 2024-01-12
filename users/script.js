let cart_count = 0;
let arrayObj = [];
var shoppingCart = (function () {
var obj = {};

    obj.addToCart = function (bookId, bookTitle, bookPrice, bookImage) {
        console.log('Adding book to cart with ID:', bookId);
        

        arrayObj.push({
            book_id: bookId,
            book_title: bookTitle,
            price: bookPrice,
            image: bookImage,
        });

        sessionStorage.setItem("book-cart",JSON.stringify(arrayObj) );
        cart_count++;
        console.log( arrayObj)
        // Update the cart count in the navbar
        let add_cart_count = document.getElementById('cart-count');
        add_cart_count.innerText = cart_count;

        // Optionally, prevent the default behavior
        return false;
    };

    // Fetch the cart count from session storage and update the cart count in the navbar
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cart-count').innerText = sessionStorage.getItem('cartCount') || 0;

        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const bookId = this.dataset.id;
                const bookPrice = this.dataset.price;
                const bookTitle = this.dataset.title;
                const bookImage = this.dataset.image;
                // console.log(bookQuantity);
                
                obj.addToCart(bookId, bookTitle, bookPrice, bookImage);
            });
        });
    });
    
    function showCart() {
        // Display the contents of shoppingCart in a modal, sidebar, or redirect to a cart page
        console.log(shoppingCart);
      }
    return obj;
})();

