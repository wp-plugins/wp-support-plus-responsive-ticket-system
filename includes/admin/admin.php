<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class WPSupportPlusAdmin {
	
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'loadScripts') );
		add_action( 'admin_menu', array($this,'custom_menu_page') );
		
	}
	
	function loadScripts(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_style('wpce_admin', WCE_PLUGIN_URL . 'asset/css/admin.css');
	}
	
	function custom_menu_page(){
		add_menu_page( 'WP Support Plus', 'Support Plus', 'manage_support_plus_ticket', 'wp-support-plus', array($this,'tickets'),WCE_PLUGIN_URL.'asset/images/support.png', '51.66' );
		add_submenu_page( 'wp-support-plus', 'WP Support Plus Settings', 'Settings', 'manage_options', 'wp-support-plus-settings', array($this,'settings') );
		add_submenu_page( 'wp-support-plus', 'WP Support Plus Support', 'Support', 'manage_options', 'wp-support-plus-support', array($this,'support') );
	}
	
	function tickets(){
		//Load Bootstrap
		wp_enqueue_script('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/js/bootstrap.min.js');
		wp_enqueue_style('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/css/bootstrap.min.css');
		wp_enqueue_script('wpce_display_ticket', WCE_PLUGIN_URL . 'asset/js/display_ticket.js');
		wp_enqueue_style('wpce_display_ticket', WCE_PLUGIN_URL . 'asset/css/display_ticket.css');
		
		$localize_script_data=array(
				'wpsp_ajax_url'=>admin_url( 'admin-ajax.php' ),
				'wpsp_site_url'=>site_url(),
				'plugin_url'=>WCE_PLUGIN_URL,
				'plugin_dir'=>WCE_PLUGIN_DIR
		);
		wp_localize_script( 'wpce_display_ticket', 'display_ticket_data', $localize_script_data );
		
		global $current_user;
		get_currentuserinfo();
		$this->getUpdateNotice();
		?>
		
		<div class="panel panel-primary" style="width: 99%; margin-top: 20px;">
		  <div class="panel-heading">
		    <h3 class="panel-title">WP Support Plus</h3>
		    <span style="float: right; margin-top: -19px;">Welcome, <?php echo $current_user->display_name;?></span>
		  </div>
		  <div class="panel-body">
		    <?php include_once( WCE_PLUGIN_DIR.'includes/admin/display_ticket.php' );?>
		  </div>
		</div>
		<?php 
	}
	
	function settings(){
		//Load Bootstrap
		wp_enqueue_script('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/js/bootstrap.min.js');
		wp_enqueue_style('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/css/bootstrap.min.css');
		wp_enqueue_script('wpce_admin_settings', WCE_PLUGIN_URL . 'asset/js/admin_settings.js');
		wp_enqueue_style('wpce_admin_settings', WCE_PLUGIN_URL . 'asset/css/admin_settings.css');
		
		$localize_script_data=array(
				'wpsp_ajax_url'=>admin_url( 'admin-ajax.php' ),
				'wpsp_site_url'=>site_url(),
				'plugin_url'=>WCE_PLUGIN_URL,
				'plugin_dir'=>WCE_PLUGIN_DIR
		);
		wp_localize_script( 'wpce_admin_settings', 'display_ticket_data', $localize_script_data );
		$this->getUpdateNotice();
		?>
		<div class="updated" style="margin-left:-1px;"><p><a href="http://pradeepmakone.com/wpsupportplus/">Click here</a> to see <b>Pro Features</b>.</p></div>
		<div class="panel panel-primary" style="width: 99%; margin-top: 20px;">
		  <div class="panel-heading">
		    <h3 class="panel-title">WP Support Plus Settings</h3>
		  </div>
		  <div class="panel-body">
		    <?php include_once( WCE_PLUGIN_DIR.'includes/admin/admin_settings.php' );?>
		  </div>
		</div>
		<?php 
	}
	
	function support(){
		?>
		<iframe src="http://pradeepmakone.com/wpsupportplus/support/" style="width: 90%;height: 550px;border: 4px solid #ffffff;"></iframe>
		<?php 
	}
	
	function getUpdateNotice(){
		global $current_user;
		get_currentuserinfo();
		$siteDataWPSP = file_get_contents('http://pradeepmakone.com/wp_support_plus_update_and_offers.txt');
		if($siteDataWPSP && $current_user->has_cap('manage_options')){
			$siteDataWPSP_obj=json_decode($siteDataWPSP);
			?>
				<div class="updated" style="margin-left:-1px;"><p><a href="http://pradeepmakone.com/wpsupportplus/">Click here</a> to see <b>Pro Features</b>.</p></div>
				<div class="updated" style="margin-left:-1px;">
					<p>
						<b>Today's offer:</b> Use Discount Code <b><?php echo $siteDataWPSP_obj->offer_code;?></b> to get <b><?php echo $siteDataWPSP_obj->offer_percent;?>%</b> Discount on Pro version.
					</p>
				</div>
			<?php 
			if(WPSP_VERSION < $siteDataWPSP_obj->latest_version){
				?>
				<div class="updated" style="margin-left:-1px;">
					<p>
						<?php echo __('New Version','wp-support-plus-responsive').' '.$siteDataWPSP_obj->latest_version.' '.__('available','wp-support-plus-responsive').' (Current Version: '.WPSP_VERSION.')';?>. 
						<a href="https://wordpress.org/plugins/wp-support-plus-responsive-ticket-system/changelog/" target="__blank"><?php _e('View Changelog','wp-support-plus-responsive');?></a>.
					</p>
				</div>
				<?php 
			}
		}
	}
}

$GLOBALS['WPSupportPlusAdmin'] =new WPSupportPlusAdmin();
?>
