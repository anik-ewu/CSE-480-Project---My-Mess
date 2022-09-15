<?php
    function MessTotalMealCal($mess_id){
        $meal = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select total_meal from meal where mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $meal = $meal + $row['total_meal'];
        }

        return $meal;
    }

    function MessTotalCostCal($mess_id){
        $cost = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select price from bazar where mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $cost = $cost + $row['price'];
        }

        return $cost;
    }

    function deposit($user_name, $mess_id){
        $deposit = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select bazar from payment where user_name = '$user_name' and mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $deposit = $deposit + $row['bazar'];
        }

        return $deposit;
    }

    function cost($user_name, $mess_id){
        $cost = 0;
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select price from bazar where user_name = '$user_name' and mess_id = '$mess_id'";
        $query = mysqli_query($con, $sql);
        while($row = mysqli_fetch_assoc($query)){
            $cost = $cost + $row['price'];
        }

        return $cost;
    }

    function meal($user_name, $mess_id){
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
    <link rel="stylesheet" href="css/member_info_style.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <?php session_start(); 
        $user_name = $_SESSION['uname'];
        $mess_id = $_SESSION['mid'];
    ?>

    <div class="nav_top">
        Welcome <?php echo $_SESSION['fname'] ?>
        <a href="member_index.php">home</a>
        <a href="payment.php">payment</a>
        <a href="meal.php">meal</a>
        <a href="bazar.php">bazar</a>
        <a class="active" href="member_info.php">member</a>
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
    <div class="members_info">
        <?php
            $MessTotalMeal = MessTotalMealCal($mess_id);
            $MessTotalCost = MessTotalCostCal($mess_id);

            $TotalMealRate = $MessTotalCost/$MessTotalMeal;

            $con = mysqli_connect("localhost","root","","demo");
            $sql = "select user_name, full_name, email, phone from member where mess_id = '$mess_id'";
            $query = mysqli_query($con, $sql);
            $result = mysqli_num_rows($query);
            $count = 1;
            if($result>0){
        ?>
        <table>
            <caption>Member Information</caption>
            <tr>
                <th>Serial No</th>
                <th>Full Name</th>
                <th>Contact Info</th>
                <th>Economial Condition</th>
                <th>Final Bill</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($query)){
                    echo "<tr>";
                        echo "<td>".$count++."</td>";
                        echo "<td>".$row['full_name']."</td>";
                        echo "<td>".$row['email']."<br>".$row['phone']."</td>";
                        echo "<td>";
                            $user_name = $row['user_name'];
                            $total_deposit = deposit($user_name, $mess_id);
                            $total_cost = cost($user_name, $mess_id);
                            $total_meal = meal($user_name, $mess_id);
                            echo "Total Deposit: ".$total_deposit."/-"."<br>";
                            echo "Total Cost: ".$total_cost."/-"."<br>";
                            echo "Total Meal: ".$total_meal."/-"."<br>";
                        echo "</td>";
                        $bill = $TotalMealRate*$total_meal;
                        $final_bill = $total_deposit - $bill;

                        echo "<td>".round($final_bill, 3)."/-"."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <?php
            }
            else{
                echo "No member added yet.";
            }
        ?>
    </div>
    
</body>
</html>