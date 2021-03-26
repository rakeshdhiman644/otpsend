<?php
session_start();
$con=mysqli_connect('localhost','root','','users');
$email=$_POST['email'];
$res=mysqli_query($con,"select * from user where email='$email'");
$count=mysqli_num_rows($res);
if($count>0){
	$otp=rand(11111,99999);
	mysqli_query($con,"update user set otp='$otp' where email='$email'");
	$html="Your otp verification code is ".$otp;
	$_SESSION['EMAIL']=$email;
	smtp_mailer($email,'OTP Verification',$html);
	echo "yes";
}else{
	echo "not_exist";
}

function smtp_mailer($to,$subject, $msg){
	require_once("smtp/PHPMailerAutoload.php");
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Post=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="rakeshdhiman423@gmail.com";
	$mail->Password="krm9j8t7";
	$mail->SetFrom("rakeshdhiman423@gmail.com");
	//$mail->addAddress("rakeshdhiman423@gmail.com");
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	if(!$mail->Send()){
		return 0;
	}else{
		return 1;
	}
	// include('smtp/PHPMailerAutoload.php');
	// $mail=new PHPMailer(true);
	// $mail->isSMTP();
	// $mail->Host="smtp.gmail.com";
	// $mail->Post=587;
	// $mail->SMTPSecure="tls";
	// $mail->SMTPAuth=true;
	// $mail->Username="rakeshdhiman423@gmail.com";
	// $mail->Password="krm9j8t7";
	// $mail->SetFrom("rakeshdhiman423@gmail.com");
	// $mail->addAddress("rakeshdhiman423@gmail.com");
	// $mail->IsHTML(true);
	// $mail->Subject="otp verification";
	// $mail->Body=$html;
	// $mail->SMTPOptions=array('ssl'=>array(
	// 	'verify_peer'=>false,
	// 	'verify_peer_name'=>false,
	// 	'allow_self_signed'=>false
	// ));
}
?>