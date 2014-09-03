<?php 
$emailSettings=get_option( 'wpsp_email_notification_settings' );
?>
<br>
<table>
  <tr>
    <td style="vertical-align: middle;"><input <?php echo ($emailSettings['admin_new_ticket']==1)?'checked="checked"':'';?> type="checkbox" id="email_admin_new_ticket" /></td>
    <td style="padding-left: 10px;padding-top:2px; vertical-align: middle;">New Ticket Created</td>
  </tr>
</table>
<small><code>*</code>This will send email notification to Administrator when new ticket has been created</small><br><br>
<table>
  <tr>
    <td style="vertical-align: middle;"><input <?php echo ($emailSettings['admin_reply_ticket']==1)?'checked="checked"':'';?> type="checkbox" id="email_admin_reply_ticket" /></td>
    <td style="padding-left: 10px;padding-top:2px; vertical-align: middle;">Ticket Reply</td>
  </tr>
</table>
<small><code>*</code>This will send email notification to all Agent when any ticket has been updated</small><br><br>

<button class="btn btn-success" onclick="setEmailSettings();">Save Settings</button>