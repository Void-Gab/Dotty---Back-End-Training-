<?php
require_once 'MyCustomSessionHandler.php';

$handler = new MyCustomSessionHandler();
session_set_save_handler($handler);

session_start();

$_SESSION = [];
$ses_params = session_get_cookie_params();
$options = array(
    'expires' => time()-60,
    'path'     => $ses_params['path'],
    'domain'   => $ses_params['domain'],
    'secure'   => $ses_params['secure'],
    'httponly' => $ses_params['httponly'],
    'samesite' => $ses_params['samesite']);

setcookie(session_name(), '', $options);


session_destroy();

header("Location: login.php");