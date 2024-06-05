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

if (isset($_POST['userr'])) {
    $_SESSION['AccountId'] = $_POST['AccId'];
}

if (!isset($_SESSION['AccountId'])) {
    die("Account ID is not set in session.");
}

$AccountId = $_SESSION['AccountId'];



$sql = "SELECT * FROM customer WHERE Id = ?";
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
    $FName = $name[0]['FirstName'];
    $LName = $name[0]['LastName'];
    $phone = $name[0]['Phone'];
    $house = $name[0]['House'];
    $subdivision = $name[0]['Subdivision'];
    $city = $name[0]['City'];
    $country = $name[0]['Country'];
    $postal = $name[0]['PostalCode'];
    
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
    $sql = "SELECT ItemId, Name, Details, Stock, Sold, Price, pic1, pic2, pic3 FROM Items WHERE ItemId = ?";
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
        $datetoday = new DateTime();
        $datetoday->modify('+2 days');
        $EstDateSt = $datetoday->format('Y-m-d');
        $datetoday->modify('+4 days');
        $EstDateEn = $datetoday->format('Y-m-d');


        if (isset($_POST['placeorder'])) {
            $totalqty = 0;
            $subtotal = 0;
            $sf = 0;
            $itemsub = 0;
            foreach ($cart as $item) {
                foreach ($items as $product) {
                    if ($product['ItemId'] === $item['ItemId']) {
                        $quantity = $item['Quantity'];
                        $Process = "Waiting for the seller";
                        break;
                    }
                }
                $ItemId = $item['ItemId'];
                $mop = "Cash On Hand";
                $Price = $product['Price'];
                $status = "Ordered";
                $CurLocation = "Pasig";
                $courier = "NinjaVan";
                $totalqty += $quantity;
                $itemsub = $Price * $quantity;
                $subtotal += $itemsub;
                $sf += 38;
        
                $sql = "INSERT INTO purchases (UserId, ItemId, Quantity, MoP, Price, ShippingFee, Status, Process, EstDateSt, EstDateEn, CurLocation, DateOrdered, Courier) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiisddssssss", $AccountId, $ItemId, $quantity, $mop, $Price, $sf, $status, $Process, $EstDateSt, $EstDateEn, $CurLocation, $courier);
                if ($stmt->execute()) {
                    echo '<script>';
                    echo 'document.addEventListener("DOMContentLoaded", function() {';
                    echo '    document.getElementById("welcomeOverlay").style.display = "block";';
                    echo '    setTimeout(function(){';
                    echo '        document.getElementById("welcomeOverlay").style.display = "none";';
                    echo '        window.location.href = "Checkout.php";'; 
                    echo '    }, 2500);';
                    echo '});';
                    echo '</script>';                
                } else {
                    echo "Error: " . $stmt->error;
                }
                $deleteSql = "DELETE FROM Cart WHERE UserId = ? AND ItemId = ?";
                $delstmt = $conn->prepare($deleteSql);
                if ($delstmt === false) {
                    die("Prepare failed: " . htmlspecialchars($conn->error));
                }
                
                $delstmt->bind_param("ii", $AccountId, $ItemId);
                
                if ($delstmt->execute() === false) {
                    die("Error executing query: " . htmlspecialchars($delstmt->error));
                }
                
                if ($delstmt->affected_rows > 0) {
                } else {
                    echo "No items found to remove";
                }
                
                $delstmt->close();

                $AdjStock = $product['Stock'] - $quantity;
                $AdjSold = $product['Sold'] + $quantity;
                $updateSql = "UPDATE Items SET Stock = ?, Sold = ? WHERE ItemId = ?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param("iii", $AdjStock, $AdjSold, $ItemId);
                if ($stmt->execute()) {
                    echo 'Stock and Sold updated successfully';
                } else {
                    echo "Error updating Stock and Sold: " . $stmt->error;
                }
                
            }   
        }


