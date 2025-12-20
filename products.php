<?php
require_once 'php/db_config.php';
// Fetch all books from database
$sql = "SELECT * FROM books ORDER BY category, title";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books - ABC Bookstore</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        
        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Header - Original Style */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 40px;
        }
        
        header h1 {
            margin-bottom: 15px;
        }
        
        nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
            white-space: nowrap;
        }
        
        nav a:hover {
            background-color: #34495e;
        }
        
        /* Main */
        main {
            flex: 1;
            padding: 40px;
            background: linear-gradient(135deg, #eef2ff, #fdfbff);
        }
        
        main h2 {
            text-align: center;
            color: #0f66d0;
            font-size: 2em;
            margin-bottom: 30px;
            animation: fadeUp 0.8s ease-out;
        }
        
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            padding: 20px;
        }
        
        .book {
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            animation: fadeUp 0.8s ease-out;
            transition: all 0.3s ease;
        }
        
        .book:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .book h3 {
            color: #0f66d0;
            font-size: 1.1em;
            margin-bottom: 10px;
        }
        
        .product-category {
            display: inline-block;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            margin-bottom: 12px;
        }
        
        .product-price {
            color: #ff6a00;
            font-size: 1.3em;
            font-weight: bold;
            margin: 12px 0 15px 0;
        }
        
        /* Buttons */
        .btn {
            padding: 10px 22px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(135deg, #ff512f, #dd2476);
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1em;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #27ae60, #229954);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }
        
        /* Modal */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-box {
            background: #fff;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            border-radius: 20px;
            animation: pop 0.4s ease-out;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        @keyframes pop {
            from {
                transform: scale(0.6);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .modal-box h3 {
            color: #0f66d0;
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        
        .modal-box p {
            color: #555;
            margin-bottom: 20px;
        }
        
        .modal-box .btn {
            margin: 5px;
            width: auto;
            padding: 10px 25px;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            text-align: center;
            padding: 25px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 20px;
            }
            
            nav {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            main {
                padding: 20px;
            }
            
            main h2 {
                font-size: 1.5em;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
                padding: 10px;
            }
            
            .modal-box .btn {
                display: block;
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>ABC Bookstore</h1>
            <nav>
                <a href="index.html">Home</a>
                <a href="products.php">Browse Books</a>
                <a href="cart.html">Cart (<span id="cart-count">0</span>)</a>
            </nav>
        </header>
        
        <main>
            <h2>Our Book Collection</h2>
            
            <div class="products-grid">
                <?php
                if ($result->num_rows > 0) {
                    while($book = $result->fetch_assoc()) {
                        echo '<div class="book">';
                        echo '<h3>' . htmlspecialchars($book['title']) . '</h3>';
                        echo '<span class="product-category">' . htmlspecialchars($book['category']) . '</span>';
                        echo '<p class="product-price">$' . number_format($book['price'], 2) . '</p>';
                        echo '<button class="btn btn-success add-to-cart" 
                                data-id="' . $book['id'] . '"
                                data-title="' . htmlspecialchars($book['title']) . '"
                                data-price="' . $book['price'] . '"
                                data-category="' . htmlspecialchars($book['category']) . '">
                                Add to Cart
                              </button>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="text-align:center; color:#777;">No books available at the moment.</p>';
                }
                $conn->close();
                ?>
            </div>
        </main>
        
        <!-- Order Popup Modal -->
        <div class="modal" id="popup">
            <div class="modal-box">
                <h3>🛒 Book Added</h3>
                <p>Do you want to add more books?</p>
                <button class="btn btn-primary" onclick="continueShopping()">Yes</button>
                <button class="btn btn-success" onclick="No, View Cart()">No</button>
            </div>
        </div>
        
        <footer>
            <p>&copy; 2024 ABC Bookstore. All rights reserved.</p>
        </footer>
    </div>
    
    <script>
        // Cart functionality
        function getCart() {
            return JSON.parse(localStorage.getItem('cart')) || [];
        }
        
        function saveCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        }
        
        function updateCartCount() {
            const cart = getCart();
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = totalItems;
        }
        
        // Modal functions
        function continueShopping() {
            document.getElementById('popup').classList.remove('show');
        }
        
        function goToCart() {
            document.getElementById('popup').classList.remove('show');
            window.location.href = 'cart.html';
        }
        
        // Add to cart
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const book = {
                    id: parseInt(this.dataset.id),
                    title: this.dataset.title,
                    price: parseFloat(this.dataset.price),
                    category: this.dataset.category,
                    quantity: 1
                };
                
                let cart = getCart();
                const existingItem = cart.find(item => item.id === book.id);
                
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push(book);
                }
                
                saveCart(cart);
                
                // Show modal
                document.getElementById('popup').classList.add('show');
                
                // Visual feedback on button
                this.textContent = 'Added!';
                this.style.background = 'linear-gradient(135deg, #2ecc71, #27ae60)';
                setTimeout(() => {
                    this.textContent = 'Add to Cart';
                    this.style.background = '';
                }, 1000);
            });
        });
        
        // Initialize cart count
        updateCartCount();
    </script>
</body>
</html>