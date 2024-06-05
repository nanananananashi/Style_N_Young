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

$ItemId = ""; 

if (isset($_POST['addToCart'])) {
    $ItemId = $_POST['ItemId'];
    $AccountId = $_POST['AccountId'];
    $Quantity = $_POST['Quantity'];

    $ItemId = $conn->real_escape_string($ItemId);
    $AccountId = $conn->real_escape_string($AccountId);
    $Quantity = $conn->real_escape_string($Quantity);

    $sql = "INSERT INTO Cart (ItemId, UserId, Quantity) VALUES ('$ItemId', '$AccountId', '$Quantity')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo '    document.getElementById("welcomeOverlay").style.display = "block";';
        echo '    setTimeout(function(){';
        echo '        document.getElementById("welcomeOverlay").style.display = "none";';
        echo '        window.location.href = "landing_page.php";'; 
        echo '    }, 2500);';
        echo '});';
        echo '</script>';
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if(isset($_POST['carded'])) {
    $ItemId = $_POST['ItemId'];
}

if(isset($_POST['carded'])) {
    $AccountId = $_POST['AccountId'];
} 

if (isset($_POST['comm'])) {
    $AccountId = $_POST['AccountId'];
}

if($AccountId === ""){
    header("Location: index.php");
    exit();
}

$ItemId = $conn->real_escape_string($ItemId);

$sql = "SELECT FirstName, Username FROM customer WHERE Id = '$AccountId'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $name[] = $row;
    }
    $userr = $name[0]['FirstName'];
}

$ItemId = $conn->real_escape_string($ItemId);

