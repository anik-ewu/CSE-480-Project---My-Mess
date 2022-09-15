<?php
    session_start(); 
    $user_name = $_SESSION['uname'];
    $mid = $_SESSION['mid'];

    function check($user_name){           //Check user name to avoid the duplicate payment.
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select user_name from payment where user_name = '$user_name'";
    
        $query = mysqli_query($con, $sql);
        $check = mysqli_num_rows($query);
        $row = mysqli_fetch_assoc($query);
        if($check > 0)
            return $row['user_name'];
    }

    $report = "0";
    $error = "";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $result = check($user_name);

        if($result == $user_name)
        {
            $error = "** You already clear your payment. If you need some update, please contact your manager.";
        }
        else{
            $home_rent = $_POST['home_rent'];
            $utilities = $_POST['utilities'];
            $net_bill = $_POST['net_bill'];
            $bazar = $_POST['bazar'];
            $bua = $_POST['bua'];
            $others = $_POST['others'];
            $date = date("y-m-d H:i:s");

            $con = mysqli_connect("localhost","root","","demo");

            $sql = "insert into payment(`user_name`,`mess_id`,`home_rent`,`utilities`,`net_bill`,`bazar`,`bua`,`others`,`date`) values('$user_name','$mid','$home_rent','$utilities','$net_bill','$bazar','$bua','$others','$date')";

            $query = mysqli_query($con,$sql);
            if($query){
                $report = 1;
            }
            else{
                $report = 2;
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
    <link rel="stylesheet" href="css/payment_style.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <div class="nav_top">
        Welcome <?php echo $_SESSION['fname'] ?>
        <a href="member_index.php">home</a>
        <a class="active" href="payment.php">payment</a>
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

    <div class="add_payment">
        <h1>add payment</h1>
        <?php
            echo $error;
            if($report == 1)
                echo "Payment Succesfully added!";
            elseif($report == 2)
                echo "Attemp doesn't succes. Try again!";
        ?>
        <form action="payment.php" method="POST">
            <table>
                <tr>
                    <td>
                        <label for="home_rent">home rent: </label><br>
                        <input type="number" name="home_rent">
                    </td>
                    <td>
                        <label for="utilities">utilities: </label><br>
                        <input type="number" name="utilities">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="net_bill">net bill: </label><br>
                        <input type="number" name="net_bill">
                    </td>
                    <td>
                        <label for="bazar">bazar: </label><br>
                        <input type="number" name="bazar">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="bua">bua bill: </label><br>
                        <input type="number" name="bua">
                    </td>
                    <td>
                        <label for="other">others: </label><br>
                        <input type="number" name="others">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="submit" value="add payment">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="payment_view">
        <h1>Your payment details: </h1>

        <?php
            $sql = "select home_rent, utilities, net_bill, bazar, bua, others, date from set_payment where user_name = '$user_name' limit 1";
            $query = mysqli_query($con, $sql);
            if($row = mysqli_fetch_assoc($query)){
        ?>
            <table class="view">
                <tr>
                    <th>Home Rent: </th>
                    <th>Utilities: </th>
                    <th>Net bill: </th>
                    <th>Bazar: </th>
                    <th>Bua: </th>
                    <th>Last date: </th>
                    
                </tr>
                <tr>
                    <td> <?php echo $row['home_rent']."/-"?></td>
                    <td> <?php echo $row['utilities']."/-"?></td>
                    <td> <?php echo $row['net_bill']."/-"?></td>
                    <td> <?php echo $row['bazar']."/-"?></td>
                    <td> <?php echo $row['bua']."/-"?></td>
                    <td> <?php echo $row['date']?></td>
                </tr>
            </table>
        <?php 
            }
            else
                echo "Not payment yet.";
        ?>
    </div>
</body>
</html>