<?php
$username = "root";
$password = "";

$conn = new mysqli("localhost", $username, $password, "sny");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
$showSuccessOverlay = false;

if (isset($_POST['userr']) || isset($_POST['save'])) {
    $AccountId = $_POST['AccId'];
} else {
    header("Location: index.php");
    exit();
}

if (isset($_POST['save'])) {
    $phone = $_POST['Phone'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $House = $_POST['House'];
    $Subdivision = $_POST['Subdivision'];
    $City = $_POST['City'];
    $Country = $_POST['Country'];
    $Gender = $_POST['Gender'];
    $Postal = $_POST['Postal'];

    $stmt = $conn->prepare("UPDATE customer SET Phone=?, FirstName=?, LastName=?, House=?, Subdivision=?, City=?, Country=?, Gender=?, PostalCode=? WHERE Id=?");
    $stmt->bind_param("sssssssssi", $phone, $FirstName, $LastName, $House, $Subdivision, $City, $Country, $Gender, $Postal, $AccountId);

    if ($stmt->execute()) {
        $showSuccessOverlay = true; 
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SnY Profile</title>
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
            width: 100%;
        }
        .profile-info div {
            margin-bottom: 15px;
        }
        .profile-info label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .profile-info input[type="text"],
        .profile-info input[type="number"],
        .profile-info select {
            width: calc(100% - 20px);
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .profile-info input[readonly] {
            background-color: #e9e9e9;
        }
        .profile-info p {
            margin: 0;
        }
        .profile-info select {
            width: 100%;
            padding: 8px;
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
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        .overlay-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            width: 300px;
        }

        .overlay-content h2 {
            margin-bottom: 20px;
            color: #473C38;
        }

        .overlay-content button {
            padding: 10px 20px;
            background-color: #473C38;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .overlay-content button:hover {
            background-color: #fc6c85;
        }
        .styled-submit {
            background-color: #4c3228;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .styled-submit:hover {
            background-color: #ff5e6b;
        }

    </style>
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="pics/Tops/LOGO.png" style="max-width: 100px;" alt="Logo">
            <h2>Edit Profile</h2>
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
            <div class="profile-info">
                <form method="POST">
                    <div>
                        <label>Email Address:</label>
                        <p><input type="text" value="<?php echo $email; ?>" name="Username" readonly></p>
                    </div>
                    <div>
                        <label>Mobile Phone:</label>
                        <p><input type="number" value="<?php echo $phone; ?>" name="Phone"></p>
                    </div>
                    <div>
                        <label>Name:</label>
                        <p>Last Name: <input type="text" value="<?php echo $LastName; ?>" name="LastName"></p>
                        <p>First Name: <input type="text" value="<?php echo $FirstName; ?>" name="FirstName"></p>
                    </div>
                    <div>
                        <label>Birthday:</label>
                        <p><input type="text" value="<?php echo $birthday; ?>" name="Birthday" readonly></p>
                    </div>
                    <div>
                        <label>Address:</label>
                        <p>House No./Street <input type="text" value="<?php echo $House; ?>" name="House"></p>
                        <p>Brgy./Village/Subdivision <input type="text" value="<?php echo $Subdivision; ?>" name="Subdivision"></p>
                        <p>Municipality/City <input type="text" value="<?php echo $City; ?>" name="City"></p>
                        <p>Country <input type="text" value="<?php echo $Country; ?>" name="Country"></p>
                    </div>
                    <div>
                        <label>Gender:</label>
                        <p>
                            <select name="Gender" required>
                                <option hidden>GENDER</option>
                                <option value="Male" <?php echo ($Gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($Gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="GAY" <?php echo ($Gender == 'GAY') ? 'selected' : ''; ?>>GAY</option>
                            </select>
                        </p>
                    </div>
                    <div>
                        <label>Postal Code:</label>
                        <p><input type="text" value="<?php echo $Postal; ?>" name="Postal"></p>
                    </div>
                    <div>
                    <p><input type="submit" name="save" value="Save" class="styled-submit"></p>
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
                <form action="Edit.php" method="post" class="active">
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

    <div class="overlay" id="successOverlay">
        <div class="overlay-content">
            <h2>Update Successful!</h2>
            <p>Your profile has been updated.</p>
            <button onclick="closeSuccessOverlay()">OK</button>
        </div>
    </div>

    <script>
        function closeSuccessOverlay() {
            document.getElementById('successOverlay').style.display = 'none';
        }

        <?php if ($showSuccessOverlay): ?>
            document.getElementById('successOverlay').style.display = 'flex';
        <?php endif; ?>
    </script>
</body>
</html>

