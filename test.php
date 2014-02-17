<?php
require 'config.php';
require ROOT_BASE.'class/Email.class.php';

$addAddress='460309735@qq.com';
$name='test';
$subject='just for testing!';
$contents='just for testing!';
var_dump(Email::sendEmail($addAddress,$name,$subject,$contents));
