<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;

//Roll & Capability
if(!get_role('wp_support_plus_agent')){
	add_role( 'wp_support_plus_agent', 'Support Agent' );
}
$role = get_role( 'wp_support_plus_agent' );
$role->add_cap( 'manage_support_plus_ticket' );
$role->add_cap( 'read' );
$role = get_role( 'administrator' );
$role->add_cap( 'manage_support_plus_ticket' );

//Database
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_ticket'") != $wpdb->prefix . 'wpsp_ticket'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_ticket (
	id integer not null auto_increment,
	subject TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	created_by integer,
	guest_name TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	guest_email TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	type TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	status TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	cat_id integer,
	create_time datetime,
	update_time datetime,
	priority TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	
	PRIMARY KEY (id)
	);");
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_ticket_thread'") != $wpdb->prefix . 'wpsp_ticket_thread'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_ticket_thread (
	id integer not null auto_increment,
	ticket_id integer,
	body LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	attachment_ids TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	create_time datetime,
	created_by integer,
	guest_name TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	guest_email TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	
	PRIMARY KEY (id)
	);");
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_attachments'") != $wpdb->prefix . 'wpsp_attachments'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_attachments (
	id integer not null auto_increment,
	filename TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	filetype TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	filepath TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	fileurl TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	
	PRIMARY KEY (id)
	);");
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_catagories'") != $wpdb->prefix . 'wpsp_catagories'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_catagories (
	id integer not null auto_increment,
	name TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,

	PRIMARY KEY (id)
	);");
	
	$wpdb->insert($wpdb->prefix.'wpsp_catagories',array('name'=>'General'));
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_agent_settings'") != $wpdb->prefix . 'wpsp_agent_settings'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_agent_settings (
	id integer not null auto_increment,
	agent_id integer NULL DEFAULT NULL,
	signature LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,

	PRIMARY KEY (id)
	);");
}

//default settings
if( get_option( 'wpsp_general_settings' ) === false ) {
	$generalSettings=array(
		'post_id'=>0,
		'enable_support_button'=>1,
		'support_button_position'=>'bottom_left',
		'enable_guest_ticket'=>0
	);
	update_option('wpsp_general_settings',$generalSettings);
}
if( get_option( 'wpsp_email_notification_settings' ) === false ) {
	$emailSettings=array(
			'admin_new_ticket'=>1,
			'admin_reply_ticket'=>1
	);
	update_option('wpsp_email_notification_settings',$emailSettings);
}
//default email change in 2.1
$emailSettings=get_option( 'wpsp_email_notification_settings' );
if(!isset($emailSettings['default_from_email'])){
	$from_name = "WordPress";
	$sitename = strtolower( $_SERVER['SERVER_NAME'] );
	if ( substr( $sitename, 0, 4 ) == 'www.' ) {
		$sitename = substr( $sitename, 4 );
	}
	$default_from_email = 'wordpress@' . $sitename;
	
	$emailSettings['default_from_email']=$default_from_email;
	$emailSettings['default_from_name']=$from_name;
	
	update_option('wpsp_email_notification_settings',$emailSettings);
}
?>
