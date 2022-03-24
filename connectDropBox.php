<?php
session_start();

require_once 'vendor/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

$app_key='fkdkp8aelnd579m';
$secret_key='de40mo56imbwxp0';

//Configure Dropbox Application
$app = new DropboxApp($app_key, $secret_key);

//Configure Dropbox service
$dropbox = new Dropbox($app);

//DropboxAuthHelper
$authHelper = $dropbox->getAuthHelper();

//Callback URL
$callbackUrl = 'http://localhost/vergeSystem/login-callback.php';

?>