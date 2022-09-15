<?php

function check($mid){           //Check mess id to avoid the duplicate mess id.
    $con = mysqli_connect("localhost","root","","demo");
    $sql = "select mess_id from mess where mess_id = '$mid'";

    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($query);

    return $row['mess_id'];
}

// define variables and set to empty values.
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $result = check($_POST['mid']);
    if($result == $_POST['mid'])
    {
        $error = "** Already have this id. Please make a another id($result)";
    }
    else
    {
        $name = $_POST['name'];
        $mid = $_POST['mid'];

        session_start();
        $_SESSION['mid'] = $mid;
    
        $con = mysqli_connect("localhost","root","","demo");
    
        $sql = "insert into mess(`mess_name`,`mess_id`) values('$name','$mid')";
    
        $query = mysqli_query($con,$sql);

        if($query)
        {
            header("location:registration.php");
        }
        else
        {
            echo "not craeted";
            die(mysqli_connect_error());
        }
    
    mysqli_close($con);
    }

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/mess_logo.png" type="image/icon">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/style_index.css">
</head>
<body>
    <div class="left_card">
        <img src="images/mess_logo.png" alt="logo">
        <h1>mess management system</h1>
        <p>"Make mess life easy and beautiful by bypassing annoyance!"</p>
    </div>
    <div class="right_card_cm">
        <form method="POST" action="createmess.php">
            <fieldset>
                <legend>Create your mess</legend><br>
                <label for="name">Mess Name:</label><br>
                <input type="text" name="name" id="name" placeholder="Name..." required><br> <!-- name => mess name-->
                <label for="mid">Mess ID:</label><br>
                <input type="text" name="mid" id="mid" placeholder="Mess ID..." required><br> <!-- mid => mess id-->
                <span class="error"> <?php echo $error;?></span>

                <input class="submit" type="submit" name="submit" value="create">

                <br><a href="index.php">Back to HOME</a>
            </fieldset><br>
        </form>
    </div>
    <div class="footer">
        <p>designed and developed by: <a href="https://www.facebook.com/sabbirhasan.anik.1" target="_blank">Sabbir Hasan</a></p>
    </div>
</body>
</html>