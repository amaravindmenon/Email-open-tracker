<?php
include('db.php');
include('smtp/PHPMailerAutoload.php');

$res=mysqli_query($con,"select * from email_list where send='0'");
if(mysqli_num_rows($res)>0){
	$row=mysqli_fetch_assoc($res);
	$email=$row['email'];
	$id=$row['id'];
	$html="Hi Hello. <img src='TRACKINGURL/track.php?id=$id' width='1px' height='1px'/>";
	smtp_mailer($email,'Test', $html);
	mysqli_query($con,"update email_list set send=1 where id='$id'");
}





function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "EMAIL";
	$mail->Password = 'PASSWORD';
	$mail->SetFrom("EMAIL");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		echo 'Sent';
	}
}
?>