<?php
include "dbcon.php";

$name=$_POST['name'];
$query="SELECT * from folders WHERE folder_name='$name'";
$result=mysqli_query($conn,$query);
echo json_encode(mysqli_fetch_assoc($result));


