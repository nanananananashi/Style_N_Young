<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sny";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (isset($_POST['cart'])) {
    $_SESSION['AccountId'] = $_POST['AccId'];
}

if (!isset($_SESSION['AccountId'])) {
    die("Account ID is not set in session.");
}

$AccountId = $_SESSION['AccountId'];

if (isset($_POST['remove'])) {
    $remove = $_POST['ItemId']; 
    $deleteSql = "DELETE FROM Cart WHERE UserId = ? AND ItemId = ?";
    $stmt = $conn->prepare($deleteSql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $AccountId, $remove);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "Item removed successfully";
    } else {
        echo "Error removing item: " . $conn->error;
    }
    $stmt->close();
}

$sql = "SELECT FirstName, Username FROM customer WHERE Id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $AccountId);
$stmt->execute();
$result = $stmt->get_result();

$name = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name[] = $row;
    }
    $userr = $name[0]['Username'];
}

$stmt->close();

$sql = "SELECT ItemId, Quantity, DateAndTime FROM Cart WHERE UserId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $AccountId);
$stmt->execute();
$result = $stmt->get_result();

$cart = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart[] = $row;
    }
}

$stmt->close();

$items = array();
foreach ($cart as $item) {
    $sql = "SELECT ItemId, Name, Details, Price, pic1, pic2, pic3 FROM Items WHERE ItemId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item['ItemId']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="shortcut icon" type="image/png" href="pics/Tops/LOGO.png"> 

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

        * {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #EDE9E8;
            color: #473C38;
        }
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        h1 {
            padding: 20px 0;
            margin-top: 20px;
            text-align: center;
            font-size: 40px;
        }
        .topNavigation {
            overflow: hidden;
            background-color: #473C38;
            padding: 15px 0;
        }
        .topNavigation a {
            float: right;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }
        .navLinks input[type="submit"] {
            float: right;
            padding: 14px 5px;
            text-decoration: none;
            color: #EDE9E8;
            font-size: 18px;
            margin-right: 10px;
            background-color: transparent;
            border: none;
        }
        .navLinks input[type="submit"]:hover {
            text-decoration: underline;
            color: #E6B0C9;
        }
        .logo {
            top: 26px;
            width: 75px;
            height: 75px;
            left: 30px;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding-left: 60px;
            padding-right: 60px;
        }
        .cart {
            display: flex;
        }
        .products {
            flex: 0.7;
        }
        .product {
            display: flex;
            max-width: 100%;
            height: 200px;
            overflow: hidden;
            border: 1px solid silver;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .product:hover {
            border: none;
            box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
            transform: scale(1.01);
        }
        .product > img {
            width: 200px;
            height: 200px;
            padding: 15px;
            object-fit: cover;
        }
        .product-info {
            padding: 20px;
            padding-left: 5px;
            width: 100%;
            position: relative;
        }
        .product-name, .product-price {
            margin-bottom: 5px;
        }
        .container-colorNsize {
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .product-colorNsize {
            font-size: 12px;
            margin-top: 1px;
        }
        .product-remove {
            font-size: 10px;
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 10px;
            background-color: #473C38;
            color: #EDE9E8;
            border: 1px solid #473C38;
            cursor: pointer;
            box-shadow: none;
        }
        .product-remove:hover {
            background-color: transparent;
            color: #473C38;
            border: 1px solid #473C38;
        }
        .product-quantity > input {
            width: 60px;
            padding: 5px;
            text-align: center;
            margin-left: 3px;
        }
        .cart-total {
            flex: 0.5;
            max-width: 100%;
            margin-left: 20px;
            padding: 20px;
            height: 100%;
            border: 1px solid silver;
            background-color: white;
            border-radius: 5px;
        }
        .cart-total p {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 17px;
        }
        .btn-column {
            display: flex;
            justify-content: center;
        }
        .btns {
            display: flex;
            gap: 10px;
            width: 100%;
        }
        .btns input {
            flex: 1;
            height: 40px;
            padding: 10px;
            background-color: transparent;
            color: #473C38;
            text-decoration: none;
            border: 1px solid #473C38;
            cursor: pointer;
            text-align: center;
        }
        .btns input:hover {
            background-color: #473C38;
            color: #EDE9E8;
        }
        .btns input.active {
            background-color: #473C38;
            color: #EDE9E8;
        }
        .btns input.disabled {
            background-color: #6b605c;
            color: #EDE9E8;
        }
        @media screen and (max-width: 1000px) {
            .product {
                height: auto;
                width: auto;
            }
            .product > img {
                height: auto;
            }
            .product-name, .product-price {
                margin-bottom: 10px;
            }
            .btns {
                flex-direction: column;
                gap: 5px;
            }
            .btns input {
                width: 100%;
            }
        }
        @media screen and (max-width: 900px) {
            .cart {
                flex-direction: column;
            }
            .cart-total {
                margin-left: 0;
                margin-bottom: 30px;
            }
        }
        @media screen and (max-width: 1220px) {
            .container {
                max-width: 95%;
            }
        }
    </style>
</head>
<body>
    <div class="topNavigation">
        <div class="navContainer">   
            <img src="pics/Tops/LOGO.png" alt="LOGO" class="logo" style="width:60px; height:60px;">
            <div class="navLinks">
            <form action="landing_page.php" method="POST">
            <a><input type="submit" value="HOME" style="margin-right: 10px;"></a>
            </form>

            <form action="index.php" method="post">
            <input type="hidden" name="logout" value="true">
            <a><input type="submit" value="LOG OUT"></a>
            </form>
            </div>
        </div>
    </div>
    <h1>CART</h1>
    <div class="container">
        <div class="cart">
            <div class="products">
            <?php
    $subtotal = 0;
    foreach($items as $product){
        $quantity = 0;
    foreach ($cart as $item) {
        if ($item['ItemId'] === $product['ItemId']) {
            $quantity = $item['Quantity'];
            break;
        }
        }
        $subtotal += $product['Price'] * $quantity;
        echo '<div class="product">';
        echo '<img src="pics/Male/' . $product['pic1'] . '.png" alt="product">';
        echo '<div class="product-info">';
        echo '<h3 class="product-name">' . $product['Name'] . '</h3>';
        echo '<h4 class="product-price">₱' . $product['Price'] . '</h4>';
        echo '<p class="product-quantity">Qnt: <input type="number" value="' . $quantity . '" name="quantity[' . $product['ItemId'] . ']"></p>';
        echo '<form method="POST">';
        echo '<input type="submit" class="product-remove" name="remove" value="REMOVE">';
        echo '<input type="hidden" name="ItemId" value="' . $product['ItemId'] . '">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
?>

            </div>

            <div class="cart-total">
                <h3>
                    <span>ORDER SUMMARY</span>
                </h3>
                <p>
                    <span style="margin-top: 10px;">Number of Items</span>
                    <span><?php echo count($cart); ?></span>
                </p>

                <p>
                    <span style="margin-top: 2px;">Subtotal:</span>
                    <span>₱<?php echo $subtotal; ?></span>
                </p>
                
                <div class="btn-column">
                <div class="btns">
                <input type="submit" name="coupon" value="COUPON">
                <?php if (!empty($cart)) { ?>
                    <form action="Checkout.php" method="POST">
                        <input type="submit" class="active" name="userr" value="CHECKOUT">
                        <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
                    </form>
                <?php } else { ?>
                    <input type="submit" class="disabled" name="userr" value="CHECKOUT" disabled>
                <?php } ?>
            </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
