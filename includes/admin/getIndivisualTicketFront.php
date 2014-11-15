<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();

if(!is_numeric($_POST['ticket_id'])) die(); //sql injection

$sql="select subject,type,status,cat_id,priority,created_by,guest_name
		FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );

$sql="select id,body,attachment_ids,created_by,guest_name,guest_email,
		TIMESTAMPDIFF(MONTH,create_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,create_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,create_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,create_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,create_time,UTC_TIMESTAMP()) as date_modified_sec
		FROM {$wpdb->prefix}wpsp_ticket_thread WHERE ticket_id=".$_POST['ticket_id'].' ORDER BY create_time DESC' ;
$threads= $wpdb->get_results( $sql );
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>
<button class="btn btn-primary" style="margin-top: 10px;" onclick="backToTicketFromIndisual();">« Back To Tickets</button><br>
<h3>[Ticket #<?php echo $_POST['ticket_id'];?>] <?php echo stripcslashes($ticket->subject);?></h3>

<form id="frmThreadReply" onsubmit="replyTicket(event,this);">
	<input type="hidden" name="action" value="replyTicket">
	<input type="hidden" name="ticket_id" value="<?php echo $_POST['ticket_id'];?>">
	<input type="hidden" name="user_id" value="<?php echo $current_user->ID;?>">
	<input type="hidden" name="type" value="user">
	<input type="hidden" name="guest_name" value="">
	<input type="hidden" name="guest_email" value="">
	<div id="theadReplyContainer" style="width: 95%;">
		<textarea id="replyBody" name="replyBody" style="width: 95%;overflow-y:hidden;" onkeyup='this.rows = (this.value.split("\n").length||1);'></textarea>
		<table style="width: 95%" id="frontEndReplyTbl">
			<tr>
				<td>Status:</td>
				<td>
					<select id="reply_ticket_status" name="reply_ticket_status" style="margin-top: 10px;">
						<option value="open" <?php echo ($ticket->status=='open')?'selected="selected"':'';?>>Open</option>
						<?php if($ticket->type!='guest'){?>
						<option value="pending" <?php echo ($ticket->status=='pending')?'selected="selected"':'';?>>Pending</option>
						<?php }?>
						<option value="closed" <?php echo ($ticket->status=='closed')?'selected="selected"':'';?>>Closed</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Category:</td>
				<td>
					<select id="reply_ticket_category" name="reply_ticket_category" style="margin-top: 10px;">
					<?php 
						foreach ($categories as $category){
							$selected=($category->id==$ticket->cat_id)?'selected="selected"':'';
							echo '<option value="'.$category->id.'" '.$selected.'>'.$category->name.'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Priority:</td>
				<td>
					<select id="reply_ticket_priority" name="reply_ticket_priority" style="margin-top: 10px;">
						<option value="normal" <?php echo ($ticket->priority=='normal')?'selected="selected"':'';?>>Normal</option>
						<option value="high" <?php echo ($ticket->priority=='high')?'selected="selected"':'';?>>High</option>
						<option value="medium" <?php echo ($ticket->priority=='medium')?'selected="selected"':'';?>>Medium</option>
						<option value="low" <?php echo ($ticket->priority=='low')?'selected="selected"':'';?>>Low</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Attach File(s):</td>
				<td>
					<input type="file" id="attachFileType" name="attachment[]" multiple>
				</td>
			</tr>
		</table>
		<input type="button" class="btn btn-success" value="Reset" onClick="this.form.reset()" />
		<input type="submit" class="btn btn-success" value="Submit Reply">&nbsp;
	</div>
</form>

<?php foreach ($threads as $thread){?>
<div class="threadContainer" style="width: 95%;">
		<?php 
			$user_name='';
			$user_email='';
			$signature='';
			if($ticket->type=='user'){
				$user=get_userdata( $thread->created_by );
				$user_name=$user->display_name;
				$user_email=$user->user_email;
				
				$userSignature = $wpdb->get_row( "select signature FROM {$wpdb->prefix}wpsp_agent_settings WHERE agent_id=".$thread->created_by );
				if($wpdb->num_rows){
					$signature='<br><br>---<br>'.stripcslashes($userSignature->signature);
					$signature=preg_replace("/(\r\n|\n|\r)/", '<br>', $signature);
				}
			}
			else{
				$user_name=$thread->guest_name;
				$user_email=$thread->guest_email;
			}
			$modified='';
			if ($thread->date_modified_month) $modified=$thread->date_modified_month.' months ago';
			else if ($thread->date_modified_day) $modified=$thread->date_modified_day.' days ago';
			else if ($thread->date_modified_hour) $modified=$thread->date_modified_hour.' hours ago';
			else if ($thread->date_modified_min) $modified=$thread->date_modified_min.' minutes ago';
			else $modified=$thread->date_modified_sec.' seconds ago';
			
			$attachments=array();
			if($thread->attachment_ids){
				$attachments=explode(',', $thread->attachment_ids);
			}
			
			$body=stripcslashes($thread->body);
			$body = preg_replace("/(\r\n|\n|\r)/", '<br>', $body);
			$body.=$signature;
			?>
			<table class="replyUserInfo" style="width: 95%;margin-top: -9px;">
				<tr>
					<td style="width: 60px;padding-top: 9px;vertical-align:top;"><img src="<?php echo get_gravatar($user_email,60);?>"></td>
					<td style="padding-left: 5px;vertical-align:top;">
						<div class="threadUserName"><?php echo $user_name;?></div>
						<div><small class="threadUserType"><?php echo $user_email;?></small></div>
						<div><small class="threadCreateTime"><?php echo $modified;?></small></div>
					</td>
				</tr>
			</table>
			<div class="threadBody"><?php echo $body;?></div>
			<?php if(count($attachments)){?>
			<div class="threadAttachment">
				<span style="font-weight: bold;font-style: italic;">Attachment: </span>
				<?php 
				$attachCount=0;
				foreach ($attachments as $attachment){
					$attach=$wpdb->get_row( "select * from {$wpdb->prefix}wpsp_attachments where id=".$attachment );
					$attachCount++;
				?>
				<a class="attachment_link" title="Download" target="_blank" href="<?php echo $attach->fileurl;?>" ><?php echo ($attachCount>1)?', ':'';echo $attach->filename;?></a>
				<?php }?>
			</div>
			<?php }?>
</div>
<?php }?>



<?php 
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}
?>
