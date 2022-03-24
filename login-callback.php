<?php
require_once 'connectDropBox.php';
include 'dbcon.php';
if (isset($_GET['code']) && isset($_GET['state'])) {    
    //Bad practice! No input sanitization!
    $code = $_GET['code'];
    $state = $_GET['state'];

    //Fetch the AccessToken
    $accessToken = $authHelper->getAccessToken($code, $state, $callbackUrl);

    $token= $accessToken->getToken();

    // print_r($accessToken);
    // print_r($token);
    $id=$_SESSION['id'];
    $query="UPDATE users SET token='$token' WHERE id=$id ";
    $result=mysqli_query($conn,$query);
   $_SESSION['token']=$token;
    header('Location: index.php');
}


?>