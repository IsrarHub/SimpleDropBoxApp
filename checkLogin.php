<?php 
session_start(); 

include "dbcon.php";

if (isset($_POST['login'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email= validate($_POST['email']);
    $password= validate($_POST['password']);
    if(empty($email)){
      $_SESSION['error']="Email is required";
      header("Location: login.php");
    }
    else if(empty($password)){
      
      $_SESSION['error']="Password is required";
      header("Location: login.php");
    }
    else{
     $query="SELECT * FROM users WHERE email='$email' AND password='$password'";
     $reusult=mysqli_query($conn,$query);
     if(mysqli_num_rows($reusult)!=1){
       
      $_SESSION['error']='You are not allowed';
      header('Location: login.php');
       
     }
     else{
      $row=mysqli_fetch_assoc($reusult);
       
      $_SESSION['id']=$row['id'];
      $_SESSION['name']=$row['name'];
      $_SESSION['email']=$row['email'];
      $_SESSION['token']=$row['token'];
      header('Location: index.php');
     }

    }
}