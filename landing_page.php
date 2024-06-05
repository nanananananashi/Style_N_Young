<?php
session_start();
if(isset($_POST['cart'])) {
    $id = $_POST['AccId'];
}

if (isset($_SESSION['cart'])) {
    $id = $_SESSION['cart'];
} else {
    header("Location: index.php"); 
    exit();
}

if($id===("")){
        header("Location: index.php");
        exit();
    }


$db = new mysqli('localhost', 'root', '', 'sny');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT FirstName FROM customer WHERE Id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STYLE ‘N YOUNG</title>
    <link rel="shortcut icon" type="image/png" href="pics/Tops/LOGO.png"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.cdnfonts.com/css/hyper-blob?styles=148123" rel="stylesheet">
    <style>
        @import url('https://fonts.cdnfonts.com/css/hyper-blob?styles=148123');  

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

        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0;
            position: relative;
        }

        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 92%;
            z-index: 999;
            background-color: #473C38;
            padding: 70px;
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
            font-family: "Courier New", "Lucida Console", monospace;
            position: absolute;
            top: 80px;
            left: 150px;
            z-index: 999;
            color: #fff;
        }

        .categories ul {
            list-style-type: none;
            margin: 0;
            padding: 5px;
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
            transition: color 0.8s ease;
            padding: 15px;
            font-size: 1rem;
        }

        .categories input[type="submit"]:hover {
            text-decoration: underline;
            color: #ffc0cb;
        }

        .categories input[type="submit"].active {
            color: #ffc0cb;
            text-decoration: underline;
        }

        .search {
            font-family: "Courier New", "Lucida Console", monospace;
            position: absolute;
            top: 80px;
            right: 200px;
            z-index: 999;
            background-color: #473C38;

        }

        .search input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;

        
        }
        ::placeholder {
            font-style: italic;
            font-size: 1.1rem;
        }
        .search input[type="submit"] {

        }
        .search input[type="submit"]:hover {
            background-color: #fc6c85;
        
        }

        .login-signup {
            font-family: "Courier New", "Lucida Console", monospace;
            position: absolute;
            top: 87px;
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
            transition: color 0.8s ease;
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
            text-decoration: underline;
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
            border: 1px solid #e3d3b3;
            border-radius: 10px;
            background-color: #e3d3b3;
            text-align: center;
            transition: transform 0.3s ease; 
        }
        .card:hover {
            transform: scale(1.15); 
        }

        .card img {
            width: 100%;
            border-radius: 5px;
        }

        .card h3 {
            text-align: center;
        }
       .card h5{
        top: 100px;
        text-align: right;
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
            margin-top: 200px; /* Adjust the margin-top */
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

        #closeBtn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 1.2rem;
            color: #333;
            cursor: pointer;
        }
        .search input[type="submit"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #4c3228;
        color: #fff;
        cursor: pointer;
        font-size: 1rem;
        }
        .search input[type="submit"]:hover {
        background-color: #e83e53;
        }
    </style>
</head>
<body>

<div id="header-wrapper">
<header>
    <div class=brand>
        <h1>STYLE 'N YOUNG</h1>
    </div>
    <div class="user">
        <form action="Profile.php" method="post">
        <h6>
    <input type="submit" name="userr" value=""></h6>            
    <input type="hidden" name="AccId" value="<?php echo $id; ?>">
    </form>
        </div>
    <div class="logo">
        <a href="#"><img src="pics/Tops/LOGO.png" alt="logo"></a>
    </div>
    <div class="categories">
    <form method="post">
        <input type="hidden" name="activeCategory" value="New Arrivals">
        <input type="submit" name="Categor" value="New Arrivals" class="<?= isset($_POST['activeCategory']) && $_POST['activeCategory'] == 'New Arrivals' ? 'active' : '' ?>">
    </form>
    <form method="post">
        <input type="hidden" name="activeCategory" value="Men">
        <input type="submit" name="Categor2" value="Men" class="<?= isset($_POST['activeCategory']) && $_POST['activeCategory'] == 'Men' ? 'active' : '' ?>">
    </form>
    <form method="post">
        <input type="hidden" name="activeCategory" value="Women">
        <input type="submit" name="Categor3" value="Women" class="<?= isset($_POST['activeCategory']) && $_POST['activeCategory'] == 'Women' ? 'active' : '' ?>">
    </form>
    <form method="post">
        <input type="hidden" name="activeCategory" value="Discover">
        <input type="submit" name="Categor4" value="Discover" class="<?= isset($_POST['activeCategory']) && $_POST['activeCategory'] == 'Discover' ? 'active' : '' ?>">
    </form>
    <form method="post">
        <input type="hidden" name="activeCategory" value="Sale">
        <input type="submit" name="Categor" value="Best Seller" class="<?= isset($_POST['activeCategory']) && $_POST['activeCategory'] == 'Sale' ? 'active' : '' ?>">
    </form>
