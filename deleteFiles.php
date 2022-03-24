<?php
include "dbcon.php";
session_start();

$ch = curl_init();
$file=$_POST['name'];
curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/files/delete_v2');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"path\": \"/$file\"}");

$headers = array();
$headers[] = 'Authorization: Bearer '.$_SESSION['token'];
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$query="DELETE FROM files WHERE file_name='$file'";
$result=mysqli_query($conn,$query);
if($result){
  echo json_encode('delete');
}
else{
  echo json_encode('error');
}






?>