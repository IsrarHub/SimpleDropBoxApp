<?php 
include "dbcon.php";
session_start();

$oldfile=$_POST['oldname'];
$newName=$_POST['load'];
$id=$_POST['id'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/files/move_v2');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"from_path\": \"/$oldfile\",\"to_path\": \"/$newName\",\"allow_shared_folder\": false,\"autorename\": false,\"allow_ownership_transfer\": false}");

$headers = array();
$headers[] = 'Authorization: Bearer '.$_SESSION['token'];
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$data=json_decode($result,true);
$name='';
$pth_display='';

    foreach($data as $mt){
   $pth_display=$mt['path_display'];
   $name=$mt['name'];
}

$query="UPDATE folders SET folder_name='$name', path_display='$pth_display' WHERE folder_id='$id'";
$res=mysqli_query($conn,$query);
if($res){
  echo json_encode('1');
}
else{
  echo json_encode('2');
}



?>