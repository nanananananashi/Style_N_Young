<?php
$username = "root";
$password = "";

$conn = new mysqli("localhost", $username, $password, "sny");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if(isset($_POST['userr'])) {
    $AccountId = $_POST['AccId'];
} else {
    header("Location: index.php"); 
    exit();
}

$sql = "SELECT TransacNumber, ItemId, Quantity, DateTimeDelivered, MoP, Price, ShippingFee, Process FROM purchases WHERE UserId = ? AND Status = 'Sold'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $AccountId);
$stmt->execute();
$result = $stmt->get_result();

$PurchasedItems = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $PurchasedItems[] = $row;
    }
}
$stmt->close();     

$items = array();
foreach ($PurchasedItems as $item) {
    $sql = "SELECT ItemId, Name, Details, Price, pic1, pic2, pic3 FROM Items WHERE ItemId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item['ItemId']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="shortcut icon" type="image/png" href="pics/Tops/LOGO.png"> 
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }
        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header {
            display: flex;
            align-items: center;
            width: 100%;
            background-color: #473C38;
            padding: 20px;
            box-sizing: border-box;
            color: #f2f2f2;
            justify-content: space-between;
        }
        .header img {
            max-width: 100px; 
            height: auto; 
            margin-right: 10px;
        }
        .header .home-button {
            display: flex;
            align-items: center;
        }
        .home-button h5 {
            margin-right: 10px;
        }
        .home-button input[type="submit"] {
            border: none;
            background-color: transparent;
            color: #f2f2f2;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 5px;
        }
        .home-button input[type="submit"]:hover {
            color: #E6B0C9;
        }
        .main-content {
            display: flex;
            width: 100%; 
            margin-top: 20px;
            justify-content: flex-start; 
        }
        .container {
            flex: 4;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            margin-right: 20px;
            margin-top: 5px;
            border-radius: 10px;
            margin-left: 0; 
        }
        
        .sidebar,
        .profile-settings {
            flex: 1;
            box-sizing: border-box;
            padding: 20px;
        }
        .purchase-items {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: flex-start;
        }

        .purchase-item {
            width: 100%;
            background-color: #e3d3b3;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            margin-bottom: 20px;
        }

        .purchase-item img {
            width: 130px;
            height: 150px;
            border-radius: 5px;
            margin-right: 20px;
        }

        .purchase-details {
            flex: 1;
        }

        .purchase-details p {
            margin-bottom: 10px;
        }

        .rate-section {
            margin-top: 20px;
        }

        .rate-button {
            background-color: #473C38;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .rate-button:hover {
            background-color: #E6B0C9;
        }

        .rating {
            margin-top: 10px;
        }

        .star {
            font-size: 24px;
            color: #FFD700; 
            cursor: pointer;
        }
        .sidebar input[type="submit"],
        .profile-settings input[type="submit"],
        .sidebar a,
        .profile-settings a {
            border: none; 
            background-color: #f4f4f4;
            background: transparent;
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #473C38;
            margin-bottom: 5px;
            text-align: center;
            cursor: pointer;
            font-size: 1rem;
        }
        .sidebar input[type="submit"]:hover,
        .profile-settings input[type="submit"]:hover,
        .sidebar a:hover,
        .profile-settings a:hover {
            background-color: #f0f0f0;
        }
        
        .sidebar .active {
            background-color: #f0f0f0; 
            border: 3px solid #473C38;
        }
        .sidebar .nonactive:hover {
            background-color: #f0f0f0;
            border: 4px solid #473C38;
        }
        .product-info h5 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="pics/Tops/LOGO.png" style="max-width: 100px;" alt="Logo">
            <h2>Purchase History</h2>
        </div>
        <div class="home-button">
            <form action="landing_page.php" method="post">
                <input type="submit" name="id" value="Home">
                <input type="hidden" name="id" value="<?php echo $AccountId; ?>">
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="container">
            <div class="purchase-history">
                <div class="purchase-items">
                    <?php
                    if (empty($PurchasedItems)) {
                        echo '<h5>You haven\'t purchased yet</h5>';
                    } else {
                        foreach($items as $product){
                            foreach($PurchasedItems as $item) {
                                if ($item['ItemId'] == $product['ItemId']) {
                                    $iprice = $item['Price'];
                                    $sf = $item['ShippingFee'];
                                    $pricee = $iprice + $sf;
                                    echo '<div class="purchase-item">';
                                    echo '<img src="pics/Male/' . $product['pic1'] . '.png" alt="product">';
                                    echo '<div class="purchase-details">';
                                    echo '<h3 class="product-name">' . $product['Name'] . '</h3>';
                                    echo '<h5 class="product-price">Price: ₱' . number_format($iprice, 2) . '</h5>';
                                    echo '<h5 class="product-price">Shipping Fee: + ₱' . $item['ShippingFee'] . '</h5>';
                                    echo '<h5 class="product-price">Total Price: ₱' . number_format($pricee, 2) . '</h5>';
                                    echo '<h5 class="product-price">Mode of payment: ' . $item['MoP'] . '</h5>';
                                    echo '<h5 class="product-price">Status: ' . $item['Process'] . '</h5>';
                                    echo '<h5 class="product-price">Date and Time Delivered: ' . $item['DateTimeDelivered'] . '</h5>';
                                    echo '<h5 class="product-price">Transaction Number: ' . $item['TransacNumber'] . '</h5>';
                                    echo '<h5 class="product-quantity">Qnt: ' . $item['Quantity'] . '</h5>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="sidebar">
        <form action="Profile.php" method="post" class="nonactive">
                <a><input type="submit" name="userr" id="active" value="Profile"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
            <form action="PurchaseHistory.php" method="post" class="active">
                <a><input type="submit" name="userr" value="Purchase History"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
            <form action="OrderHistory.php" method="post" class="nonactive">
                <a><input type="submit" name="userr" value="Order History"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">

            </form>
            <form action="Coupon.php" method="post" class="nonactive">
                <a><input type="submit" name="userr" value="Coupons"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
            <div class="profile-settings">
                <form action="Edit.php" method="post" class="nonactive">
                    <a><input type="submit" name="userr" value="Edit profile"></a>
                    <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">

                </form>
                <form action="#" method="post" class="nonactive">
                    <a><input type="submit" name="change_password" value="Change my password"></a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
