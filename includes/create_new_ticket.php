<?php 
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>
<form id="frmCreateNewTicketGeuest">
	<span class="label label-info" style="font-size: 13px;">Your Name</span><code>*</code><br>
	<input type="text" id="create_ticket_guest_name" name="guest_name" maxlength="20" style="width: 95%; margin-top: 10px;" /><br><br>
	<span class="label label-info" style="font-size: 13px;">Your Email</span><code>*</code><br>
	<input type="text" id="create_ticket_guest_email" name="guest_email" maxlength="50" style="width: 95%; margin-top: 10px;" /><br><br>
	<span class="label label-info" style="font-size: 13px;">Subject</span><code>*</code><br>
	<input type="text" id="create_ticket_subject" name="create_ticket_subject" maxlength="80" style="width: 95%; margin-top: 10px;"/><br><br>
	<span class="label label-info" style="font-size: 13px;">Description</span><code>*</code><br>
	<textarea id="create_ticket_body" name="create_ticket_body" style="margin-top: 10px; width: 95%; overflow-y:hidden;" onkeyup='this.rows = (this.value.split("\n").length||1);'></textarea><br><br>
	<div id="replyFloatedContainer" style="">
		<div class="replyFloatLeft">
			<span class="label label-info" style="font-size: 13px;">Category</span><br>
			<select id="create_ticket_category" name="create_ticket_category" style="margin-top: 10px;">
				<?php 
				foreach ($categories as $category){
					echo '<option value="'.$category->id.'">'.$category->name.'</option>';
				}
				?>
			</select><br><br>
		</div>
		<div class="replyFloatLeft">
			<span class="label label-info" style="font-size: 13px;">Priority</span><br>
			<select id="create_ticket_priority" name="create_ticket_priority" style="margin-top: 10px;">
				<option value="normal">Normal</option>
				<option value="high">High</option>
				<option value="medium">Medium</option>
				<option value="low">Low</option>
			</select>
		</div>
	</div>
	<br>
	<input type="hidden" name="action" value="createNewTicket">
	<input type="hidden" name="user_id" value="0">
	<input type="hidden" name="type" value="guest">
	<input type="submit" class="btn btn-success" value="Submit Ticket">
	<input type="button" class="btn btn-success" value="Reset Form" onClick="this.form.reset()" />
</form>