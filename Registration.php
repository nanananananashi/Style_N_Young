<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registration Page</title>
    <link rel="shortcut icon" type="image/png" href="pics/Tops/LOGO.png"> 
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
        * {
            padding: 0;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }
        body {
            background: #EDE9E8;
            color: #473C38;
        }
        .logo {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        .container {
            position: relative;
            max-width: 700px;
            margin-top: 3px;
            margin-left: 10px;
            width: 100%;
            padding: 25px;
        }
        .container header {
            font-size: 25px; 
            font-weight: bold; 
            color: #473C38;
        }
        .container .form {
            margin-top: 5px;
        }
        .form .input-box {
            width: 500px;
            height: 70px;
            margin-top: 10px;
        }
        .input-box label {
            color: #473C38;
        }
        .form :where(.input-box input) {
            height: 40px;
            width: 450px;
            font-size: 15px;
            padding: 1 10px;
            border: none;
            background: transparent;
            border-bottom: 1px solid #44362A;
        }
        ::placeholder {
            color: #473C38;
        }
        .form .column {
            display: flex;
            column-gap: 40px;
        }
        .form .gender-box {
            margin-top: 0px;
            margin-left: 1px;
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 15px;
        }
        .form :where(.gender-option, .gender) {
            display: flex;
            align-items: center;
            column-gap: 50px;
            flex-wrap: wrap;
        }
        .form .gender {
            column-gap: 10px;
        }
        .gender input {
            accent-color: #473C38;
            height: 18px; 
            width: 18px;
        }
        .form :where(.gender input, .gender label) {
            cursor: pointer;
        }
        .gender label {
            color: #473C38;
        }
        .address :where(input, .select-box) {
            margin-top: 15px;
        }
        .select-box select {
            height: 50px;
            width: 450px;
            outline: #473C38;
            border: none;
            color: #473C38;
            background: transparent;
            border-bottom: 1px solid #44362A;
            font-size: 15px;
        }
        .form .btn{
            position: fixed;
            bottom: 45px;
            right: 45px; 
            height: 50px;
            background: #473C38;
            border: 0;
            color: #fff;
            font-size: 12px;
            cursor: pointer;
            transition: all .3s;
            padding: 0 50px;
        }
        .btn:hover{
            opacity: 0.80;
        }
        @media screen and (max-width: 500px) {
            .form .column {
                flex-wrap: wrap;
            }
            .form :where(.gender-option, .gender) {
                row-gap: 15px;
            }
        }
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 2em;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div id="overlay">Registration Completed</div>
    <div class="logo">
        <img src="pics/Tops/LOGO.png" alt="LOGO" style="width:75px; height:75px;">
    </div>
    <section class="container">
        <header>INFORMATION</header>
        <div class="links">
            Have an account: <a href="index.php" style="color:#473C38">LOG IN HERE</a><br><br>
            <label>Please enter all required fields<br> Please make sure that you have not yet signed up before.</label>
        </div>
        <form action="" class="form" method="post">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $conn = new mysqli($servername, $username, $password, "sny");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if(isset($_POST['register'])) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $birthdate = $_POST['birthdate'];
                    $gender = $_POST['gender'];
                    $address = $_POST['address'];
                    $appartment = $_POST['appartment'];
                    $postal = $_POST['postal'];
                    $city = $_POST['city'];
                    $country = $_POST['country'];
                    $phone = $_POST['phone'];

                    $checkEmailQuery = "SELECT * FROM customer WHERE Username='$email'";
                    $checkEmailResult = $conn->query($checkEmailQuery);

                    if ($checkEmailResult->num_rows > 0) {
                        echo '<p><center style="color:red;">Email already exists. Please use a different email.</center></p>';
                    } else {
                        $sql = "INSERT INTO customer (Username, Password, LastName, FirstName, Birthday, Gender, Phone, House, Subdivision, PostalCode, City, Country) VALUES ('$email', '$password', '$lastname', '$firstname', '$birthdate', '$gender', '$phone', '$address', '$appartment', '$postal', '$city', '$country')";

                        if ($conn->query($sql) === TRUE) {
                            echo "<script>
                                    document.getElementById('overlay').style.display = 'flex';
                                    setTimeout(function() {
                                        window.location.href = 'index.php';
                                    }, 3000);
                                  </script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }
            }
            $conn->close();
            ?>
            <div class="column">
                <div class="input-box">
                    <input type="text" name="email" id="email" placeholder="EMAIL*" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="PASSWORD*" autocomplete="off" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <input type="text" name="firstname" id="fName" placeholder="FIRST NAME*" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="text" name="lastname" id="lName" placeholder="LAST NAME*" autocomplete="off" required>
                </div>
            </div>
            <div class="input-box" style="width: 325px;">
                <input placeholder="BIRTHDATE*" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="birthdate" id="date" autocomplete="off" required>
            </div> 
            <div class="gender-box">
                <label>GENDER</label>
                <div class="gender-option">
                    <div class="gender">
                        <input type="radio" id="check-male" name="gender" value="Male" checked />
                        <label for="check-male" style="font-size: 15px;">MALE</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check-female" name="gender" value="Female" />
                        <label for="check-female" style="font-size: 15px;">FEMALE</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check-other" name="gender" value="Other"/>
                        <label for="check-other">PREFER NOT TO SAY</label>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <input type="text" name="address" id="add" placeholder="HOUSE NO./STREET*" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="text" name="appartment" id="appartment" placeholder="SUBDIVISION, VILLAGE (OPTIONAL)" autocomplete="off">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <input type="number" name="postal" id="postal" placeholder="POSTAL*" autocomplete="off" required maxlength="4">
                </div>
                <div class="input-box">
                    <input type="text" name="city" id="city" placeholder="CITY*" autocomplete="off" required>
                </div>
            </div>
            <div class="column">
                <div class="select-box">
                    <select name="country" required>
                        <option hidden>COUNTRY</option>
                        <option selected>Philippines</option>
                        <option>America</option>
                        <option>Japan</option>
                        <option>India</option>
                        <option>Canada</option>
                        <option>Germany</option>
                        <option>Brazil</option>
                        <option>Australia</option>
                        <option>France</option>
                        <option>China</option>
                        <option>Mexico</option>
                        <option>South Africa</option>
                        <option>Italy</option>
                        <option>United Kingdom</option>
                        <option>South Korea</option>
                        <option>Russia</option>
                        <option>Spain</option>
                        <option>Indonesia</option>
                        <option>Turkey</option>
                        <option>Egypt</option>
                    </select>
                </div>
                <div class="input-box">
                    <input type="text" name="phone" id="phone" placeholder="PHONE*" autocomplete="off" maxlength="11" required>
                </div>
            </div>
            <input type="submit" class="btn" name="register" value="REGISTER" required>
        </form>
    </section>
</body>
</html>
