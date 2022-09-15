<?php
    session_start();

    $user_name = $_SESSION['uname'];
    $mid = $_SESSION['mid'];

    if(isset($_GET['del'])){
        $meal_no = $_GET['del'];
        
        $con = mysqli_connect("localhost","root","","demo");
        
        $sql = "Delete from meal where meal_no = '$meal_no'";
        
        $query = mysqli_query($con,$sql);    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/view_meal_style.css">
    <link rel="icon" href="../images/mess_logo.png" type="image/icon">
</head>
<body>
    <div class="nav_top">
        Manager: <?php echo $_SESSION['fname'] ?>
        <a href="manager_index.php">deshboard</a>
        <a href="contact_manager.php">contact</a>
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
        <div class="view_part">
            <div class="header">
                <h1>Meal list</h1>
            </div>
            <div class="view_point">
                <?php
                    $con = mysqli_connect("localhost","root","","demo");
                    $sql = "select * from meal where mess_id = '$mid'";
                    $query = mysqli_query($con,$sql);
                    $count = 0;
                ?>
                <table id="tables">
                    <tr>
                        <th>Serial No.</th>
                        <th>Date</th>
                        <th>User Name</th>
                        <th>Breakfast</th>
                        <th>lunch</th>
                        <th>Dinner</th>
                        <th>Total Meal</th>
                        <th>Action</th>
                    </tr>
                <?php
                    while($row = mysqli_fetch_assoc($query))
                    {
                        $count = $count+1;
                        echo "<tr>";
                            echo "<td>".$count."</td>";
                            echo "<td>".$row['date']."</td>";
                            echo "<td>".$row['user_name']."</td>";
                            echo "<td>".$row['breakfast']."</td>";
                            echo "<td>".$row['lunch']."</td>";
                            echo "<td>".$row['diner']."</td>";
                            echo "<td>".$row['total_meal']."</td>";
                            ?>
                            <td><a href="view_meal.php?del=<?php echo $row["meal_no"];?>">Delete</a></td>
                            <?php
                        echo "</tr>";
                    }
                ?>
                </table>
            </div>
        </div>
    </section>
</body>
</html>