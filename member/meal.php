<?php
    session_start(); 
    $user_name = $_SESSION['uname'];
    $mid = $_SESSION['mid'];

    function validity($data){

        $todays_date = date("y-m-d H:i:s");

        if($data < $todays_date)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function check($data, $name){ 

        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select * from meal where user_name = '$name' AND date = '$data' limit 1";
    
        $query = mysqli_query($con, $sql);
        $check = mysqli_num_rows($query);
        $row = mysqli_fetch_assoc($query);
    
        if($check>0)
            return $row['user_name'];
    }

    $report = "string";
    $result = "a";
    $error = $validityError = "";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {   
        $valid_date = validity($_POST['date']);
        
        if($valid_date == TRUE){
            $result = check($_POST['date'], $user_name);
        
            if($result == $user_name)
            {
                $error = "** You already request a meal for this date. For further change contact to the manager.";
            }
            else{
                $breakfast = $_POST['breakfast'];
                $lunch = $_POST['lunch'];
                $diner = $_POST['diner'];
                $date = $_POST['date'];

                $total_meal = $breakfast+$lunch+$diner;

                $con = mysqli_connect("localhost","root","","demo");

                $sql = "insert into meal (`user_name`,`mess_id`,`breakfast`,`lunch`,`diner`,`date`,`total_meal`) values('$user_name','$mid','$breakfast','$lunch','$diner','$date','$total_meal')";

                $query = mysqli_query($con,$sql);
                if($query){
                    $report = "yes";
                }
                else{
                    $report = "no";
                }
            }
        }
        else{
            $validityError = "Select a future date.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/meal_style.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <div class="nav_top">
        Welcome <?php echo $_SESSION['fname'] ?>
        <a href="member_index.php">home</a>
        <a href="payment.php">payment</a>
        <a class="active" href="meal.php">meal</a>
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
        <?php mysqli_close($con); ?>
            <button><a href="edit_update.php">edit info</a></button>
    </div>
    <div class="add_meal">
        <h1>add meal</h1>
        <?php
            echo $error;
            echo $validityError;
            if($report == "yes")
                echo "Meal added!";
            elseif($report == "no")
                echo "Attemp doesn't succes. Try again!";
        ?>
        <form action="meal.php" method="POST">
            <table>
                <tr>
                    <td>
                        <label for="breakfast">breakfast: </label><br>
                        <select name="breakfast" required>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </td>
                    <td>
                        <label for="lunch">Lunch: </label><br>
                        <select name="lunch" required>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </td>
                    <td>
                        <label for="diner">Dinner: </label><br>
                        <select name="diner" required>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </td>
                    <td>
                        <label for="date">date: </label><br>
                        <input type="date" name="date" required>
                    </td>
                    <td>
                        <input type="submit" value="Add">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="meal_view">
        <h1>meal information</h1>
        <?php
            $s_no = 0;
            $con = mysqli_connect("localhost","root","","demo");
            $sql = "select breakfast, lunch, diner, date, total_meal from meal where user_name = '$user_name' order by date";
            $query = mysqli_query($con, $sql);
            $result = mysqli_num_rows($query);
            if($result > 0){
        ?>
            <table class="view">
                <tr>
                    <th>Serial No: </th>
                    <th>Date: </th>
                    <th>Breakfast: </th>
                    <th>Lunch: </th>
                    <th>Dinner: </th>
                    <th>Total Meal: </th>
                    
                </tr>
                <?php
                    while($row = mysqli_fetch_assoc($query))
                    {
                        $s_no = $s_no + 1;
                        echo "<tr>";
                            echo "<td>".$s_no."</td>";
                            echo "<td>".$row['date']."</td>";
                            echo "<td>".$row['breakfast']."</td>";
                            echo "<td>".$row['lunch']."</td>";
                            echo "<td>".$row['diner']."</td>";
                            echo "<td>".$row['total_meal']."</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        <?php 
            }
            else
                echo "recorder meal is empty.";
        ?>
    </div>
</body>
</html>