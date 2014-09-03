<?php 
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>
<h3>Create New Ticket</h3>
<form id="frmCreateNewTicket">
	<span class="label label-info" style="font-size: 13px;">Subject</span><br>
	<input type="text" id="create_ticket_subject" name="create_ticket_subject" maxlength="80" style="width: 95%; margin-top: 10px;"/><br><br>
	<span class="label label-info" style="font-size: 13px;">Description</span><br>
	<textarea id="create_ticket_body" name="create_ticket_body" style="margin-top: 10px; width: 95%; overflow-y:hidden;" onkeyup='this.rows = (this.value.split("\n").length||1);'></textarea><br><br>
	<div>
		<span class="label label-info" style="font-size: 13px;">Category</span><br>
		<select id="create_ticket_category" name="create_ticket_category" style="margin-top: 10px;">
			<?php 
			foreach ($categories as $category){
				echo '<option value="'.$category->id.'">'.$category->name.'</option>';
			}
			?>
		</select><br><br>
	</div>
	<div>
		<span class="label label-info" style="font-size: 13px;">Priority</span><br>
		<select id="create_ticket_priority" name="create_ticket_priority" style="margin-top: 10px;">
			<option value="normal">Normal</option>
			<option value="high">High</option>
			<option value="medium">Medium</option>
			<option value="low">Low</option>
		</select>
	</div><br>
	<div>
		<span class="label label-info" style="font-size: 13px;">Attach File(s)</span><br>
		<input style="margin-top: 10px;" type="file" name="attachment[]" multiple>
	</div>

	<br>
	<input type="hidden" name="action" value="createNewTicket">
	<input type="hidden" name="user_id" value="<?php echo $current_user->ID;?>">
	<input type="hidden" name="type" value="user">
	<input type="hidden" name="guest_name" value="">
	<input type="hidden" name="guest_email" value="">
	<input type="submit" class="btn btn-success" value="Submit Ticket">
	<input type="button" class="btn btn-success" value="Reset Form" onClick="this.form.reset()" />
</form>