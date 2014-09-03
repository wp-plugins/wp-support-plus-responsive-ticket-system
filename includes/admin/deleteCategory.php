<?php 
global $wpdb;
$cu = wp_get_current_user();
if ($cu->has_cap('manage_options')) {
	$values=array(
		'cat_id'=>1
	);
	$wpdb->update($wpdb->prefix.'wpsp_ticket',$values,array('cat_id'=>$_POST['cat_id']));
	
	$wpdb->delete($wpdb->prefix.'wpsp_catagories',array('id'=>$_POST['cat_id']));
}
?>