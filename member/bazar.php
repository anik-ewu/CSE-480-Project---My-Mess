<?php
    session_start(); 
    $user_name = $_SESSION['uname'];
    $mid = $_SESSION['mid'];

    function validity($data){
        $todays_date = date("yy-m-d H:i:s");

        if($data <= $todays_date){
            $date = 0;
            $todays_date = 0;
            return TRUE;
        }
        else{
            $date = 0;
            $todays_date = 0;
            return FALSE;
        }
    }

    function cost_calculation($user_name){
        $con = mysqli_connect("localhost","root","","demo");
        $sql = "select price from bazar where user_name = '$user_name' order by date";
        $query = mysqli_query($con, $sql);
        $result = mysqli_num_rows($query);

        $total_cost = 0;

        if($result>0){
            while($row = mysqli_fetch_assoc($query)){
                $total_cost = $total_cost+$row['price'];
            }
        }

        return $total_cost;
    }

    $report = "string";
    $result = "a";
    $validityError = "";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        
        $valid_date = validity($_POST['date']);

        if($valid_date == TRUE){
            $product_name = $_POST['product_name'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $date = $_POST['date'];

            $con = mysqli_connect("localhost","root","","demo");

            $sql = "insert into bazar (`user_name`,`mess_id`,`product_name`,`quantity`,`price`,`date`) values('$user_name','$mid','$product_name','$quantity','$price','$date')";

            $query = mysqli_query($con,$sql);
            if($query){
                $report = "yes";
            }
            else{
                $report = "no";
            }
        }
        elseif($valid_date == FALSE){
            $validityError = "Future date not acceptable.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/bazar_style.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <div class="nav_top">
        Welcome <?php echo $_SESSION['fname'] ?>
        <a href="member_index.php">home</a>
        <a href="payment.php">payment</a>
        <a href="meal.php">meal</a>
        <a class="active" href="bazar.php">bazar</a>
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
    <div class="add_bazar">
        <h1>add bazar</h1>
        <?php
            echo $validityError;
            if($report == "yes")
                echo "Bazar added!";
            elseif($report == "no")
                echo "Attemp doesn't succes. Try again!";
        ?>
        <form action="bazar.php" method="POST">
            <table>
                <tr>
                    <td>
                        <label for="breakfast">product name: </label><br>
                        <input type="text" name="product_name" placeholder="product name..." required>
                    </td>
                    <td>
                        <label for="lunch">quantity: </label><br>
                        <input type="quantity" name="quantity" placeholder="quantity..." required>
                    </td>
                    <td>
                        <label for="diner">price: </label><br>
                        <input type="price" name="price" placeholder="price..." required>
                    </td>
                    <td>
                        <label for="date">date: </label><br>
                        <input type="date" name="date" placeholder="date..." required>
                    </td>
                    <td>
                        <input type="submit" value="Add">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="bazar_view">
        <h1>bazar list</h1>
        <?php
            $s_no = 0;
            $con = mysqli_connect("localhost","root","","demo");
            $sql = "select product_name, quantity, price, date from bazar where user_name = '$user_name' order by date";
            $query = mysqli_query($con, $sql);
            $result = mysqli_num_rows($query);

            $total_cost = 0;
            $total_cost = cost_calculation($user_name);

            if($result > 0){
        ?>
            <p>Your Total Cost: <?php echo $total_cost." Taka"; ?></p>
            <table>
                <tr>
                    <th>Serial No: </th>
                    <th>Product Name: </th>
                    <th>Quantity: </th>
                    <th>Price: </th>
                    <th>Date: </th>
                </tr>
                <?php
                    while($row = mysqli_fetch_assoc($query))
                    {
                        $s_no = $s_no + 1;
                        
                        echo "<tr>";
                            echo "<td>".$s_no."</td>";
                            echo "<td>".$row['product_name']."</td>";
                            echo "<td>".$row['quantity']." kg"."</td>";
                            echo "<td>".$row['price']." /-"."</td>";
                            echo "<td>".$row['date']."</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        <?php 
            }
            else
                echo "Not payment yet.";
        ?>
    </div>
</body>
</html>