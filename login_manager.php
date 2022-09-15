<?php
session_start();

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    
    $con = mysqli_connect("localhost","root","","demo");
    $sql = "select * from manager where user_name ='".$uname."' AND password='".$password."' limit 1";
    
    $query = mysqli_query($con,$sql);
    
    $row = mysqli_fetch_assoc($query);
    
    $mid = $row["mess_id"];
    $uname = $row["user_name"];
    $fname = $row['full_name'];
    
    if(mysqli_num_rows($query)==1)
    {
        
        $_SESSION['mid'] = $mid;
        $_SESSION['uname'] = $uname;
        $_SESSION['fname'] = $fname;
        $_SESSION['password'] = $password;
        header("location:manager/manager_index.php");
    }
    else
    {
        $error = "** Your email or password is incorrect. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
    <link rel="stylesheet" href="css/style_login.css">
</head>
<body>
    <div class="left_card">
        <img src="images/mess_logo.png" alt="logo">
        <h1>mess management system</h1>
        <p>"Make mess life easy and beautiful by bypassing annoyance!"</p>
    </div>
    <div class="right_card">
        <form method="POST" action="login_manager.php">
            <fieldset>
                <legend>login as manager</legend><br>
                <label for="uname">user Name:</label><br>
                <input type="uname" name="uname" id="uname" placeholder="User Name..." required><br>

                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" placeholder="Password..." required><br>

                <input class="submit" type="submit" name="submit" value="Login">
                <span class="error"> <?php echo $error."<br>";?></span>

                <br><a href="index.php">Back to HOME</a>
            </fieldset><br>
        </form>
    </div>
    <div class="footer">
    <p>designed and developed by: <a href="https://www.facebook.com/sabbirhasan.anik.1" target="_blank">Sabbir Hasan</a></p>
    </div>
</body>
</html>