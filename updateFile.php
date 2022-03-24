<?php 
include 'dbcon.php';
session_start();
$id=$_POST['id'];
$old=explode(':',$id);
$oldname=$_POST['oldname'];
$new_id=$old[1];
$file=$_POST['load'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/file_requests/update');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"id\": \"$new_id\",\"title\": \"$file\",\"destination\": \"/$oldname\",\"deadline\": {\".tag\": \"file\"},\"open\": true}");

$headers = array();
$headers[] = 'Authorization: Bearer '.$_SESSION['token'];
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$query="UPDATE files SET file_name='$file' WHERE file_id='$id'";
$res=mysqli_query($conn,$query);
if($res){
  echo json_encode($result);
}
else{
  echo json_encode($new_id);
}
?>