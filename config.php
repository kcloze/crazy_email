<?php
//把带星号的配置项改成自己服务器相关配置
define('ACCESS',true);
define ( 'ROOT_BASE', dirname ( __FILE__).'/');

//数据库设置
define ( 'OSA_DB_ID' ,'crazy_sales');
define ( 'OSA_DB_URL','********');
define ( 'OSA_DB_PORT','3306');
define ( 'OSA_DB_NAME' ,'test');
define ( 'OSA_USER_NAME','********');
define ( 'OSA_PASSWORD','********');
define ( 'OSA_TABLE_PREFIX' ,'czs_');

//OSA_DB_ID 不同，可配置多数据库链接
$DATABASE_LIST[OSA_DB_ID] =array ("server"=>OSA_DB_URL,"port"=>OSA_DB_PORT,"username"=> OSA_USER_NAME, "password"=>OSA_PASSWORD, "db_name"=>OSA_DB_NAME );


//每天最大发送email数量
define ( 'OSA_MAX_SEND_EMAIL_NUMS' ,'100000');

//smtp邮件服务器相关配置，具体可参考Email.class.php->sendEmail()
define ( 'OSA_MAIL_HOST' ,'********');
define ( 'OSA_MAIL_PORT' ,25);
define ( 'OSA_MAIL_USERNAME' ,'********');
define ( 'OSA_MAIL_PASSWORD' ,'********');
define ( 'OSA_MAIL_SETFROM_EMAIL' ,'test@crazy.com');
define ( 'OSA_MAIL_SETFROM_NAME' ,'test.crazy');
define ( 'OSA_MAIL_ADDREPLYTO_EMAIL' ,'test@crazy.com');
define ( 'OSA_MAIL_ADDREPLYTO_NAME' ,'test.crazy');



