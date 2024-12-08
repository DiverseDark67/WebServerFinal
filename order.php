<?php
session_start();// Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rainy Day - Your first spot to look on rainy days</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" type="text/css" href="animatedbutton.css">
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

    <?php
    // Validate required fields and items
    if (!empty($_SESSION['cart']) &&
        !empty($_POST["firstname"]) &&
        !empty($_POST["lastname"]) &&
        !empty($_POST["street"]) &&
        !empty($_POST["city"]) &&
        !empty($_POST["state"]) &&
        !empty($_POST["zip"])) {

        // Retrieve customer details
        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $address = htmlspecialchars($_POST["street"]);
        $city = htmlspecialchars($_POST["city"]);
        $state = htmlspecialchars($_POST["state"]);
        $zip = htmlspecialchars($_POST["zip"]);

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
        // Retrieve cart from session
        $cart = $_SESSION['cart'];
        $products = [
            1 => ['name' => 'Black Umbrella', 'price' => 25.00],
            2 => ['name' => 'Yellow Umbrella', 'price' => 20.00],
            3 => ['name' => 'Clear Umbrella', 'price' => 15.00],
            4 => ['name' => 'Gortex Raincoat', 'price' => 85.00],
            5 => ['name' => 'Yellow Raincoat', 'price' => 35.00],
            6 => ['name' => 'Black Rain Boots', 'price' => 20.00],
        ];

        // Initialize totals
        $total = 0;
        $shipping = 0;
        ?>

        <div class="order">
            <h2>Thank you for your order, <?php echo $firstname . " " . $lastname; ?>!</h2>
            <p><b>Your order will be shipped to:</b></p>
            <p><?php echo $address; ?></p>
            <p><?php echo $city . ", " . $state . " " . $zip; ?></p>

            <p><b>Your order includes:</b></p>
            <ul>
                <?php
                foreach ($cart as $itemId => $quantity) {
                    if (isset($products[$itemId])) {
                        $product = $products[$itemId];
                        $subtotal = $product['price'] * $quantity;
                        $total += $subtotal;
                        echo "<li>{$product['name']} (Quantity: {$quantity}) - $" . number_format($subtotal, 2) . "</li>";
                    }
                }
                ?>
            </ul>

            <?php
            // Calculate shipping
            if ($total < 50) {
                $shipping = 15; // Shipping cost for orders below $50
            }

            $grandTotal = $total + $shipping;
            ?>

            <p><b>Subtotal:</b> $<?php echo number_format($total, 2); ?></p>
            <p><b>Shipping cost:</b> $<?php echo number_format($shipping, 2); ?></p>
            <p><b>Grand Total:</b> $<?php echo number_format($grandTotal, 2); ?></p>
            <p>Your order will be shipped within 3-5 business days.</p>
        </div>

        <?php
    } else {
        // Handle errors
        ?>
            <p>There was an error with your order. Please ensure all fields are filled out and try again.</p>
            <a href="shoppingcart.php">Return to the Shopping Cart</a>
        <?php
    }
    ?>
    <br>
    <footer>
        <p>© 2024 Rainy Day</p>
    </footer>
</body>
</html>
