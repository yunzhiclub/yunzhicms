<?php
namespace app\component\controller;

use think\Request;



class JoinController extends ComponentController
{
	public function indexAction()
	{
		
		
		$rootPath = dirname(__FILE__);
		
	
		
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // 开启完全调试模式

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.aliyun.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'myquilt@aliyun.com';                 // SMTP username
		$mail->Password = 'myquilt126';                           // SMTP password
		$mail->CharSet = 'UTF-8';
		//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		//$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('myquilt@aliyun.com', 'aliyun');
		$mail->addAddress('myquilt@sina.com', 'sina');     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo('myquilt@aliyun.com', 'aliyun');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Here is the subject';
		$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
    			echo 'Message could not be sent.';
    			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
    		echo 'Message has been sent';
				}

		return $this->fetch();
	}


}