<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sny";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ItemId, Name, pic1, pic2, pic3 FROM Items WHERE ItemId = 1";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?php 
    foreach($items as $item) {
        echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8');
    } 
    ?>
    </title>
    <style>
        /* Reset CSS */
        body, h1, h2, h3, p, ul {
            margin: 0;
            padding: 0;
        }

        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding-top: 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0;
            position: relative;
        }

        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 93%;
            z-index: 999;
            background-color: #4c3228;
            padding: 60px;
            border-radius: 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #fff;
        }

        header p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 999;
        }

        .logo a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 1.2rem;
        }

        .categories {
            position: absolute;
            top: 70px;
            left: 150px;
            z-index: 999;
            color: #fff;
        }

        .categories ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .categories li {
            display: inline-block;
            margin-right: 20px;
        }

        .categories li:last-child {
            margin-right: 0;
        }

        .categories form {
            display: inline-block;
        }

        .categories input[type="submit"] {
            background-color: transparent;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s ease;
            padding: 0;
            font-size: 1rem;
        }

        .categories input[type="submit"]:hover {
            color: #ffc0cb;
        }

        .categories input[type="submit"].active {
            color: #ffc0cb;
        }

        .search {
            position: absolute;
            top: 70px;
            right: 200px;
            z-index: 999;
        }

        .search input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .login-signup {
            position: absolute;
            top: 70px;
            right: 20px;
            z-index: 999;
        }

        .login-signup form {
            display: inline-block;
        }

        .login-signup button,
        .login-signup a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s ease;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            margin-left: 10px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .login-signup button:hover,
        .login-signup a:hover {
            color: #ffc0cb;
        }

        .cta {
            text-align: center;
            margin-bottom: 40px;
        }

        .cta .cta-button {
            display: inline-block;
            padding: 15px 30px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 1.2rem;
        }

        .cta .cta-button:hover {
            background-color: #e83e53;
        }

        .footer {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid #ccc;
        }

        .footer p {
            margin-bottom: 10px;
        }

        .footer ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .footer ul li {
            display: inline-block;
            margin-right: 10px;
        }

        .footer ul li:last-child {
            margin-right: 0;
        }

        .footer ul li a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .footer ul li a:hover {
            color: #ff5e6b;
        }

        .card {
            width: 200px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .card img {
            width: 100%;
            border-radius: 5px;
        }

        .card h2 {
            text-align: center;
        }

        .card button {
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            font: inherit;
            outline: inherit;
            width: 100%;
            color: #333;
            font-weight: bold;
            margin-top: 10px;
        }

        .button-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-around;
            width: 100%;
            margin-top: 200px; 
        }

        

        .login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
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
        }

        .login-form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #4c3228;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #e83e53;
        }

        .login-form .signup-button {
            background-color: #ffc0cb;
            margin-top: 10px;
            color: #4c3228;
        }

        .login-form .signup-button:hover {
            background-color: #ff5e6b;
        }

        .login-form p {
            color: #ff5e6b;
        }


        
        
        .stacked-images {
            position: fixed;
            top: 200px; /* Adjust the top position as needed */
            left: 125px; /* Adjust the left position as needed */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2px;
}

        .stacked-images img {
            width: 100%; 
            margin-bottom: 10px;
        }

        .slideshow-container {
            position: absolute;
            max-width: 350px;
            margin: auto;
            top: 200px;
            left: 250px;
        }

        .slides {
            display: none;
        }

        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover, .next:hover {
            background-color: rgba(0,0,0,0.8);
        }

        .caption {
            color: #fff;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .item {
        position: relative;
        top: 200px;
        left: 100px;
}
        
    </style>
</head>
<body>

<div id="header-wrapper">
    <header>
        <div class="logo">
            <a href="#"><img src="pics/Tops/LOGO.png" alt="logo"></a>
        </div>
        <div class="categories">
            <form action="landing_page.php" method="post">
                <input type="hidden" name="activeCategory" value="Go Back">
                <input type="submit" name="Categor" value="Go Back" class="<?= isset($_POST['activeCategory']) && $_POST['activeCategory'] == 'New Arrivals' ? 'active' : '' ?>">
            </form>
        </div>

        <div class="login-signup">
            <form action="Land.php" method="post">
                <button type="submit" name="login" value="logout">Log out</button>
            </form>
        </div>
    </header>
</div>


<div class="stacked-images">
    <?php foreach($items as $item): ?>
        <div class="picc2">
            <?php echo '<img src="pics/Male/' . $item['pic1'] . '.png" alt="' . htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8') . '" style="width:7%">'; ?>
        </div>
        <div class="picc2">
            <?php echo '<img src="pics/Male/' . $item['pic2'] . '.png" alt="' . htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8') . '" style="width:7%">'; ?>
        </div>
        <div class="picc2">
            <?php echo '<img src="pics/Male/' . $item['pic3'] . '.png" alt="' . htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8') . '" style="width:7%">'; ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="slideshow-container">
    <?php foreach($items as $item): ?>
        <div class="slides">
            <?php echo '<img src="pics/Male/' . $item['pic1'] . '.png" alt="' . htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8') . '" style="width:100%">'; ?>
            <div class="caption"><?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="slides">
            <?php echo '<img src="pics/Male/' . $item['pic2'] . '.png" alt="' . htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8') . '" style="width:100%">'; ?>
            <div class="caption"><?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="slides">
            <?php echo '<img src="pics/Male/' . $item['pic3'] . '.png" alt="' . htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8') . '" style="width:100%">'; ?>
            <div class="caption"><?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
    <?php endforeach; ?>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
    <div class="h2-container">
        <?php foreach($items as $item): ?>
            <div class="item">
                <h2>
                    <?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?>
                </h2>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div class="footer">
        <p>&copy; 2024 STYLE ‘N YOUNG. All rights reserved.</p>
        <p>Follow Us:</p>
        <ul>
            <li><a href="https://www.facebook.com/sharleen1228">Facebook</a></li>
            <li><a href="https://www.facebook.com/sharleen1228">Instagram</a></li>
            <li><a href="https://www.facebook.com/sharleen1228">Twitter</a></li>
        </ul>
    </div>

<script>
    let slideIndex = 0;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        let slides = document.getElementsByClassName("slides");
        if (n >= slides.length) { slideIndex = 0 }
        if (n < 0) { slideIndex = slides.length - 1 }
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex].style.display = "block";
    }

    window.addEventListener('scroll', function() {
        var header = document.querySelector('header');
        var wrapper = document.getElementById('header-wrapper');

        if (window.pageYOffset > 0) { 
            header.style.position = 'fixed';
            header.style.top = '0';
            wrapper.style.height = header.offsetHeight + 'px'; 
        } else {
            header.style.position = 'absolute';
            header.style.top = '0px';
            wrapper.style.height = 'auto'; 
        }
    });
</script>

</body>
</html>
