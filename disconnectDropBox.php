<?php 
include "dbcon.php";
session_start();
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/auth/token/revoke');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Authorization: Bearer '.$_SESSION['token'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$id=$_SESSION['id'];

$query="UPDATE users SET token=null WHERE id=$id";
$result=mysqli_query($conn,$query);
$_SESSION['token']='';
header('Location: index.php');

?>