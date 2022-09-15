<?php
    function depositFunction($mess_id){
        $bazar = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select bazar from payment where mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $bazar = $bazar + $row['bazar'];
        }

        return $bazar;
    }

    function costFunction($mess_id){
        $cost = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select price from bazar where mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $cost = $cost + $row['price'];
        }

        return $cost;
    }

    function mealFunction($mess_id){
        $meal = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select total_meal from meal where mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $meal = $meal + $row['total_meal'];
        }

        return $meal;
    }

    function MyCostFunction($user_name, $mess_id){
        $cost = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select price from bazar where user_name = '$user_name' and mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        $check = mysqli_num_rows($query);
        while($row = mysqli_fetch_assoc($query)){
            $cost = $cost + $row['price'];
        }

        if($check>0){
            return $cost;
        }
    }
    
    function MyMealFunction($user_name, $mess_id){
        $meal = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select total_meal from meal where user_name = '$user_name' and mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $meal = $meal + $row['total_meal'];
        }

        return $meal;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/member_index.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <?php session_start(); 
        $user_name = $_SESSION['uname'];
        $mess_id = $_SESSION['mid'];
    ?>

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
    <div class="payment_view">
        <h1>Your payment details: </h1>

        <?php
            $sql = "select home_rent, utilities, net_bill, bazar, bua, others, date from payment where user_name = '$user_name' limit 1";
            $query = mysqli_query($con, $sql);
            if($row = mysqli_fetch_assoc($query)){
        ?>
            <table>
                <tr>
                    <th>Home Rent: </th>
                    <th>Utilities: </th>
                    <th>Net bill: </th>
                    <th>Bazar: </th>
                    <th>Bua: </th>
                    <th>Last updated date: </th>
                    
                </tr>
                <tr>
                    <td> <?php echo $row['home_rent']?></td>
                    <td> <?php echo $row['utilities']?></td>
                    <td> <?php echo $row['net_bill']?></td>
                    <td> <?php echo $row['bazar']?></td>
                    <td> <?php echo $row['bua']?></td>
                    <td> <?php echo $row['date']?></td>
                </tr>
            </table>
        <?php 
            }
            else
                echo "Not payment yet.";
        ?>
    </div>
    <div class="mess_statement">
        <?php
            $bazar = depositFunction($mess_id);
            $cost = costFunction($mess_id);
            $balance = $bazar - $cost;
            $meal = mealFunction($mess_id);
            $meal_rate = $cost/$meal;
        ?>
        <table>
            <caption>Mess Statement</caption>
            <tr>
                <th>Total Deposit </th>
                <th>:</th>
                <td><?php echo $bazar."/-"; ?></td>
            </tr>
            <tr>
                <th>Cost </th>
                <th>:</th>
                <td><?php echo $cost."/-"; ?></td>
            </tr>
            <tr>
                <th>Balance </th>
                <th>:</th>
                <td><?php echo $balance."/-"; ?></td>
            </tr>
            <tr>
                <th>Total Meal</th>
                <th>:</th>
                <td><?php echo $meal."/-"; ?></td>
            </tr>
            <tr>
                <th>Meal Rate</th>
                <th>:</th>
                <td><?php echo round($meal_rate, 3)."/-"; ?></td>
            </tr>
        </table>
    </div>
    <div class="mess_statement">
        <?php
            $cost = MyCostFunction($user_name, $mess_id);
            $balance = $row['bazar'] - $cost;
            $meal = MyMealFunction($user_name, $mess_id);
            $my_bill = $meal_rate*$meal;
        ?>
        <table>
            <caption>My Statement</caption>
            <tr>
                <th>Total Deposit </th>
                <th>:</th>
                <td><?php echo $row['bazar']."/-"; ?></td>
            </tr>
            <tr>
                <th>Cost </th>
                <th>:</th>
                <td><?php echo $cost."/-"; ?></td>
            </tr>
            <tr>
                <th>Balance </th>
                <th>:</th>
                <td><?php echo $balance."/-"; ?></td>
            </tr>
            <tr>
                <th>Total Meal</th>
                <th>:</th>
                <td><?php echo $meal."/-"; ?></td>
            </tr>
            <tr>
                <th>Total bill</th>
                <th>:</th>
                <td><?php echo round($my_bill, 3)."/-"; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>