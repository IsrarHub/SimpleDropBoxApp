<?php
include "dbcon.php";
session_start();

    $foldername=$_POST['folder'];
   
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/files/create_folder_v2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"path\": \"/$foldername\",\"autorename\": false}");

    $headers = array();
    $headers[] = 'Authorization: Bearer '.$_SESSION['token'];
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $data=json_decode($result, true);
$folderid='';
$user_id=$_SESSION['id'];
$folName='';
$path_display='';
    foreach($data as $mt){
   $path_display=$mt['path_display'];
   $folName=$mt['name'];
   $folderid= $mt['id'];
   $folderTag=$mt['.tag'];
}
$query="INSERT INTO folders (user_id,folder_id,path_display,folder_name,folder_tag) Values ('$user_id','$folderid','$path_display','$folName',$folderTag)";
$res=mysqli_query($conn,$query);

if($res){
    $output=[
        'foldername'=>$_POST['folder']
    ];
    echo json_encode($output);
}
else{
    echo json_encode($result);
}
?>
  
