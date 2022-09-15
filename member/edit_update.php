<?php
    session_start(); 
    $user_name = $_SESSION['uname'];
    $mess_id = $_SESSION['mid'];
    $password = $_SESSION['password'];

    $report = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $pass = $_POST['pre_password'];

        if($pass == $password)
        {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if($new_password == $confirm_password){
                $password = $_POST['confirm_password'];

                $con = mysqli_connect("localhost","root","","demo");
                $sql = "update member SET password=$password WHERE user_name = '$user_name' and mess_id = '$mess_id'";

                $query = mysqli_query($con, $sql);

                $report = "update successful";
                $_SESSION['password'] = $password;
            }
            else{
                $report = "new password and confirm password does not match";
            }
        }
        else{
            $report = "give a correct password";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/edit_update_style.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <div class="nav_top">
        Welcome <?php echo $_SESSION['fname'] ?>
        <a class="active" href="member_index.php">home</a>
        <a href="payment.php">payment</a>
        <a href="meal.php">meal</a>
        <a href="bazar.php">bazar</a>
        <a href="member_info.php">member</a>
        <a href="contact.php">Contact</a>
        <a href="logout.php">logout</a>
    </div>
    <div class="member_info">
        <img src="../images/mess_logo.png" alt="img">
        <?php
            $con = mysqli_connect("localhost","root","","demo");
            $sql = "select * from member where user_name = '$user_name' limit 1";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($query);

            $_SESSION['member_phone'] = $row['phone'];
            $_SESSION['member_email'] = $row['email'];
        ?>
            <table>
                <tr>
                    <caption>Your Information</caption>
                    <th>Name: </th>
                    <td> <?php echo $row['full_name']?></td>
                </tr>
                <tr>
                    <th>User Name: </th>
                    <td> <?php echo $row['user_name']?></td>
                </tr>
                <tr>
                    <th>Mess id: </th>
                    <td> <?php echo $_SESSION['mid']?></td>
                </tr>
                <tr>
                    <th>Email: </th>
                    <td> <?php echo $row['email']?></td>
                </tr>
                <tr>
                    <th>Phone: </th>
                    <td> <?php echo $row['phone']?></td>
                </tr>
            </table>

            <button><a href="edit_update.php">edit info</a></button>
    </div>
    <section class="change_password">
        <h2>Change Your <span class="highlighter">Password</span></h2>
        <form action="edit_update.php" method="POST">
            <input type="password" name="pre_password" placeholder="Present Password">
            <input type="password" name="new_password" placeholder="New Password">
            <input type="password" name="confirm_password" placeholder="Confirm Password">
            <input type="submit" value="Submit">
            <span class="report"><?php echo $report; ?></span>
        </form>

    </section>
</body>
</html>