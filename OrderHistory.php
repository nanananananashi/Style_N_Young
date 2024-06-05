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
}else {
    header("Location: index.php"); 
    exit();
}

    $sql = "SELECT * FROM purchases WHERE UserId = ? AND Status = 'Ordered'";
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

    $sql = "SELECT Username, Phone, FirstName, LastName, Birthday, House, Subdivision, City, Country, Gender, PostalCode FROM customer WHERE Id = $AccountId"; 

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row["Username"];
    $phone = $row["Phone"];
    $FirstName = $row["FirstName"];
    $LastName = $row["LastName"];
    $birthday = $row["Birthday"];
    $House = $row["House"];
    $Subdivision = $row["Subdivision"];
    $City = $row["City"];
    $Country = $row["Country"];
    $Gender = $row["Gender"];
    $Postal = $row["PostalCode"];
} else {
    echo "0 results";
}
$address = $House . " " . $Subdivision . " " . $City . " " . $Country . ", " . $Postal;
$name = $FirstName . " " . $LastName;
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
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
            width: 200px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .purchase-item img {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .purchase-details p {
            margin-bottom: 10px;
        }

        .rate-section {
            margin-top: 0px;
        }

        .rate-button {
            margin-bottom: 5px;
            margin-left: 240px;
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
            margin-top: 1px;
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
        .product {
            max-width: 320px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            border: 1px solid #473C38;
            border-radius: 10px;

        }

        .product:hover {
            border: none;
            box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
            transform: scale(1.01);
        }

        .product > img {
            width: 150px;
            height: 150px;
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
        .order-history {
            display: flex;
            flex-direction: column;
        }
        .order-summary {
            flex: 1;
            border: 1px solid #ccc; 
            padding: 30px;
            margin-bottom: 300px;
            border-radius: 5px; 
        }
        .order-summary .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .order-summary .summary-header p {
            margin: 0;
        }
        .order-summary .details-button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            text-align: center;
        }
        .order-details-container {
            display: flex;
            background-color: #f5f5dc; 
            padding: 10px;
            border-radius: 10px;
            margin-left: 50px;
            flex: 2;
            position: relative;
        }
        .order-details {
            display: flex;
            flex-direction: column;
            padding: 10px;
            width: 100%;
        }
        .order-details p {
            margin: 2px 0;
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: #ccc;
        }
        .products {
            display: flex;


        }
        .product-con{
            max-width: 350px;
        }

        
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="pics/Tops/LOGO.png" style="max-width: 100px;" alt="Logo">
            <h2>Order History</h2>
        </div>
        <div class="home-button">
            <form action="landing_page.php" method="post">
                <input type="submit" name="id"value="Home">
                <input type="hidden" name="id" value="<?php echo $AccountId; ?>">
            </form>
        </div>
    </div>

    <div class="main-content">
    <div class="container">
            <div class="purchase-history">
            <div class="products">
            <div class="product-con">
            <?php
    if (empty($PurchasedItems)) {
        echo '<h5>You haven\'t purchased yet</h5>';
    } else {
        foreach($PurchasedItems as $item) {
            $sql = "SELECT ItemId, Name, Details, Price, pic1, pic2, pic3 FROM Items WHERE ItemId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $item['ItemId']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($product = $result->fetch_assoc()) {
                    $pricee = $item['Price'];
                    $sf = $item['ShippingFee'];
                    $iprice = $pricee - $sf;
                    $DOFormat = new DateTime($item['DateOrdered']);
                    $DO4matted = $DOFormat->format('m/d/Y');
                    $StFormat = new DateTime($item['EstDateSt']);
                    $DO4mattedSt = $StFormat->format('m/d/Y');
                    $EnFormat = new DateTime($item['EstDateEn']);
                    $DO4mattedEn = $EnFormat->format('m/d/Y');
                    $orderNumber = $item['TransacNumber'];
                    $deliveryBy = $item['Courier'];
                    $shippingFee = $item['ShippingFee'];
                    $mop = $item['MoP'];
                    $productName = $product['Name'];
                    $subtotal = $item['Price'];
                    $total = number_format($subtotal + $shippingFee, 2);
                    $status = $item['Process'];
                    $quantity = $item['Quantity'];
                    echo '<div class="product">' .
                        '<img src="pics/Male/' . $product['pic1'] . '.png" alt="product">' .
                        '<div class="product-info">' .
                        '<h4 class="product-name">' . $product['Name'] . '</h4>' .
                        '<h5 class="product-price"><pre>Date of Order:                              ' . $DO4matted . '</pre></h5>' .
                        '<h5 class="product-price"><pre>Status:                         ' . $item['Process'] . '</pre></h5>' .
                        '<h5 class="product-price"><pre>Order Number:                              ' . $item['TransacNumber'] . '</pre></h5>' .
                        '<h5 class="product-price"><pre>Estimated Time Arrival:               ' . $DO4mattedSt. '-
                                                           '. $DO4mattedEn . '</pre></h5>' .
                        '<h5 class="product-price"><pre>Courier:                                      ' . $item['Courier'] . '</pre></h5>' .
                        '<h5 class="product-price"><pre>Shipping Fee:                                  + ₱' . $item['ShippingFee'] . '</pre></h5>' .
                        '<h5 class="product-price"><pre>Mode of payment:              ' . $item['MoP'] . '</pre></h5>' .
                        '</div>' .
                        '<div class="rate-section">' .
                        '<form method="post">' . 
                        '<input type="submit" class="rate-button" name="userr" value="Details">' .
                        '<input type="hidden" name="id" value="' . $product['ItemId'] . '">' . 
                        '<input type="hidden" name="DateOrdered" value="' . $DO4matted . '">' . 
                        '<input type="hidden" name="EstDateSt" value="' . $DO4mattedSt . '">' . 
                        '<input type="hidden" name="EstDateEN" value="' . $DO4mattedEn . '">' . 
                        '<input type="hidden" name="OrderNo" value="' . $orderNumber . '">' . 
                        '<input type="hidden" name="courier" value="' . $deliveryBy. '">' . 
                        '<input type="hidden" name="mop" value="' . $mop. '">' . 
                        '<input type="hidden" name="ItemName" value="' . $productName. '">' . 
                        '<input type="hidden" name="subtotal" value="' . $subtotal. '">' . 
                        '<input type="hidden" name="sf" value="' . $shippingFee. '">' . 
                        '<input type="hidden" name="total" value="' . $total. '">' . 
                        '<input type="hidden" name="Status" value="' . $status. '">' . 
                        '<input type="hidden" name="Quantity" value="' . $quantity . '">' .  
                        '<input type="hidden" name="AccId" value="' . $AccountId . '">' .
                        '</form>' .
                        '</div>' .
                        '</div>';
                }
            }
        }
    }
    $conn->close();

