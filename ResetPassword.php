<?php
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, "sny");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$AccountId = "";

if(isset($_POST['fp'])) {
    $AccountId = $_POST['AccId'];
}

if(isset($_POST['changepass'])) {
    if(!empty($_POST['newpassword']) && !empty($_POST['confpassword'])) {
        $newpass = $_POST['newpassword'];
        $confpass = $_POST['confpassword'];
        
        if ($newpass === $confpass) {
            // Prepare the SQL statement with placeholders
            $updateSql = "UPDATE customer SET Password = ? WHERE Id = ?";
            
            // Prepare the statement
            $stmt = $conn->prepare($updateSql);
            
            // Bind parameters
            $stmt->bind_param("si", $newpass, $AccountId);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Password updated successfully
                echo "Password updated successfully.";
                // Optionally, provide a form or link to redirect the user
                echo '<form action="index.php">';
                echo '<input type="submit" name="login" value="LOGIN">';
                echo '</form>';
            } else {
                // If there was an error updating the password, display the error message
                echo "Error updating password: " . $conn->error;
            }
            
            // Close the statement
            $stmt->close();
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 95vh;
            text-align: center;
        }
        .container {
            position: absolute;
            width: auto;
            margin: auto;
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
    </style>
</head>
<body>
    <?php echo $AccountId;?>
    <div class="container">
        <div class="info">
            <img src="pics/Tops/Logo.png" alt="logo" class="logo">
            <h3 class="title">CHANGE YOUR PASSWORD</h3>
            <p>Please enter a new password.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="POST">
                <div class="input-box">
                    <input type="password" name="newpassword" id="password" placeholder="NEW PASSWORD" autocomplete="off">
                    <p></p>
                    <input type="password" name="confpassword" id="password" placeholder="CONFIRM PASSWORD" autocomplete="off">
                </div>
                
                <div class="column">
                    <input type="submit" class="btn" name="changepass" value="CHANGE MY PASSWORD">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
