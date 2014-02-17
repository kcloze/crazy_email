<?php
require 'config.php';
require ROOT_BASE.'class/Email.class.php';


/*增加测试数据*/
$data['uid']=1;
$data['email']='460309735@qq.com';
$data['email_title']='just for testing!';
$data['email_content']='just for testing!';
$data['error']=0;
$data['will_send_time']=1;
$data['send_time']=1;
$data['status']=1;
$data['priority']=1;



for ($i=0; $i < 10; $i++) {
	$resutl=Email::addEmail($data);
}

echo 'done';