?>

</div>              
                        <?php
                if(isset($_POST['userr'])){
                    $id = isset($_POST['id']) ? $_POST['id'] : '';
                    $orderDate = isset($_POST['DateOrdered']) ? $_POST['DateOrdered'] : '';
                    $EstDateSt = isset($_POST['EstDateSt']) ? $_POST['EstDateSt'] : '';
                    $EstDateEn = isset($_POST['EstDateEN']) ? $_POST['EstDateEN'] : '';
                    $OrderNo = isset($_POST['OrderNo']) ? $_POST['OrderNo'] : '';
                    $courier = isset($_POST['courier']) ? $_POST['courier'] : '';
                    $sf = isset($_POST['sf']) ? $_POST['sf'] : '';
                    $mop = isset($_POST['mop']) ? $_POST['mop'] : '';
                    $ItemName = isset($_POST['ItemName']) ? $_POST['ItemName'] : '';
                    $subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : '';
                    $total = isset($_POST['total']) ? $_POST['total'] : '';
                    $Status = isset($_POST['Status']) ? $_POST['Status'] : '';
                    $qty = isset($_POST['Quantity']) ? $_POST['Quantity'] : '';
                    echo '<div class="order-history">';
                    echo '<div style="display: flex;">';
                    echo '<div class="order-details-container" id="orderDetails">';
                    echo '    <div class="order-details">';
                    
                    echo "<p><strong>DATE OF ORDER $orderDate</strong></p>";
                    echo "<p>Order number: $OrderNo</p>";
                    echo "<p>Order status: $Status</p>";
                    echo "<p>Estimated delivery time: $EstDateSt - $EstDateEn </p>";
                    echo "<p>Delivery by: $courier</p>";
                    echo "<hr>";
                    echo "<p><strong>SHIPPING ADDRESS:</strong></p>";
                    echo "<p>$name</p>";
                    echo "<p>Address: $address</p>";
                    echo "<p>$phone</p>";
                    echo "<hr>";
                    echo "<p><strong>DELIVERY DATE:</strong></p>";
                    echo "<p>Shipping Fee: $sf</p>";
                    echo "<p>Estimated delivery time: $EstDateSt - $EstDateEn </p>";
                    echo "<hr>";
                    echo "<p><strong>PAYMENT OPTION:</strong></p>";
                    echo "<p>$mop</p>";
                    echo "<hr>";
                    echo "<p><strong>ORDER SUMMARY:</strong></p>";
                    echo "<p>$ItemName</p>";
                    echo "<p>Subtotal: ₱$subtotal</p>";
                    echo "<p>Shipping Fee: +₱$sf</p>";
                    echo "<p>Total: ₱$total</p>";
                    echo '</div>';
                    echo '<span class="close-button" onclick="removeOrderDetails()">X</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                }else {
                    echo"";
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
            <form action="PurchaseHistory.php" method="post" class="nonactive">
                <a><input type="submit" name="userr" value="Purchase History"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
            <form action="OrderHistory.php" method="post" class="active">
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
                <form action="ChangePass.php" method="post" class="nonactive">
                    <a><input type="submit" name="userr" value="Change my password"></a>
                    <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
                </form>
            </div>
        </div>
    </div>
</body>

</html>
