<?php
require 'includes/dbh.inc.php';

$email = $_GET['e'];
$code = $_GET['c'];

  //Include required PHPMailer files
  require 'PHPMailer/PHPMailer.php';
  require 'PHPMailer/SMTP.php';
  require 'PHPMailer/Exception.php';
  //Define name spaces
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  //Create instance of PHPMailer
  $mail = new PHPMailer();
  //Set mailer to use smtp
  $mail->isSMTP();
  //Define smtp host
  $mail->Host = 'smtp.gmail.com';
  //Enable smtp authentication
  $mail->SMTPAuth = true;
  //Set smtp encryption type (ssl/tls)
  $mail->SMTPSecure = 'tls';
  //Port to connect smtp
  $mail->Port = '587';
  //Set gmail username
  $mail->Username = 'lolscout.recover.email@gmail.com';
  //Set gmail password
  $mail->Password = 'Golfinho_23';
  //Email subject
  $mail->Subject = 'Request password reset.';
  //Set sender email
  $mail->setFrom('lolscout.recover.email@gmail.com');
  //Enable HTML
  $mail->isHTML(true);
  //Attachment
  //	$mail->addAttachment('img/attachment.png');
  //Email body



  $mail->Body = "
  <div style='padding:40px; margin:auto; width: 400px; background-color:#333; color: #eee; border-radius: 4px; text-align: justify; '>
  <div style='margin:auto; width: 75%; padding:10px; border-radius: 4px;'>
  <center>
  <span style='color: #eee; font-size:40px;'>LOLSCOUT</span><span style='font-size:12px; color:red;'>beta</span>
  <br><br>
  <p>A request has been received to change the password for your LoLScout account.</p>
  <p>If you did not initiate this request, please ignore this message.</p>
  <br>
  <p style='font-size:30px;'>CODE<p>
  <p style='width:200px; padding: 20px; background-color: red; color:#eee; border-radius: 4px; margin:auto; font-size:20px; letter-spacing: 5px;'>".$code."</p>
  <br>

  <br>
  <p>Thank you, LoLScout.</v>
  </div>
  </div>
  ";

  //Add recipient
  $mail->addAddress($email);
  //Finally send email
  if ( $mail->send() ) {
    echo "Email sent successfully!";
  }else{
  	echo "Message could not be sent. Mailer Error: "{$mail->ErrorInfo};
  }
  //Closing smtp connection
  $mail->smtpClose();

  echo "<script>window.location.replace('confirm-code.php?e=$email');</script>";
