<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="shortcut icon" type="image/png" href="pics/Tops/LOGO.png"> 

</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
*{
    font-family: 'Open Sans', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    background: #EDE9E8;
    color: #473C38;
    text-align: center;
}
.container {
    width: 500px;
    margin: auto;
    text-align: center;
    margin-top: 80px;
    padding-left: 30px;
}
.logo{
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
    padding: 2px;
    border: none;
    background: transparent;
    border-bottom: 1px solid #44362A;
}
::placeholder {
    color: #473C38;
}
.verify{
    padding: 15px;
    font-size: 23px;
    font-weight: 650;
    margin-top: 15px;
    text-align: left;
}
.column{
    display: flex;
    gap: 30px;
    text-align: center;
}
.list-option{
    padding-top: 10px;
    text-align: left;
}
.list{
    padding-bottom: 25px;
    padding-left: 15px;
    display: flex;
    align-items: center;
}
.list label {
    color: #473C38;
    font-size: 15px;
    padding-left: 10px;
}
.list input{
    accent-color: #473C38;
    height: 18px; /* Adjust the height of the radio button */
    width: 18px;
}
.list-input{
    margin-top: -12px;
}
.list-box{
    margin-top: 2px;
}
.form .list-box input {
    left: 400px;
    width: 300px;
    height: 20px;
    margin-top: 20px;
    font-size: 15px;
    border: none;
    background: transparent;
    border-bottom: 1px solid #44362A;
}
.form .btn{
    height: 50px;
    background: #473C38;
    border: 0;
    color: #fff;
    font-size: 12px;
    cursor: pointer;
    padding: 0 50px;
    margin: 10px;
    position: relative;
}
.btn{
    height: 50px;
    background: #473C38;
    border: 0;
    color: #fff;
    font-size: 12px;
    cursor: pointer;
    padding: 0 50px;
    margin: 10px;
    position: relative;
}
.btn:hover{
    opacity: 0.80;
}
@media screen and (max-width: 1200px) {
    .container {
        max-width: 100%;
    }
}
.loginn input[type="submit"]
{
    left: 30px;
    height: 50px;
    background: #473C38;
    border: 0;
    color: #fff;
    font-size: 12px;
    cursor: pointer;
    padding: 0 50px;
    margin: 10px;
    position: relative;
}
.proced input[type="submit"]{
    left: 10px;
    height: 50px;
    background: #473C38;
    border: 0;
    color: #fff;
    font-size: 12px;
    cursor: pointer;
    padding: 0 50px;
    margin: 10px;
    position: relative;
}
.bton{
    left: 650px;
    height: 50px;
    background: #473C38;
    border: 0;
    color: #fff;
    font-size: 12px;
    cursor: pointer;
    padding: 0 50px;
    margin: 10px;
    position: relative;
}
</style>
<body>
<div class="container">
        <img src="pics/Tops/LOGO.png" alt="logo" class="logo">
        <h3 class="title">RESET PASSWORD</h3>
        <p>Please enter your registered email address and information chosen from the below list for verification.</p>
        <form action="" class="form" method="post">
            <div class="input-box">
                <input type="text" name="email" id="email" placeholder="EMAIL*" autocomplete="off" required>
            </div>
        
            <h3 class="verify">VERIFICATION</h3>
            <div class="column">
                <div class="list-input">
                    <div class="list-box">
                        <h4><pre>POSTAL:        <input type="text" name="postal" id="postal" placeholder="Please enter your postal code" autocomplete="off" required></pre></h4>
                    </div>

                    <div class="list-box">
                        <h4><pre>BIRTHDAY:   <input type="date" placeholder="dd/mm/yyyy" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" name="birthdate" autocomplete="off" required></pre></h4>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn" name="submit" value="SUBMIT">
        </form>
    </div>
<?php
if(isset($_POST['submit'])) {
    $email = $_POST['email'];

    $postal_code = $_POST['postal'];
    $birthdate = $_POST['birthdate'];

    $conn = new mysqli('localhost', 'root', '', 'sny');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM customer WHERE Username = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $saved_postal_code = $row['PostalCode'];
        $saved_birthdate = $row['Birthday'];
        $AccountId = $row['Id'];

        if ($postal_code === $saved_postal_code && $birthdate === $saved_birthdate) {
            echo 'Email confirmed!';
            echo '<div class="proced">';
            echo '<form action="" method="POST">';
            echo '<input type="submit" name="fp" value="PROCEED">';
            echo '<input type="hidden" name="AccId" value="' . $AccountId . '">';
            echo '</div>';
            echo '</form>';
            exit;
        } else {
            echo "Postal code or birthdate does not match.";
        }
    } else {
        echo "User with this email does not exist.";
    }
}
if(isset($_POST['fp'])){
    $AccountId = $_POST['AccId'];
    
    echo '<h3 class="title">CHANGE YOUR PASSWORD</h3>';
    echo '<p>Please enter a new password.</p>';
    echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" class="form" method="POST">';
    echo '<div class="input-box">';
    echo '<input type="password" name="newpassword" id="password" placeholder="NEW PASSWORD" autocomplete="off">';
    echo '<p></p>';
    echo '<input type="password" name="confpassword" id="password" placeholder="CONFIRM PASSWORD" autocomplete="off">';
    echo '</div>';
    echo '<div class="column">';
    echo '<input type="submit" class="bton" name="changepass" value="CHANGE MY PASSWORD">';
    echo '<input type="hidden" name="AccId" value="' . $AccountId . '">';
    echo '</div>';
    echo '</form>';
}

if(isset($_POST['changepass'])) {
    if(!empty($_POST['newpassword']) && !empty($_POST['confpassword'])) {
        $newpass = $_POST['newpassword'];
        $confpass = $_POST['confpassword'];

        if ($newpass === $confpass) {
            $conn = new mysqli('localhost', 'root', '', 'sny');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $AccountId = $_POST['AccId']; // Define $AccountId here
            
            $sql = "UPDATE customer SET Password='$newpass' WHERE Id='$AccountId'";
            if ($conn->query($sql) === TRUE) {
                echo "Password updated successfully.";
                echo '<form action="index.php">';
                echo '<div class="loginn">';
                echo '<input type="submit" name="login" value="LOGIN">';
                echo '</div>';
                echo '</form>';
            } else {
                echo "Error updating password: " . $conn->error;
            }
            $conn->close();
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>
</body>
</html>
