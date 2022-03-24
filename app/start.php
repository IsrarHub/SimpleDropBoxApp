<?php

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;


session_start();
$_SESSION['user_id']=1;

require __DIR__. '/../vendor/autoload.php';

$app_key='fkdkp8aelnd579m';
$secret_key='de40mo56imbwxp0';
$app_name="Israr123";
$app = new DropboxApp($app_key, $secret_key,$app_name);

 $dropbox = new Dropbox($app);

$authHelper = $dropbox->getAuthHelper();

$callbackUrl = 'http://localhost/VergeSystem/final.php';
