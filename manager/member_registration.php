<?php
session_start();

function checkUserName($uname){     //Check user name to avoid the duplicate user name.
    $con = mysqli_connect("localhost","root","","demo");
    $sql = "select user_name from member where user_name = '$uname'";

    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($query);

    return $row['user_name'];
}

function checkemail($mail){
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

// define variables and set to empty values
$errorUname = $errorEmail = $report = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $u_name = checkUserName($_POST['uname']);
    $email = checkemail($_POST['email']);

    if($u_name == $_POST['uname'])
    {
        $errorUname = "** Already have this user name. Please make a another user name.";
    }
    else
    {
        if($email == true)
        {
            $username = $_POST['uname'];
            $fullname = ucwords($_POST['name']);
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $mid = $_SESSION['mid'];

            $_SESSION["Uname"] = $username;
            
            $con = mysqli_connect("localhost","root","","demo");
    
            $sql = "insert into member(`user_name`,`full_name`,`email`,`password`,`phone`,`mess_id`) values('$username','$fullname','$email','$password','$phone','$mid')";
    
            $query = mysqli_query($con,$sql);

            if($query)
            {
                $report = "Member Added";
                header("location:member_registration.php");
            }
            else
            {
                echo "Unsuccessfull";
                die(mysqli_connect_error());
            }
    
            mysqli_close($con);
        }
        else
        {
            $errorEmail = "** Please give a valid Email";
        }
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
    <link rel="stylesheet" href="css/member_registration_style.css">
</head>
<body>
    <div class="left_card">
        <img src="../images/mess_logo.png" alt="logo">
        <h1>mess management system</h1>
        <p>"Make mess life easy and beautiful by bypassing annoyance!"</p>
    </div>
    <div class="right_card">
        <form method="POST" action="member_registration.php" class="form_style">
            <fieldset>
                <legend>member reg.</legend><br>
                <span><?php echo $report; ?></span>
                <label for="uname">user Name:</label><br>  <!-- uname = user_name -->
                <input type="uname" name="uname" id="uname" placeholder="User Name..." required><br>
                <span class="error"> <?php echo $errorUname."<br>";?></span>

                <label for="name">Name:</label><br>
                <input type="name" name="name" id="name" placeholder="Name..." required><br> <!-- name = full_name -->

                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" placeholder="Email..." required><br>
                <span class="error"> <?php echo $errorEmail."<br>";?></span>

                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" placeholder="Password..." required><br>

                <label for="phone">Phone:</label><br>
                <input type="phone" name="phone" id="phone" placeholder="Phone..." required><br>

                <input class="submit" type="submit" name="submit" value="Registration">

                <br><a href="manager_index.php">Back to HOME</a>
            </fieldset><br>
        </form>
    </div>
</body>
</html>