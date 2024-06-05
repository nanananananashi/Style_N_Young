<?php
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, "sny");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if(isset($_POST['userr']) || isset($_POST['submit'])) {
    $AccountId = isset($_POST['AccId']) ? $_POST['AccId'] : null;
} else {
    header("Location: index.php"); 
    exit();
}

if ($AccountId) {
    $sql = "SELECT * FROM customer WHERE Id = $AccountId"; 
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
        $currentpassword = $row["Password"];
    } else {
        echo "0 results";
        exit();
    }
} else {
    echo "Invalid Account ID";
    exit();
}

$address = $House . " " . $Subdivision . " " . $City . " " . $Country . ", " . $Postal;
$name = $FirstName . " " . $LastName;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

        if ($newPassword === $confirmPassword) {
            $updateSql = "UPDATE customer SET Password='$newPassword' WHERE Id='$AccountId'";
            if($currentpassword===$oldPassword){
            if ($conn->query($updateSql) === TRUE) {
                $updateSuccess = true;
            } else {
                $updateFailed = true;
            }
        } else {
            $wrongOldPassword = true;
        }
        } else {
            $passwordMismatch = true;
        }
    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChangePassword</title>
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
        .logo {
            height: 90px;
            width: 90px;
        }
        .title {
            padding: 10px;
            font-size: 37px;
            font-weight: 650;
        }
        .form .input-box input {
            width: 350px;
            height: 50px;
            margin-top: 20px;
            font-size: 17px;
            border: none;
            background: transparent;
            border-bottom: 1px solid #44362A;
        }
        ::placeholder {
            color: #473C38;
        }
        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        .column{
            display: flex;
            margin-top: 20px;
            gap: 25px;
        }
        .btn {
            flex: 1;
            height: 40px;
            padding: 10px;
            background-color: #473C38;
            color: #EDE9E8;
            text-decoration: none;
            border: 1px solid #473C38;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            opacity: 0.80;
        }
        @media screen and (max-width: 1200px) {
            .container {
                max-width: 100%;
            }
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

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .overlay-message {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="pics/Tops/LOGO.png" style="max-width: 100px;" alt="Logo">
            <h2>Change Password</h2>
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
        <div class="info">
            <img src="pics/Tops/LOGO.png" alt="logo" class="logo">
            <h3 class="title">CHANGE YOUR PASSWORD</h3>
            <form action="ChangePass.php" method="post" class="form">
                <div class="input-box">
                    <input type="password" name="old-password" placeholder="OLD PASSWORD" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="password" name="new-password" placeholder="NEW PASSWORD" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="password" name="confirm-password" placeholder="CONFIRM PASSWORD" autocomplete="off" required>
                </div>
                <div class="column">
                    <input type="submit" class="btn" name="submit" value="CHANGE MY PASSWORD">
                    <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
                </div>
            </form>
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
        <form action="Coupon.php" method="post" class="nonactive">
                <a><input type="submit" name="userr" value="Coupons"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
        <div class="profile-settings">
            <form action="Edit.php" method="post" class="nonactive">
                <a><input type="submit" name="userr" value="Edit profile"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
            <form action="ChangePass.php" method="post" class="active">
                <a><input type="submit" name="userr" value="Change my password"></a>
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
        </div>
    </div>
</div>

<?php if (isset($updateSuccess) && $updateSuccess): ?>
    <div class="overlay">
        <div class="overlay-message">
            <p>Password changed successfully!</p>
            <form action="Profile.php" method="post">
                <input type="submit" name="userr" value="Go to Profile">
                <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
            </form>
        </div>
    </div>
<?php elseif (isset($updateFailed) && $updateFailed): ?>
    <div class="overlay">
        <div class="overlay-message">
            <p>Failed to update password. Please try again later.</p>
            <button onclick="document.querySelector('.overlay').style.display='none'">Close</button>
        </div>
    </div>
<?php elseif (isset($passwordMismatch) && $passwordMismatch): ?>
    <div class="overlay">
        <div class="overlay-message">
            <p>New password and confirm password do not match.</p>
            <button onclick="document.querySelector('.overlay').style.display='none'">Close</button>
        </div>
    </div>
<?php elseif (isset($wrongOldPassword) && $wrongOldPassword): ?>
    <div class="overlay">
        <div class="overlay-message">
            <p>Old password is incorrect.</p>
            <button onclick="document.querySelector('.overlay').style.display='none'">Close</button>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
