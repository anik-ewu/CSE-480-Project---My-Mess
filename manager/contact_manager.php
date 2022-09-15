<?php
session_start();

$user_name = $_SESSION['uname'];
$mid = $_SESSION['mid'];

if(isset($_GET['del'])){
    $id = $_GET['del'];
    
    $con = mysqli_connect("localhost","root","","demo");
    
    $sql = "update contact SET status='read' WHERE id='$id'";
    
    $query = mysqli_query($con,$sql);    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management System</title>
    <link rel="stylesheet" href="css/contact_manager_style.css">
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
    <section class="mail-area">
        <div class="view-mail">
            <h2>CHECK <span class="text-highlighter"> LATEST </span> MAIL</h2>
            <?php
                $con = mysqli_connect("localhost","root","","demo");
                $status = "Unread";
                $sql = "select * from contact where status = '$status' and mess_id = '$mid' order by id";
                $query =  mysqli_query($con, $sql);
                $result = mysqli_num_rows($query);
                if($result > 0)
                {
                    while($row = mysqli_fetch_assoc($query))
                    {
                        echo "<div class='mail-card'>";
                            echo "Date: ".$row['date']."<br>"."<br>";
                            echo "Name: ".$row['full_name']."<br>";
                            echo "Email: ".$row['email']."<br>"."<br>";
                            echo "Subject: ".$row['subject']."<br>"."<br>";
                            echo $row['message']."<br>"."<br>";
                        ?>
                            <a href="contact_manager.php?del=<?php echo $row['id'];?>">Mark as read</a>
                        <?php
                        echo "</div>";
                    }
                }
                else
                    echo "There is no unread mail";
            ?>
        </div>
    </section>    
</body>
</html>