$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
*{
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
    background-color: transparent;
    border: none;
    float: right;
    padding: 14px 16px;
    text-decoration: none;
    color: #EDE9E8;
    font-size: 18px;
    margin-right: 10px;
}
.navLinks input[type="submit"]:hover {
    text-decoration: underline;
    color: #E6B0C9;
}
.logo {
    width: 75px;
    height: 75px;
    margin-right: 30px;
}
.search {
    float: right;
    padding: 6px;
    border: none;
    width: 20pc;
    margin-top: 8px;
    margin-right: 20px;
    padding-left: 20px;
    padding-right: 20px;
    font-size: 17px;
    border-radius: 20px;
}
.container {
    max-width: 100%;
    margin: 0 auto;
    padding-left: 120px;
    padding-right: 120px;
}
.checkout {
    display: flex;
    gap: 15px;
}
.details {
    flex: 0.7;
}
.title-container{
    display: flex;
}
.btnEdit{
    height: 15px;
    width: 15px;
    border: none;
    color: #473C38;
    position: absolute;
    top: 20px;
    right: 20px;
    cursor: pointer;
}
.myInformation {
    width: 100%;
    max-height: 100%;
    overflow: hidden;
    border: 0.5px solid silver;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 20px;
    position: relative;
}
.container-myInfo{
    padding-top: 20px;
    padding-left: 3px;
}
.billingAdd{
    width: 100%;
    max-height: 100%;
    overflow: hidden;
    border: 1px solid silver;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 20px;
    position: relative;
}
.delivery{
    width: 100%;
    max-height: 100%;
    overflow: hidden;
    border: 1px solid silver;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 20px;
    position: relative;
}
.orderSummary {
    flex: 0.4;
	max-width: 100%;
    height: 100%;
    overflow: hidden;
    border: 0.5px solid silver;
    background-color: white;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 20px;
    position: relative;
}
.productsOrdered{
    height: 100%;
    width: 100%;
    overflow: hidden;
    margin-bottom: 15px;
    border-radius: 5px;
    position: relative;
    border: 0.5px solid silver;
}
.ordered{
    display: flex;
    gap: 2px;
    padding: 15px;
}
.ordered > img {
    width: 105px;
    height: auto;
    padding: 10px;
    object-fit: cover;
}
.orderedInfo{
    padding-left: 20px;
}
.oInfo{
    padding-bottom: 2px;
    font-size: 12px;
}
.summInfo{
    padding-top: 10px; 
    font-size: 17px;
}
.btnPlaceOrder{
    padding: 10px;
    width: 100%;
    margin-top: 15px;
    background-color: #473C38;
    border: none;
    color: #EDE9E8;
    font-size: 12px;
    cursor: pointer;
    transition: all .3s;
}
.btnPlaceOrder:hover{
    opacity: 0.80;
}
@media screen and (max-width: 1000px) {
    .product {
        height: auto;
        width: auto;
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
    .checkout {
        flex-direction: column;
    }
}
@media screen and (max-width: 1220px) {
    .container {
        max-width: 95%;
    }
}
#welcomeOverlay {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9);
            color: #473C38;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            transition: all 0.3s ease-in-out;
            text-align: center;
        }

        #welcomeOverlay h2 {
            margin-bottom: 10px;
            color: #473C38;
        }

        #welcomeOverlay p {
            color: #333;
            margin-bottom: 10px;
        }

        #welcomeOverlay img {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .exit-btn-welcome {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 1.2rem;
            color: #473C38;
            cursor: pointer;
            z-index: 9999;
        }

        .exit-btn-welcome:hover {
            color: #fc6c85;
        }
