// Add item to cart
function addToCart(itemId, itemName, itemPrice) {
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=add&item_id=${itemId}&item_name=${encodeURIComponent(itemName)}&item_price=${itemPrice}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount();
            showNotification(`${itemName} added to cart!`);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Update cart count
function updateCartCount() {
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get_count'
    })
    .then(response => response.json())
    .then(data => {
        const countElement = document.getElementById('cart-count');
        if (countElement) {
            countElement.textContent = data.cart_count;
        }
    })
    .catch(error => console.error('Error:', error));
}

// Update quantity
function updateQuantity(itemId, quantity) {
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=update&item_id=${itemId}&quantity=${quantity}`
    })
    .then(() => {
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}

// Remove item
function removeItem(itemId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch('cart_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=remove&item_id=${itemId}`
        })
        .then(() => {
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Update cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});