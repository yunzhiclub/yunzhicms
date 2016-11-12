<?php
namespace app\component\controller;

use think\Request;
Vendor('PHPMailer1.PHPMailerAutoload');
Vendor('PHPMailer1.PHPMailer');
Vendor('PHPMailer1.PHPMailerOAuth');
Vendor('PHPMailer1.PHPMailerOAuthGoogle');
Vendor('PHPMailer1.POP3');
Vendor('PHPMailer1.SMTP');


class JoinController extends ComponentController
{
	public function indexAction()
	{
		return $this->fetch();
	}

	/**
	 * 用于发送邮件（对于想加入团队的同学）
	 * 应用了php中的smtp
	 * @param  
	 * @return 
	 * @author liuyanzhao
	 */
	public function sendAction()
	{
		//引进phpmailer并实例化
		//对于没有命名空间的class，引用时用 '\' 如下例
		Vendor('PHPMailer1.PHPMailer');
        $mail = new \PHPMailer();

        //$mail->SMTPDebug = 3;                  // 开启完全调试模式（勿修改）

		$mail->isSMTP();                         //设置使用smtp
		$mail->Host = 'smtp.aliyun.com';         //使用的smtp服务器
		$mail->SMTPAuth = true;                  // 开启smtp auth服务
		$mail->Username = 'myquilt@aliyun.com';  //发送方邮箱
		$mail->Password = 'myquilt126';          //发送方密码
		$mail->CharSet = 'UTF-8';
		//$mail->SMTPSecure = 'tls';             // tls
		//$mail->Port = 587;                     // TCP端口号码

		$mail->setFrom('myquilt@aliyun.com', 'aliyun'); //发送方
		$mail->addAddress('myquilt@sina.com', 'sina');  //接收方，第二项参数可选
		$mail->addReplyTo('myquilt@aliyun.com', 'aliyun'); //依赖方

		$mail->isHTML(true);                   //允许html内容

		//下面把从V层得到的数据发送
		$mail->Subject = input('post.email');	//主题
		$mail->Body    = input('post.apliciation');	//正文
		if(!$mail->send()) {
    			return $this->success('发送成功', url('@/'));
		} else {
    		return $this->error('发送失败', url('@/'));
				}
	}
}