<!DOCTYPE html>
<html lang="en">
<head>
    <title>show supplier</title>
</head>
<body>
    <?php
        include('dbconnection.php');
        include('sanitizer.php');
        if(!empty($_GET['msg'])){
            echo "<script>alert('".sanitizer($_GET['msg'])."');</script>";
        }
        $query = "select * from supplier";
        $result = mysqli_query($conn , $query);
        echo "<a href='home.php'>go back</a><hr>";
        echo 
        "<table border='1'>
        <tr>
            <th>supplier id</th>
            <th>supplier name</th>
            <th>supplier company</th>
            <th>supplier emailid</th>
            <th>supplier address</th>
            <th>supplier contact</th>
            <th></th>            
        </tr>";
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['suppliername']."</td>";
            echo "<td>".$row['suppliercompany']."</td>";
            echo "<td>".$row['supplieremail']."</td>";
            echo "<td>".$row['supplieraddress']."</td>";
            echo "<td>".$row['suppliercontact']."</td>";
            /*---edit button----*/
            echo "<td>
                    <form method = 'post' action='editsupplier.php?id=".$id."'>";
            echo "  <input type='submit' value='edit'>
                    </form></td>";
            /*---delete button----*/
            echo "<td>
                    <form method = 'post' action='core.php?type=delete&id=".$id."'>";
            echo "  <input type='submit' value='delete'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
?>
</body>
</html>
