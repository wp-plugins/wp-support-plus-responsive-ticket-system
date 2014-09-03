<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();

$values=array(
		'signature'=>htmlspecialchars($_POST['signature'],ENT_QUOTES)
);
$wpdb->update($wpdb->prefix.'wpsp_agent_settings',$values,array('id'=>$_POST['id']));
?>