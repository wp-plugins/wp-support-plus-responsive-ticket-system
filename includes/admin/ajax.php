<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class SupportPlusAjax {
	function createNewTicket(){
		
		global $wpdb;
		
		//CODE FOR ATTACHMENT START
		$attachments=array();
		if(isset($_FILES['attachment']) && $_FILES['attachment']['name'][0]!=''){
			//echo count($_FILES['attachment']['name']);
			for($i=0;$i<count($_FILES['attachment']['name']);$i++){
				
				$daFile = $_FILES['attachment'];
				foreach ($_FILES['attachment'] as $key => $value) {
					$daFile[$key] = $value[$i];
				}
				$upload = wp_handle_upload($daFile , array('test_form' => FALSE));
				//var_dump( $upload);
				$attachments[]=array(
					'name'=>$_FILES['attachment']['name'][$i],
					'file_path'=>$upload['file'],
					'file_url'=>$upload['url'],
					'type'=>$upload['type']
				);
			}
		}
		$attachment_ids=array();
		foreach ($attachments as $attachment){
			$values=array(
				'filename'=>$attachment['name'],
				'filetype'=>$attachment['type'],
				'filepath'=>$attachment['file_path'],
				'fileurl'=>$attachment['file_url']
			);
			$wpdb->insert($wpdb->prefix.'wpsp_attachments',$values);
			$attachment_ids[]= $wpdb->insert_id;
		}
		$attachment_ids=implode(',', $attachment_ids);
		//CODE FOR ATTACHMENT END
		
		//create ticket
		$values=array(
				'subject'=>htmlspecialchars($_POST['create_ticket_subject'],ENT_QUOTES),
				'created_by'=>$_POST['user_id'],
				'guest_name'=>$_POST['guest_name'],
				'guest_email'=>$_POST['guest_email'],
				'type'=>$_POST['type'],
				'status'=>'open',
				'cat_id'=>$_POST['create_ticket_category'],
				'create_time'=>current_time('mysql', 1),
				'update_time'=>current_time('mysql', 1),
				'priority'=>$_POST['create_ticket_priority']
		);
		$wpdb->insert($wpdb->prefix.'wpsp_ticket',$values);
		$ticket_id=$wpdb->insert_id;
		
		//create thread
		$values=array(
				'ticket_id'=>$ticket_id,
				'body'=>htmlspecialchars($_POST['create_ticket_body'],ENT_QUOTES),
				'attachment_ids'=>$attachment_ids,
				'create_time'=>current_time('mysql', 1),
				'created_by'=>$_POST['user_id'],
				'guest_name'=>$_POST['guest_name'],
				'guest_email'=>$_POST['guest_email']
		);
		$wpdb->insert($wpdb->prefix.'wpsp_ticket_thread',$values);
		//check mail settings
		include_once( WCE_PLUGIN_DIR.'includes/admin/sendTicketCreateMail.php' );
		//end
		echo "1";die();
	}
	
	function replyTicket(){
	
		global $wpdb;
	
		//CODE FOR ATTACHMENT START
		$attachments=array();
		if(isset($_FILES['attachment']) && $_FILES['attachment']['name'][0]!=''){
			//echo count($_FILES['attachment']['name']);
			for($i=0;$i<count($_FILES['attachment']['name']);$i++){
	
				$daFile = $_FILES['attachment'];
				foreach ($_FILES['attachment'] as $key => $value) {
					$daFile[$key] = $value[$i];
				}
				$upload = wp_handle_upload($daFile , array('test_form' => FALSE));
				//var_dump( $upload);
				$attachments[]=array(
						'name'=>$_FILES['attachment']['name'][$i],
						'file_path'=>$upload['file'],
						'file_url'=>$upload['url'],
						'type'=>$upload['type']
				);
			}
		}
		$attachment_ids=array();
		foreach ($attachments as $attachment){
			$values=array(
					'filename'=>$attachment['name'],
					'filetype'=>$attachment['type'],
					'filepath'=>$attachment['file_path'],
					'fileurl'=>$attachment['file_url']
			);
			$wpdb->insert($wpdb->prefix.'wpsp_attachments',$values);
			$attachment_ids[]= $wpdb->insert_id;
		}
		$attachment_ids=implode(',', $attachment_ids);
		//CODE FOR ATTACHMENT END
	
		//create ticket
		$values=array(
				'status'=>$_POST['reply_ticket_status'],
				'cat_id'=>$_POST['reply_ticket_category'],
				'update_time'=>current_time('mysql', 1),
				'priority'=>$_POST['reply_ticket_priority']
		);
		$wpdb->update($wpdb->prefix.'wpsp_ticket',$values,array('id' => $_POST['ticket_id']));
	
		//create thread
		$values=array(
				'ticket_id'=>$_POST['ticket_id'],
				'body'=>htmlspecialchars($_POST['replyBody'],ENT_QUOTES),
				'attachment_ids'=>$attachment_ids,
				'create_time'=>current_time('mysql', 1),
				'created_by'=>$_POST['user_id']
		);
		$wpdb->insert($wpdb->prefix.'wpsp_ticket_thread',$values);
		
		//check mail settings
		include_once( WCE_PLUGIN_DIR.'includes/admin/sendTicketReplyMail.php' );
		//end
		echo "1";die();
	}
	
	function getTickets(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getTicketsByFilter.php' );
		die();
	}
	
	function getFrontEndTickets(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getFrontEndTicket.php' );
		die();
	}
	
	function openTicket(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getIndivisualTicket.php' );
		die();
	}
	
	function openTicketFront(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getIndivisualTicketFront.php' );
		die();
	}
	
	function getAgentSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getAgentSettings.php' );
		die();
	}
	
	function setAgentSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setAgentSettings.php' );
		die();
	}
	
	function getGeneralSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getGeneralSettings.php' );
		die();
	}
	
	function setGeneralSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setGeneralSettings.php' );
		die();
	}
	
	function getCategories(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getCategories.php' );
		die();
	}
	
	function createNewCategory(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/createNewCategory.php' );
		die();
	}
	
	function updateCategory(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/updateCategory.php' );
		die();
	}
	
	function deleteCategory(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/deleteCategory.php' );
		die();
	}
	
	function getEmailNotificationSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getEmailNotificationSettings.php' );
		die();
	}
	
	function setEmailSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setEmailSettings.php' );
		die();
	}
}
?>