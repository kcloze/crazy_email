<?php
set_time_limit(0); 
require 'config.php';
require ROOT_BASE.'class/Email.class.php';

Email::start();
echo 'done';


