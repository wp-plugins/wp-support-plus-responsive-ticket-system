<?php 
$emailSettings=get_option( 'wpsp_email_notification_settings' );

$subject='[Ticket #'.$ticket_id.'][open] '.$_POST['create_ticket_subject'];
$body=preg_replace("/(\r\n|\n|\r)/", '<br>', $_POST['create_ticket_body']);
$body.='<br><br><a href="'.site_url().'">'.site_url().'</a>';

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers .= 'From: '.$emailSettings['default_from_name'].' <'.$emailSettings['default_from_email'].'>' . "\r\n";

if($emailSettings['admin_new_ticket']){
	wp_mail(get_bloginfo('admin_email'),$subject,$body,$headers);
}
?>
