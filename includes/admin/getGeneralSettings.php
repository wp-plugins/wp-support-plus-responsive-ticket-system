<?php 
$generalSettings=get_option( 'wpsp_general_settings' );
$pages=get_pages( array('post_type' => 'page','post_status' => 'publish') );
$posts=get_posts( array('post_type' => 'post','post_status' => 'publish') );
?>
<br>
<span class="label label-info" style="font-size: 14px;">Support Page/Post</span><br>
<select id="setSupportPage" style="margin-top: 14px;">
	<option value="0" <?php echo ($generalSettings['post_id']==0)?'selected="selected"':'';?>>Select Page/Post</option>
	<optgroup label="Page">
		<?php 
		foreach ($pages as $page){
			$selected=($generalSettings['post_id']==$page->ID)?'selected="selected"':'';
			echo '<option '.$selected.' value="'.$page->ID.'">'.$page->post_title.'</option>';
		}
		?>
	</optgroup>
	<optgroup label="Post">
		<?php 
		foreach ($posts as $post){
			$selected=($generalSettings['post_id']==$post->ID)?'selected="selected"':'';
			echo '<option '.$selected.' value="'.$post->ID.'">'.$post->post_title.'</option>';
		}
		?>
	</optgroup>
</select><br>
<small><code>*</code>Use shortcode <code>[wp_support_plus]</code> in selected page/post above.</small>
<hr>

<span class="label label-info" style="font-size: 14px;">Support Button</span><br><br>
<small><code>*</code>If enabled, button will be shown on all pages of front-end which redirect to support page/post selected above on click.</small><br>
<table>
  <tr>
    <td style="vertical-align: middle;"><input <?php echo ($generalSettings['enable_support_button']==1)?'checked="checked"':'';?> type="checkbox" id="setEnableSupportBtn" /></td>
    <td style="padding-left: 10px;padding-top:2px; vertical-align: middle;">Enable Support Button</td>
  </tr>
</table><br>
Button Position:<br>
<select id="setBtnPosition" style="margin-top: 14px;">
	<option value="top_left" <?php echo ($generalSettings['support_button_position']=='top_left')?'selected="selected"':'';?>>Top Left</option>
	<option value="top_right" <?php echo ($generalSettings['support_button_position']=='top_right')?'selected="selected"':'';?>>Top Right</option>
	<option value="bottom_left" <?php echo ($generalSettings['support_button_position']=='bottom_left')?'selected="selected"':'';?>>Bottom Left</option>
	<option value="bottom_right" <?php echo ($generalSettings['support_button_position']=='bottom_right')?'selected="selected"':'';?>>Bottom Right</option>
</select><br>
<hr>

<span class="label label-info" style="font-size: 14px;">Guest Ticket</span><br><br>
<small><code>*</code>If enabled, non logged-in user will able to raise ticket</small><br>
<table>
  <tr>
    <td style="vertical-align: middle;"><input <?php echo ($generalSettings['enable_guest_ticket']==1)?'checked="checked"':'';?> type="checkbox" id="setEnableGuestTicket" /></td>
    <td style="padding-left: 10px;padding-top:2px; vertical-align: middle;">Enable Guest Tickets</td>
  </tr>
</table><br>
<hr>

<button class="btn btn-success" id="setGeneralSubBtn" onclick="setGeneralSettings();">Save Settings</button>