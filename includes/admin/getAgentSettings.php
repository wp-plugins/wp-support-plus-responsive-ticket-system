<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();

$sql="select id,signature
FROM {$wpdb->prefix}wpsp_agent_settings WHERE  agent_id=".$current_user->ID;
$currentAgent = $wpdb->get_row( $sql );

if(!$wpdb->num_rows){
	$values=array(
			'agent_id'=>$current_user->ID,
			'signature'=>''
	);
	$wpdb->insert($wpdb->prefix.'wpsp_agent_settings',$values);
	
	$sql="select id,signature
	FROM {$wpdb->prefix}wpsp_agent_settings WHERE  agent_id=".$current_user->ID;
	$currentAgent = $wpdb->get_row( $sql );
}
?>
<br>
<span class="label label-info" style="font-size: 15px;">Signature</span><br>
<textarea id="agentSignature" style="width: 95%;overflow-y:hidden;margin-top: 10px;" onclick='this.rows = (this.value.split("\n").length||1);' onkeyup='this.rows = (this.value.split("\n").length||1);'><?php echo htmlspecialchars_decode($currentAgent->signature,ENT_QUOTES);?></textarea>
<button class="btn btn-success" style="margin-top: 10px;" onclick="setSignature(<?php echo $currentAgent->id;?>);">Save Settings</button>