</style>
	<title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="topNavigation">
        <div class="navContainer">	
            <img src="pics/Tops/LOGO.png" alt="LOGO" class="logo" style="width:60px; height:60px;">
            <div class="navLinks">
                <form action="Cart.php" method="post">
                    <a><input type="submit" name="cart" value="CART"></a>
                    <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
                </form>
                <form action="landing_page.php" method="POST">
                    <a><input type="submit" name="cart" value="HOME" style="margin-right: 10px;"></a>
                    <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
                </form>
                <form action="index.php" method="post">
                    <a><input type="submit" name="logout" value="LOG OUT"></a>
                </form>
            </div>

        </div>
    </div>
    <h1>CHECKOUT</h1>
    <div class="container">
        <div class="checkout">
            <div class="details">
                <div class="myInformation">
                    <div class="title-container">
                        <h3>MY INFORMATION</h3>
                        <a href="editProfile.php">
                        </a>
                    </div>
                    <div class="container-myInfo">
                        <p class="myInfo" style="margin-bottom: 8px;"><?php echo $FName . " " . $LName;?></p>
                        <p class="myInfo"><?php echo $userr;?> </p>
                    </div>
                </div>

                <div class="billingAdd">
                    <div class="title-container">
                        <h3>SHIPPING ADDRESS</h3>
                        <a href="addressBook.php">
                        </a>
                    </div>
                    <div class="container-myInfo">
                        <p class="myInfo" style="margin-bottom: 8px;"><?php echo $FName . " " . $LName;?></p>
                        <p class="myInfo" style="margin-bottom: 8px;"><?php echo $house;?></p>
                        <p class="myInfo" style="margin-bottom: 8px;"><?php echo $subdivision . " " . $city . " " . $postal;?></p>
                        <p class="myInfo" style="margin-bottom: 8px;"><?php echo $country . "(country)";?></p>
                        <p class="myInfo"><?php echo $phone?></p>
                    </div>
                </div>

                <div class="delivery">
                    <h3>DELIVERY</h3>
                    <?php $sf = 38 * count($cart)?>
                    <div class="container-myInfo">
                        <p class="myInfo" style="margin-bottom: 8px;"><span style="color: #925a75;">Delivery by:</span> Ninja Van (Standard Local)</p>
                        <p class="myInfo" style="margin-bottom: 8px;"><span style="color: #925a75;">Shipping Fee:</span> <?php echo number_format($sf, 2) ?></p>
                        <?php
                        $currentDate = new DateTime();
                        $currentDate->modify('+2 days');
                        $EstDateSt = $currentDate->format('Y-m-d');
                        $currentDate->modify('+4 days');
                        $EstDateEn = $currentDate->format('Y-m-d');
                        ?>
                        <p class="myInfo" style="margin-bottom: 8px;"><span style="color: #925a75;">Estimated delivery time:</span><?php echo $EstDateSt . " - " . $EstDateEn; ?></p>
                    </div>
                </div>
            </div>

            <div class="orderSummary">
                <h3 style="margin-bottom: 15px;">ORDER SUMMARY</h3>
                <div class="productsOrdered">
                    <?php
                    $subtotal = 0;
                    $totalItems = 0;
                    $totalqty = 0;
                    $itemsub = 0;
                    $sf = 0;
                    foreach ($items as $product) {
                        $quantity = 0;
                        foreach ($cart as $item) {
                            if ($item['ItemId'] === $product['ItemId']) {
                                $quantity = $item['Quantity'];
                                break;
                            }
                        }
                        $totalqty = $totalqty + $quantity;
                        $itemsub = $product['Price'] * $quantity;
                        $subtotal = $subtotal + $itemsub;
                        $sf = $sf + 38;
                        echo '<div class="ordered">' .
                            '<img src="pics/Male/' . $product['pic1'] . '.png" alt="shirt">' .
                            '<div class="orderedInfo">' .
                            '<h3 style="font-size: 15px;">' . $product['Name'] . '</h3>' .
                            '<p class="oInfo">Unit Price: ₱' . number_format($product['Price'], 2) . '</p>' .
                            '<p class="oInfo">Quantity: ' . $quantity . '</p>' .
                            '<p class="oInfo" style="font-size: 13px; color: #925a75;">SUBTOTAL: ₱' . number_format($itemsub, 2) . '</p>' .
                            '</div>' .
                            '</div>';
                    }
                    $FinalPrice = $subtotal + $sf;
                echo '<p class="summInfo">ORDER TOTAL (' . $totalqty .' Items): ' . number_format($subtotal, 2) . '</p>';
                echo '<p class="summInfo">SHIPPING FEE: '. number_format($sf, 2) . '</p>';
                echo '<p class="summInfo" style="font-size: 20px; font-weight: bold;">TOTAL PAYMENT: <span style="color: #925a75;">'. number_format($FinalPrice, 2) .'</span></p>';
                echo '<form method="POST" action="">';  
                echo '<input type="submit" name="placeorder" class="btnPlaceOrder" value="PLACE ORDER">';

                echo '</form>';
                echo '</a>';
            echo '</div>';
        echo'</div>';
        ?>
    </div>

    <div class="overlay" id="welcomeOverlay">
    <button class="exit-btn-welcome" id="closeWelcomeBtn">X</button>
    <div class="login-form">
        <h2>S'nY</h2>
        <img src="pics/Tops/LOGO.png" alt="logo">
        <p>You're order is successful!</p>
    </div>
</div>
</body>
</html>

