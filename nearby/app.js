// Define an empty array to store cart items
let cartItems = [];

// Function to add a product to the cart
function addToCart(productId, productName, price) {
    // Check if the product is already in the cart
    const existingItemIndex = cartItems.findIndex(item => item.productId === productId);
    
    if (existingItemIndex !== -1) {
        // If the product already exists in the cart, increment its quantity
        cartItems[existingItemIndex].quantity++;
    } else {
        // If the product doesn't exist in the cart, add it with quantity 1
        cartItems.push({
            productId: productId,
            productName: productName,
            price: price,
            quantity: 1
        });
    }

    // Update the total quantity displayed in the cart icon
    updateCartTotalQuantity();

    // Update the cart UI
    updateCartUI();
}

// Function to update the total quantity displayed in the cart icon
function updateCartTotalQuantity() {
    const totalQuantity = cartItems.reduce((total, item) => total + item.quantity, 0);
    document.querySelector('.totalQuantity').textContent = totalQuantity;
}

// Function to update the cart UI
function updateCartUI() {
    const cartContainer = document.querySelector('.cart .listCart');
    cartContainer.innerHTML = '';

    cartItems.forEach(item => {
        const cartItemHTML = `
            <div class="item">
                <img src="images/${item.productId}.jpg">
                <div class="content">
                    <div class="name">${item.productName}</div>
                    <div class="price">Rs ${item.price}</div>
                </div>
                <div class="quantity">
                    <button onclick="decrementQuantity(${item.productId})">-</button>
                    <span class="value">${item.quantity}</span>
                    <button onclick="incrementQuantity(${item.productId})">+</button>
                </div>
            </div>
        `;
        cartContainer.innerHTML += cartItemHTML;
    });
}

// Function to increment the quantity of a product in the cart
function incrementQuantity(productId) {
    const cartItem = cartItems.find(item => item.productId === productId);
    if (cartItem) {
        cartItem.quantity++;
        updateCartUI();
    }
}

// Function to decrement the quantity of a product in the cart
function decrementQuantity(productId) {
    const cartItem = cartItems.find(item => item.productId === productId);
    if (cartItem && cartItem.quantity > 1) {
        cartItem.quantity--;
        updateCartUI();
    }
}

// Add event listeners to "add to cart" buttons
document.querySelectorAll('.price button').forEach(button => {
    button.addEventListener('click', function() {
        const productContainer = this.closest('.listProduct');
        const productId = productContainer.getAttribute('data-product-id');
        const productName = productContainer.querySelector('.title a').textContent;
        const price = parseFloat(productContainer.querySelector('.price').textContent.split(' ')[1]); // Extracting price from "Rs xx" format
        addToCart(productId, productName, price);
    });
});
function toggleCart() {
    const cart = document.querySelector('.cart');
    cart.classList.toggle('open');
}

// Add event listeners to "add to cart" buttons
document.querySelectorAll('.price button').forEach(button => {
    button.addEventListener('click', function() {
        const productContainer = this.closest('.listProduct');
        const productId = productContainer.getAttribute('data-product-id');
        const productName = productContainer.querySelector('.title a').textContent;
        const price = parseFloat(productContainer.querySelector('.price').textContent.split(' ')[1]); // Extracting price from "Rs xx" format
        addToCart(productId, productName, price);

        // After adding to cart, toggle the cart visibility
        toggleCart();
    });
});