</div>

<div class="search">
    <form action="" method="post" id="searchForm">
        <input type="text" name="search" id="searchInput" placeholder="What are you looking for?">
        <input type="submit" value="Search">
    </form>
</div>

    <div class="login-signup">
    <form action="Cart.php" method="post">
            <button type="submit" name="cart" value="Cart">CART</button>
            <input type="hidden" name="AccId" value="<?php echo $id; ?>">
        </form>
        <form action="index.php" method="post">
            <button type="submit" name="login" value="logout">LOG OUT</button>
        </form>
    </div>
</header>
    </div>

    <div class="container">
    <div class="button-container">
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'sny');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM Items";
        $activeCategory = "New Arrivals";

        if (isset($_POST['activeCategory'])) {
            $activeCategory = $_POST['activeCategory'];

            switch ($activeCategory) {
                case 'New Arrivals':
                    $query = "SELECT * FROM Items";
                    break;
                case 'Men':
                    $query = "SELECT * FROM Items WHERE Gender ='Male'";
                    break;
                case 'Women':
                    $query = "SELECT * FROM Items WHERE Gender = 'Female'";
                    break;
                case 'Discover':
                    $query = "SELECT * FROM Items ORDER BY Stock DESC";
                    break;
                case 'Sale':
                    $query = "SELECT * FROM Items ORDER BY Sold DESC";
                    break;
            }
        }

        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
            $query = "SELECT * FROM Items WHERE Name LIKE '%$searchTerm%' OR Gender LIKE '%$searchTerm%' OR Details LIKE '%$searchTerm%' OR Price LIKE '%$searchTerm%'";
        }

        $result = mysqli_query($conn, $query);

        if ($result) {
            $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($items as $item) {
                echo '<div class="card">';
                echo '<form action="Main.php" id="loginBtnForm" method="post">';
                echo '<input type="hidden" name="AccountId" value="' . $id . '">';
                echo '<input type="hidden" name="ItemId" value="' . $item['ItemID'] . '">';
                echo '<button type="submit" name="carded" value="' . $item['pic1'] . '">';
                echo '<img src="pics/Male/' . $item['pic1'] . '.png" alt="' . $item['Name'] . '">';
                echo '<h3>' . $item['Name'] . '</h3>';
                echo '<h5>₱' . number_format($item['Price'], 2) . '</h5>'; 
                  echo '</button>';
                echo '</form>';
                echo '</div>';
            }

            mysqli_free_result($result);
        } else {
            echo "Error retrieving items: " . mysqli_error($conn);
        }

        mysqli_close($conn);
        ?>
    </div>
</div>



    </div>

    <div class="footer">
        <p> 2024 STYLE ‘N YOUNG. All rights reserved.</p>
        <p>Follow Us:</p>
        <ul>
            <li><a href="https://www.facebook.com/sharleen1228">Facebook</a></li>
            <li><a href="https://www.facebook.com/sharleen1228">Instagram</a></li>
            <li><a href="https://www.facebook.com/sharleen1228">Twitter</a></li>
        </ul>
    </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('closeBtn').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'none';
    });
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
