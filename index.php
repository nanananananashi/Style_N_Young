<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uname"]) && isset($_POST["pass"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sny";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $uname = $conn->real_escape_string($_POST["uname"]);
    $pass = $conn->real_escape_string($_POST["pass"]);

    $sql = "SELECT * FROM Customer WHERE Username='$uname' AND Password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cart'] = $row["Id"];
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo '    document.getElementById("welcomeOverlay").style.display = "block";';
        echo '    setTimeout(function(){';
        echo '        document.getElementById("welcomeOverlay").style.display = "none";';
        echo '        window.location.href = "Landing_page.php";'; 
        echo '    }, 2500);';
        echo '});';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo '    document.getElementById("incorrectOverlay").style.display = "block";';
        echo '    setTimeout(function(){';
        echo '        document.getElementById("incorrectOverlay").style.display = "none";';
        echo '    }, 2000);';
        echo '});';
        echo '</script>';
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style 'N Young</title>
    <link rel="shortcut icon" type="image/png" href="pics/Tops/LOGO.png"> 
    <style>
        body, h1, h2, h3, p, ul {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            transition: background-image 1s ease-in-out;
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
            transition: all 0.3s ease-in-out;
        }

        .login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #EDE9E8;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            width: 300px;
            max-width: 80%;
            text-align: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
            color: #4c3228;
        }

        .login-form label {
            margin-bottom: 5px;
            color: #333;
            display: block;
        }

        .login-form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #473C38;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            color: #fae8ed;
        }

        .login-form button:hover {
            background-color: #fc6c85;
            color: #4c3228;
        }

        .login-form .signup-button {
            background-color: #EDE9E8;
            margin-top: 10px;
            color: #473C38;
        }

        .login-form .signup-button:hover {
            background-color: #fc6c85;
            color: #fae8ed;
            
        }

        .login-form p {
            color: #ff5e6b;
        }

        .exit-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 1.2rem;
            color: #fff;
            cursor: pointer;
            z-index: 9999;
        }

        .exit-btn:hover {
            color: #ff0f0f;
        }
        ::placeholder {
            font-style: italic;
        }
        .content {
            position: relative;
            z-index: 2;
            color: #fff;
            text-align: center;
            padding-top: 40vh;
        }

        .content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .content a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            background-color: #e3242b;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .content a:hover {
            background-color: #c72d42;
        }

        #incorrectOverlay {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            transition: all 0.3s ease-in-out;
            text-align: center;
        }
        #welcomeOverlay {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.9);
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
</head>
<body>

<div class="overlay" id="incorrectOverlay">
    <div class="login-form">
        <h2>Error</h2>
        <p>Incorrect Username or Password</p>
    </div>
</div>

<div class="overlay" id="overlay">
    <button class="exit-btn" id="closeBtn">X</button>
    <div class="login-form">
        <h2><img src="pics/Tops/LOGO.png" alt="logo"></h2>
        <form action="" method="post">
            <input type="text" id="username" placeholder="E-Mail" name="uname" value="<?php echo isset($_POST['uname']) ? htmlspecialchars($_POST['uname']) : ''; ?>" required>
            <input type="password" id="password" placeholder="Password" name="pass" required>
            <button type="submit" class="login-button" name="login">Login</button>
        </form>
        <form action="Registration.php" method="post">
            <button type="submit" class="signup-button">Sign Up</button>
        </form>
        <a href="ForgotPassword.php"><h6>Forgot Password</h6></a>
    </div>
</div>

<div class="overlay" id="welcomeOverlay">
    <button class="exit-btn-welcome" id="closeWelcomeBtn">X</button>
    <div class="login-form">
        <h2>Welcome</h2>
        <img src="pics/Tops/LOGO.png" alt="logo">
        <p>You have successfully logged in!</p>
    </div>
</div>



<div class="content">
    <h1>Welcome to Style 'N Young</h1>
    <p>Discover the latest trends in fashion</p>
    <a id="shopNowBtn">Shop Now</a>
</div>

<script>
    let currentImageIndex = 0;
    const images = [
        'pics/Tops/Land.png',
        'pics/Tops/Land2.png'
    ];

    function changeBackgroundImage() {
        document.body.style.backgroundImage = `url(${images[currentImageIndex]})`;
        currentImageIndex = (currentImageIndex + 1) % images.length;
    }

    changeBackgroundImage();
    setInterval(changeBackgroundImage, 5000);

    document.getElementById('closeBtn').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'none';
    });

    document.getElementById('shopNowBtn').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'block';
    });
    document.getElementById('closeWelcomeBtn').addEventListener('click', function() {
        document.getElementById('welcomeOverlay').style.display = 'none';
    });

</script>

</body>
</html>
