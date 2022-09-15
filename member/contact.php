<?php
    session_start();
    $user_name = $_SESSION['uname'];

    $output = "";

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $mess_id = $_SESSION['mid'];
        $full_name = $_SESSION['fname'];
        $phone = $_SESSION['member_phone'];
        $email = $_SESSION['member_email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $date = date("y-m-d H:i:s");
        $status = "Unread";

        $con = mysqli_connect("localhost","root","","demo");
        $sql = "insert into contact (`user_name`,`mess_id`,`full_name`,`phone`,`email`,`message`,`date`,`subject`,`status`) values ('$user_name','$mess_id','$full_name','$phone','$email','$message','$date','$subject','$status')";

        $query=mysqli_query($con, $sql);
        if($query){
            $output = "** Message send.";
        }
        else{
            $output = "** Message not send. Try again.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/contact.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <div class="nav_top">
        Welcome <?php echo $_SESSION['fname'] ?>
        <a href="member_index.php">home</a>
        <a href="payment.php">payment</a>
        <a href="meal.php">meal</a>
        <a href="bazar.php">bazar</a>
        <a href="member_info.php">member</a>
        <a class="active" href="contact.php">Contact</a>
        <a href="logout.php">logout</a>
    </div>
    <div class="member_info">
        <img src="../images/mess_logo.png" alt="img">
        <?php
            $con = mysqli_connect("localhost","root","","demo");
            $sql = "select * from member where user_name = '$user_name' limit 1";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($query);
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
    <div class="contact_body">
        <h1>Contact to Manager</h1>
        <p>For any query or problem, please don't be shy to contact your manager.</p>
        <form action="contact.php" method="POST">
            <input type="text" name="subject" placeholder="Subject" required><br>
            <textarea name="message" cols="50" rows="10" placeholder="Write something..." required></textarea><br>
            <span class="error"><?php echo $output; ?></span><br>
            <input type="submit" value="Send">
        </form>
    </div>
</body>
</html>