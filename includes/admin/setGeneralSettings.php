<?php
$cu = wp_get_current_user();
if ($cu->has_cap('manage_options')) { 
	$generalSettings=array(
			'post_id'=>$_POST['post_id'],
			'enable_support_button'=>$_POST['enable_support_button'],
			'support_button_position'=>$_POST['support_button_position'],
			'enable_guest_ticket'=>$_POST['enable_guest_ticket']
	);
	update_option('wpsp_general_settings',$generalSettings);
}
?>