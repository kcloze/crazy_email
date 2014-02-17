<?php
if(!defined('ACCESS')) {exit('Access denied.');}
require ROOT_BASE.'class/Base.class.php';

class Email extends Base {
    // 表名
	private static $table_name = 'email_sendlist';
	// 查询字段
	private static $columns = 'id,uid,email,email_title,email_content,error,will_send_time,send_time,status,priority';
    
    public static function getTableName(){
		return parent::$table_prefix.self::$table_name;
	}
	
    public static function start(){
    	$db=self::__instance();
    	//查询出没有被发送、当前时间大于预期发送时间，并按照优先级priority逆序
		$condition=array();
		$condition['AND']=array('status'=>1,'will_send_time[<]'=>time());
		$condition['ORDER']='priority desc';
		$condition['LIMIT']='80';
		$lists = $db->select ( self::getTableName(), self::$columns, $condition );
		if($lists){
			foreach ($lists as $key => $list) {
				//过滤机制
				if(self::filter()==false){
					break;
				}
				//活动用户名称
				$condition=array();
				$condition['AND']=array('uid'=>1);
				$condition['LIMIT']='1';
				$cu_list = $db->get ( parent::$table_prefix.'customer', 'name', $condition );
				//发送邮件
				$result=Email::sendEmail($list['email'],$cu_list['name'],$list['email_title'],$list['email_content']);
				if($result['error']==false){
                	$data['status']=2;
                	$data['send_time']=time();

				}else{
					$data['status']=2;
					$data['error']=1;
					$data['send_time']=time();
				}
				//跟新邮件列表状态
				$condition=array();
				$condition['AND']=array('id'=>$list['id']);
				$db->update (self::getTableName(),$data,$condition);
				//跟新当天已发送邮件个数
				self::updateSendNum();
			}

		}


    }
    
    public static function updateSendNum(){
    	$date=date('Y-m-d');
    	$db=self::__instance();
    	$condition=array();
		$condition['AND']=array('send_day'=>$date);
		$ex_list = $db->get ( parent::$table_prefix.'email_num', 'id', $condition );
		if($ex_list){
			$condition=array();
			$condition['AND']=array('send_day'=>$date);
			$data=array('num[+]'=>'1');
			$db->update (parent::$table_prefix.'email_num',$data,$condition);
		}else{
			$num_data['num']=1;
			$num_data['send_day']=$date;
			$db->insert ( parent::$table_prefix.'email_num', $num_data );		
		}

    }

    public static function filter(){
    	$date=date('Y-m-d');
    	$db=self::__instance();
    	$condition=array();
		$condition['AND']=array('send_day'=>$date);
		$ex_list = $db->get ( parent::$table_prefix.'email_num', 'id', $condition );
		if($ex_list['email_num']>OSA_MAX_SEND_EMAIL_NUMS){
			return fasle;
		}
		return true;

    }

    public static function addEmail($data){
    	if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
    	$id=$db->insert ( self::getTableName(), $data);
    	return $id;
    }

	public static function sendEmail($addAddress,$name,$subject,$contents){

		require_once ROOT_BASE.'lib/PHPMailer-master/PHPMailerAutoload.php';
		//Create a new PHPMailer instance
		$mail = new PHPMailer();
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		$mail->CharSet ="UTF-8";
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = OSA_MAIL_HOST;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = OSA_MAIL_PORT;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication
		$mail->Username = OSA_MAIL_USERNAME;
		//Password to use for SMTP authentication
		$mail->Password = OSA_MAIL_PASSWORD;
		//Set who the message is to be sent from
		$mail->setFrom(OSA_MAIL_SETFROM_EMAIL, OSA_MAIL_SETFROM_NAME);
		//Set an alternative reply-to address
		$mail->addReplyTo(OSA_MAIL_ADDREPLYTO_EMAIL, OSA_MAIL_ADDREPLYTO_NAME);
		//Set who the message is to be sent to
		if(strpos($addAddress, ';')!==false){
			foreach (explode(';', $addAddress) as $value) {
				if($value){
					$mail->addAddress($value, $name);
				}
			}
		}else{
			$mail->addAddress($addAddress, $name);
		}

		//Set the subject line
		$mail->Subject = $subject;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($contents);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.gif');

		//send the message, check for errors
		if (!$mail->send()) {
			return array('error'=>true,'message'=>$mail->ErrorInfo);
		} else {
			return array('error'=>false,'message'=>'success');
		}

	}
}
