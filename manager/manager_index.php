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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/manager_index.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <?php session_start(); 
        $user_name = $_SESSION['uname'];
        $mess_id = $_SESSION['mid'];
        $password = $_SESSION['password'];
    ?>

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
                    <th>User Name: </th>
                    <td> <?php echo $row['phone']?></td>
                </tr>
            </table>

            <button><a href="edit_update.php">edit info</a></button>
            <button><a href="member_registration.php">add member</a></button>
    </div>
    <section>
    <div class="mess_statement">
        <?php
            $bazar = depositFunction($mess_id);
            $cost = costFunction($mess_id);
            $balance = $bazar - $cost;
            $meal = mealFunction($mess_id);
            $meal_rate = $cost/$meal;
        ?>
        <table class="mess-table">
            <caption id="mess-caption">Mess Statement</caption>
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
    </section>
</body>
</html>