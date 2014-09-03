<?php
$cu = wp_get_current_user();
if ($cu->has_cap('manage_options')) { 
	$emailSettings=array(
			'admin_new_ticket'=>$_POST['admin_new_ticket'],
			'admin_reply_ticket'=>$_POST['admin_reply_ticket']
	);
	update_option('wpsp_email_notification_settings',$emailSettings);
}
?>