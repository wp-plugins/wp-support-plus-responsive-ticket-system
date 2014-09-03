<?php 
$emailSettings=get_option( 'wpsp_email_notification_settings' );

$sql="select subject,status,created_by,guest_email
FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );

$subject='[Ticket #'.$_POST['ticket_id'].']['.$_POST['reply_ticket_status'].'] '.stripcslashes($ticket->subject);
$body=preg_replace("/(\r\n|\n|\r)/", '<br>', $_POST['replyBody']);
$body.='<br><br>'.site_url();

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$emailToSend='';
if($ticket->created_by){
	$user=get_userdata( $ticket->created_by );
	$emailToSend=$user->user_email;
}
else {
	$emailToSend=$ticket->guest_email;
}

wp_mail($emailToSend,$subject,$body,$headers);

if($emailSettings['admin_reply_ticket']){
	wp_mail(get_bloginfo('admin_email'),$subject,$body,$headers);
}
?>
