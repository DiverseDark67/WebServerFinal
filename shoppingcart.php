<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle reset button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_cart'])) {
    $_SESSION['cart'] = []; // Clear the cart
    $reset_message = "Shopping cart has been reset.";
}
/* SQL Example if connected to a database
* $sql = "SELECT * FROM products";
* $result = $conn->query($sql);
* $products = [];
* if ($result->num_rows > 0) {
*     while($row = $result->fetch_assoc()) {
*         $products[$row['id']] = ['name' => $row['name'], 'price' => $row['price']];
*     }
* }

* $conn->close();
*/
// Mock data for demonstration purposes
// This should ideally come from your database using SQL but I chose not not connect with a database for this project
$products = [
    1 => ['name' => 'Black Umbrella', 'price' => 25.00],
    2 => ['name' => 'Yellow Umbrella', 'price' => 20.00],
    3 => ['name' => 'Clear Umbrella', 'price' => 15.00],
    4 => ['name' => 'Gortex Raincoat', 'price' => 85.00],
    5 => ['name' => 'Yellow Raincoat', 'price' => 35.00],
    6 => ['name' => 'Black Rain Boots', 'price' => 20.00],
];

// Add items to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['itemId'];
    $quantity = $_POST['quantity'];

    if (isset($products[$itemId])) {
        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId] += $quantity;
        } else {
            $_SESSION['cart'][$itemId] = $quantity;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rainy Day - Your first spot to look on rainy days</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" type="text/css" href="checkout.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
    <header>
        <b>
            <div class="header-text">
                Rainy Day - Free Shipping for orders over $50
            </div>
            <a class="header-buttons" href="shoppingcart.php">
                <button class="animated-button">
                    <span>Shopping Cart</span>
                    <span></span>
                </button>
            </a>
            &nbsp;
            <a class="header-buttons" href="index.html">
                <button class="animated-button">
                    <span>Home</span>
                    <span></span>
                </button>
            </a>
        </b>
    </header>

    <!-- Order Summary -->
    <div class="order-summary">
        <h2>Shopping Cart</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <ul>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $itemId => $quantity):
                    if (isset($products[$itemId])):
                        $product = $products[$itemId];
                        $subtotal = $product['price'] * $quantity;
                        $total += $subtotal;
                        ?>
                        <li>
                            <?php echo $product['name']; ?> (Quantity: <?php echo $quantity; ?>) - $<?php echo number_format($subtotal, 2); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <p><b>Total: $<?php echo number_format($total, 2); ?></b></p>
        <?php else: ?>
            <p>Your shopping cart is empty.</p>
        <?php endif; ?>

    <?php if (isset($reset_message)): ?>
        <p class="success-message"><?php echo $reset_message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <button type="submit" name="reset_cart" class="animated-button">
            <span>Reset Cart</span>
            <span></span>
        </button>
    </form>
    </div>

    <!-- Billing Info: Added required tag to skip save time on JS validation -->
    <form action="order.php" method="post" class="billing">
        <h2>Billing Information</h2>
        <label for="firstname" id="fnamelabel" required>Firstname:</label>
        <input type="text" name="firstname" id="firstname"><br>

        <label for="lastname" id="lnamelabel" required>Lastname:</label>
        <input type="text" name="lastname" id="lastname"><br>

        <label for="street" id="streetlabel" required>Street:</label>
        <input type="text" name="street" id="street"><br>

        <label for="city" id="citylabel" required>City:</label>
        <input type="text" name="city" id="city"><br>

        <label for="state" id="statelabel" required>State:</label>
        <input type="text" name="state" id="state"><br>

        <label for="zip" id="ziplabel" required>Zip:</label>
        <input type="text" name="zip" id="zip"><br>

        <label id="creditcardlabel">Credit Card:</label>
        <label><input type="radio" name="creditcard" value="visa" required>Visa</label>
        <label><input type="radio" name="creditcard" value="mastercard" required>Mastercard</label>
        <label><input type="radio" name="creditcard" value="discover" required>American Express</label> <br>

        <br>
        <button class="animated-button" type="submit">
            <span>Place Order</span>
            <span></span>
        </button>
    </form>
    <br>
    <footer>
        <p>© 2024 Rainy Day</p>
    </footer>
</body>
</html>