$sql = "SELECT ItemId, Name, Details, Price, pic1, pic2, pic3 FROM Items WHERE ItemId = '$ItemId'";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 
    foreach($items as $item) {
        echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8');
    }
    ?>
    </title>
    <link rel="shortcut icon" type="image/png" href="pics/Tops/LOGO.png"> 

    <link href="https://fonts.cdnfonts.com/css/hyper-blob?styles=148123" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/street" rel="stylesheet">

        <style>
        @import url('https://fonts.cdnfonts.com/css/hyper-blob?styles=148123');  
        @import url('https://fonts.cdnfonts.com/css/street');     
        body, h1, h2, h3, p, ul {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #EDE9E8;
            color: #333;
            padding-top: 0;
        }

        header {
            font-family: "Courier New", "Lucida Console", monospace;
            position: absolute;
            top: 0;
            left: 0;
            width: 92%;
            z-index: 999;
            background-color: #473C38;
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
        .brand {
            font-size: 50px;
            font-family: 'Hyper Blob', sans-serif;
            position: absolute;
            top: 10px;
            left: 600px;px
            z-index: 999;
            color: #fff;        }
        .brand:hover{
            color: #fae8ed;
        }
        .user {
            font-size: 20px;
            font-family: 'Courier new', sans-serif;
            position: absolute;
            top: 0px;
            left: 1450px;
            z-index: 999;
            color: #fff;        
        }
        .user input[type="submit"] {
            border: none;
            background-color: transparent;
            color: #EDE9E8;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.3s ease;
            background-image: url('pics/Tops/set.png');
            background-size: 100%; 
            background-repeat: no-repeat;
            padding-left: 40px;
            height: 50px;
}

 
        .user input[type="submit"]:hover{
            color: #ffc0cb;


        }
        .user img{
            max-width: 50px;    
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

        .login-signup button {
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

        .login-signup button:hover {
            color: #ffc0cb;
        }

        .footer {
            position: absolute;
            bottom: -350px;
            width: 300%;
            left: 0;
            right: 0;
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid #ccc;
            background-color: #EDE9E8;
            color: #4c3228;

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
            color: #4c3228;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .footer ul li a:hover {
            color: #ff5e6b;
        }
        .stacked-images-container {
        position: absolute;
        top: 0px; 
        left: 15px; 
        }
        .stacked-images {
            position: relative;
            top: 200px; 
            left: 125px; 
        }

        .stacked-images img {
            width: 100%;
            margin-bottom: 10px;
        }

        .slideshow-container {
            position: absolute;
            max-width: 350px;
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
            border-radius: 0 3px 3px 
            0;
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
            font-family: 'Hyper Blob', sans-serif;
            color: #fff
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
            background-color: rgba(1, 0, 0, 0);
        }
        
        .item {
            position: absolute;
            top: 0px;
            left: 480px;
            max-width: 300px;


        }
        .item h1{
            font-family: 'Street', sans-serif;
            color: #pink;
        }
        .item h2{
            text-align: right;
            white-space: nowrap; 
        }
        .item h5{
            text-align: justify;
            white-space: normal;
            word-wrap: break-word;        
        }
        .addcart {
    display: inline-block;
    margin-left: 175px;
    margin-top: 20px;
}


.addcart .add-to-cart-button {
    background-color: #4c3228;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.addcart .add-to-cart-button:hover {
    background-color: #ff5e6b;
}

        .comments-container {
    position: absolute;
    top: 0px;
    left: 900px; 
    width: 300px; 
    background-color: #f9f9f9; 
    padding: 20px; 
    border-radius: 5px; /
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
}

.comment-section {
    margin-bottom: 20px;
}

.comment-section h3 {
    text-align: center; 
    margin-bottom: 10px; 
}

.comment-section form {
    margin-bottom: 20px; 
}

.comment-section input[type="text"],
.comment-section textarea {
    width: 90%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.comment-section input[type="submit"] {
    background-color: #4c3228;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.comment-section input[type="submit"]:hover {
    background-color: #ff5e6b;
}

.comments {
    max-height: 300px; 
    overflow-y: auto; 
}

.comments p {
    margin-bottom: 10px; 
}

.comments p strong {
    color: #4c3228; 
}

.comments p:last-child {
    margin-bottom: 0; 
}

.product-quantity > input {
    width: 60px;
    padding: 5px;
    text-align: center;
    margin-right: -100px;
    margin-bottom: 30px;
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
</head>
<body>

<div id="header-wrapper">
    <header>
    <div class=brand>
        <h1>STYLE 'N YOUNG</h1>
    </div>
        <div class="logo">
            <a href="#"><img src="pics/Tops/LOGO.png" alt="logo"></a>
        </div>
        <div class="user">
        <form action="Profile.php" method="post">
        <h6>
    <input type="submit" name="userr" value=""></h6>            
    <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
    </form>
        </div>

        <div class="categories">
            <form action="landing_page.php" method="post">
                <input type="hidden" name="activeCategory" value="Go Back">
                <input type="submit" name="Categor" value="Go Back" class="<?= isset($_POST['activeCategory']) && $_POST['activeCategory'] == 'New Arrivals' ? 'active' : '' ?>">
            </form>
        </div>

        <div class="login-signup">
        <form action="Cart.php" method="post">
            <button type="submit" name="cart" value="Cart">CART</button>
            <input type="hidden" name="AccId" value="<?php echo $AccountId; ?>">
        </form>
            <form action="index.php" method="post">
                <button type="submit" name="login" value="logout">LOG OUT</button>
            </form>
        </div>
    </header>
</div>
<div class="stacked-images-container">
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
                <h1>
                    <?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?>
                </h1>
                <h2>
                    <?php echo "<br>" . htmlspecialchars($item['Price'], ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <h5>
                <?php echo "<br>" . htmlspecialchars($item['Details'], ENT_QUOTES, 'UTF-8'); ?>
        </h5>
        
        <div class="addcart">
        <form action="#" method="post">
                    <input type="hidden" name="ItemId" value="<?php echo $item['ItemId']; ?>">
                    <input type="hidden" name="AccountId" value="<?php echo $AccountId; ?>">
                    <p class="product-quantity">Quantity: <input type="number" name="Quantity" value="1" min="1"></p>
                    <input type="submit" name="addToCart" value="Add to Cart" class="add-to-cart-button" >
                </form>
            </div>
            </div>
            <div>
        <?php endforeach; ?>
    </div>
</div>

<div class="footer">
    <p>2024 STYLE ‘N YOUNG. All rights reserved.</p>
    <p>Follow Us:</p>
    <ul>
        <li><a href="https://www.facebook.com/sharleen1228">Facebook</a></li>
        <li><a href="https://www.facebook.com/sharleen1228">Instagram</a></li>
        <li><a href="https://www.facebook.com/sharleen1228">Twitter</a></li>
    </ul>
</div>
<div class="comments-container">
    <div class="comment-section">
        <h3>Comments</h3>
        <form id="commentForm" method="post" action="Main.php">
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($userr); ?>" required>
            <textarea name="comment" placeholder="Your Comment" required></textarea>
            <input type="hidden" name="AccountId" value="<?php echo htmlspecialchars($AccountId); ?>">
            <input type="submit" value="Comment" name="comm">
            <input type="hidden" name="ItemId" value="<?php echo htmlspecialchars($item['ItemId']); ?>">
        </form>
    </div>

    <?php
    if (isset($_POST["comm"])) {
        if (isset($_POST["name"], $_POST["comment"], $_POST["ItemId"], $_POST["AccountId"])) {
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $ItemId = $_POST["ItemId"];

            $sql = "INSERT INTO comments (ItemId, name, comment) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $ItemId, $name, $comment);

            if ($stmt->execute()) {
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Please provide all required information";
        }
    }

    $ItemId = isset($_POST["ItemId"]) ? $_POST["ItemId"] : $item['ItemId'];
    $sql = "SELECT name, comment FROM comments WHERE ItemId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ItemId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='comments'>";
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row["name"]) . ":</strong> " . htmlspecialchars($row["comment"]) . "</p>";
        }
        echo "</div>";
    } else {
        echo "No comments yet.";
    }
    ?>
</div>



<div class="overlay" id="welcomeOverlay">
    <button class="exit-btn-welcome" id="closeWelcomeBtn">X</button>
    <div class="login-form">
        <h2>S'nY</h2>
        <img src="pics/Tops/LOGO.png" alt="logo">
        <p>You have successfully added to cart!</p>
    </div>
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

    function showOverlay() {
        document.getElementById("overlay").style.display = "block";
        setTimeout(function(){
            document.getElementById("overlay").style.display = "none";
        }, 3000);
    }
</script>
</body>
</html>
