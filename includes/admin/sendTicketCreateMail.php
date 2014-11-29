<?php 
$generalSettings=get_option( 'wpsp_general_settings' );
$support_permalink=get_permalink($generalSettings['post_id']);

$emailSettings=get_option( 'wpsp_email_notification_settings' );

$subject='[Ticket #'.$ticket_id.'][open] '.$_POST['create_ticket_subject'];
$body=preg_replace("/(\r\n|\n|\r)/", '<br>', $_POST['create_ticket_body']);
$body=stripcslashes($body);
$body.='<br><br><a href="'.$support_permalink.'">'.$support_permalink.'</a>';

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= 'From: '.$emailSettings['default_from_name'].' <'.$emailSettings['default_from_email'].'>' . "\r\n";

if($emailSettings['admin_new_ticket']){
	wp_mail(get_bloginfo('admin_email'),$subject,$body,$headers);
}
?>
