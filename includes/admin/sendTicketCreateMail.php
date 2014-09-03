<?php 
$emailSettings=get_option( 'wpsp_email_notification_settings' );

$subject='[Ticket #'.$ticket_id.'][open] '.$_POST['create_ticket_subject'];
$body=preg_replace("/(\r\n|\n|\r)/", '<br>', $_POST['create_ticket_body']);
$body.='<br><br>'.site_url();

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

if($emailSettings['admin_new_ticket']){
	wp_mail(get_bloginfo('admin_email'),$subject,$body,$headers);
}
?>
