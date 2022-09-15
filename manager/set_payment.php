<?php
    session_start(); 
    $user_name = $_SESSION['uname'];
    $mid = $_SESSION['mid'];

    $report = "check";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        
        $home_rent = $_POST['home_rent'];
        $utilities = $_POST['utilities'];
        $net_bill = $_POST['net_bill'];
        $bazar = $_POST['bazar'];
        $bua = $_POST['bua'];
        $others = $_POST['others'];
        $date = $_POST['date'];

        $con = mysqli_connect("localhost","root","","demo");

        $sql = "insert into set_payment(`user_name`,`mess_id`,`home_rent`,`utilities`,`net_bill`,`bazar`,`bua`,`others`,`date`) values('$user_name','$mid','$home_rent','$utilities','$net_bill','$bazar','$bua','$others','$date')";

        $query = mysqli_query($con,$sql);
        if($query){
            $report = "yes";
        }
        else
            $report = "no";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/set_payment_style.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <div class="nav_top">
    Manager: <?php echo $_SESSION['fname'] ?>
        <a href="manager_index.php">deshboard</a>
        <a href="contact_manager.php">contact</a>
        <a href="set_payment.php">Set payment</a>
        <a href="view_meal.php">meal</a>
        <a href="view_bazar.php">bazar</a>
        <a href="member_info.php">member</a>
        <a href="logout.php">logout</a>
    </div>
    <div class="manager_info">
        <img src="../images/mess_logo.png" alt="img">
        <?php
            $con = mysqli_connect("localhost","root","","demo");
            $sql = "select * from manager where user_name = '$user_name' limit 1";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($query);
        ?>
            <table>
                <tr>
                    <caption>MANAGER Information</caption>
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
            <button><a href="member_registration.php">add member</a></button>
    </div>

    <div class="set_payment">
        <h1>set payment</h1>
        <?php
            if($report == 'yes')
                echo "Set your payment!";
            elseif($report == 'no')
                echo "Attemp doesn't succes. Try again!";
        ?>
        <form action="set_payment.php" method="POST">
            <table>
                <tr>
                    <td>
                        <label for="user_name">user_name: </label><br>
                        <input type="text" name="user_name">
                    </td>
                    <td>
                        <label for="home_rent">home rent: </label><br>
                        <input type="number" name="home_rent">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="utilities">utilities: </label><br>
                        <input type="number" name="utilities">
                    </td>
                    <td>
                        <label for="net_bill">net bill: </label><br>
                        <input type="number" name="net_bill">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="bazar">bazar: </label><br>
                        <input type="number" name="bazar">
                    </td>
                    <td>
                        <label for="bua">bua bill: </label><br>
                        <input type="number" name="bua">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="other">others: </label><br>
                        <input type="number" name="others">
                    </td>
                    <td>
                        <label for="other">dead line: </label><br>
                        <input type="date" name="date">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="submit" value="set payment">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>