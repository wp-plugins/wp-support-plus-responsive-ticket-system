<?php 
$generalSettings=get_option( 'wpsp_general_settings' );
$support_permalink=get_permalink($generalSettings['post_id']);

$emailSettings=get_option( 'wpsp_email_notification_settings' );

$sql="select subject,status,created_by,guest_email
FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );

$subject='[Ticket #'.$_POST['ticket_id'].']['.$_POST['reply_ticket_status'].'] '.stripcslashes($ticket->subject);
$body=preg_replace("/(\r\n|\n|\r)/", '<br>', $_POST['replyBody']);
$body=stripcslashes($body);
$body.='<br><br><a href="'.$support_permalink.'">'.$support_permalink.'</a>';

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= 'From: '.$emailSettings['default_from_name'].' <'.$emailSettings['default_from_email'].'>' . "\r\n";

$emailToSend='';
if($ticket->created_by){
	$user=get_userdata( $ticket->created_by );
	$emailToSend=$user->user_email;
}
else {
	$emailToSend=$ticket->guest_email;
}
$to=array();
$to[]=$emailToSend;

if($emailSettings['admin_reply_ticket']){
	$to[]=get_bloginfo('admin_email');
}
wp_mail($to,$subject,$body,$headers);
?>
