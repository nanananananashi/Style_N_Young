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
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile
    </title>
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
        .profile-info {
            display: flex;
            flex-wrap: wrap;
        }
        .profile-info div {
            width: 50%;
            padding: 10px;
            box-sizing: border-box;
        }
        .profile-info div label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .profile-info div p {
            margin: 0;
        }
        .sidebar,
        .profile-settings {
            flex: 1;
            box-sizing: border-box;
            padding: 20px;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="pics/Tops/LOGO.png" style="max-width: 100px;" alt="Logo">
            <h2>Profile</h2>
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
            <div class="profile-info">
                <div>
                    <label>No Coupons Available</label>
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
            <form action="OrderHistory.php" method="post" class="nonactive">
                <a><input type="submit" name="userr" value="Order History"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">

            </form>
            <form action="Coupon.php" method="post" class="active">
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
