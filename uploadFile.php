<?php
include "dbcon.php";
session_start();
$fileName= basename($_FILES["load"]["name"]);

$cheaders = array('Authorization: Bearer '.$_SESSION['token'],
                  'Content-Type: application/octet-stream',
                  'Dropbox-API-Arg: {"path":"/'.$fileName.'", "mode":"add"}');

$ch = curl_init('https://content.dropboxapi.com/2/files/upload');
curl_setopt($ch, CURLOPT_HTTPHEADER, $cheaders);
curl_setopt($ch, CURLOPT_PUT, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

curl_close($ch);
$data=json_decode($response,true);
$name=$data['name'];
$display_path=$data['path_display'];
$file_id=$data['id'];
$id=$_SESSION['id'];
$query="INSERT INTO files (file_name,path_display,file_id,user_id) VALUES('$name','$display_path','$file_id','$id')";
$result=mysqli_query($conn,$query);
if($result){
  $output=[
    'filename'=>$fileName
  ];
  echo json_encode($output);
}
else{
  echo json_encode('2');
}



?>