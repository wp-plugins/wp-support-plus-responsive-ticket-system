<?php 
global $wpdb;
$cu = wp_get_current_user();
if ($cu->has_cap('manage_options')) {
	$values=array('name'=>$_POST['cat_name']);
	$wpdb->update($wpdb->prefix.'wpsp_catagories',$values,array('id'=>$_POST['cat_id']));
}
?>