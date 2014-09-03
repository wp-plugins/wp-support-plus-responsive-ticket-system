<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class WPSupportPlusButton{
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'loadScripts') );
		add_action( 'wp_footer', array( $this, 'showButton') );
	}
	
	function loadScripts(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_style('wpce_support_button', WCE_PLUGIN_URL . 'asset/css/support_button.css');
	}
	
	function showButton(){
		$generalSettings=get_option( 'wpsp_general_settings' );
		if ($generalSettings['enable_support_button']){
			$support_permalink=get_permalink($generalSettings['post_id']);
			$imageURL='';
			$style="";
			switch ($generalSettings['support_button_position']){
				case 'top_left': $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-left.png';$style="top: 35px;left: 0px;";break;
				case 'top_right': $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-right.png';$style="top: 35px;right: 0px;";break;
				case 'bottom_left': $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-left.png';$style="bottom: 35px;left: 0px;";break;
				case 'bottom_right': $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-right.png';$style="bottom: 35px;right: 0px;";break;
			}
			?>
			<a href="<?php echo $support_permalink;?>">
				<img id="wpsp_support_btn" alt="support" src="<?php echo $imageURL;?>" style="<?php echo $style;?>" />
			</a>
			<?php 
		}
	}
}

$GLOBALS['WPSupportPlusButton'] =new WPSupportPlusButton();
?>