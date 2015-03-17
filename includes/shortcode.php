<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class WPSupportPlusFrontEnd{
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'loadScripts') );
		add_shortcode( 'wp_support_plus', array( $this, 'support_plus_shortcode' ) );
	}
	
	function loadScripts(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_style('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/css/bootstrap.css');
		wp_enqueue_style('wpce_display_ticket', WCE_PLUGIN_URL . 'asset/css/display_ticket.css');
		wp_enqueue_style('wpce_public', WCE_PLUGIN_URL . 'asset/css/public.css');
	}
	
	function support_plus_shortcode(){
		wp_enqueue_script('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/js/bootstrap.min.js');
		wp_enqueue_script('wpce_public', WCE_PLUGIN_URL . 'asset/js/public.js');
		$isUserLogged=(is_user_logged_in())?1:0;

		$localize_script_data=array(
				'wpsp_ajax_url'=>admin_url( 'admin-ajax.php' ),
				'wpsp_site_url'=>site_url(),
				'plugin_url'=>WCE_PLUGIN_URL,
				'plugin_dir'=>WCE_PLUGIN_DIR,
				'user_logged_in'=>$isUserLogged
		);
		wp_localize_script( 'wpce_public', 'display_ticket_data', $localize_script_data );
		$generalSettings=get_option( 'wpsp_general_settings' );
		?>
		<?php
		ob_start();
		echo '<div class="support_bs">';
		if(is_user_logged_in()){
			include_once( WCE_PLUGIN_DIR.'includes/loggedInUser.php' );
		}
		else if($generalSettings['enable_guest_ticket']){
			include_once( WCE_PLUGIN_DIR.'includes/guestUser.php' );
		}
		echo '</div>';
		return ob_get_clean();
		?>
		<?php 
	}
}

$GLOBALS['WPSupportPlusFrontEnd'] =new WPSupportPlusFrontEnd();
?>
