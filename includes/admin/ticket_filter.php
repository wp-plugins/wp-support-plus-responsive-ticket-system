<?php 
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>
<div class="filter_item">
	<table>
		<tr>
			<td>Status:</td>
			<td>
				<select id="filter_by_status">
					<option value="all">All</option>
					<option value="open">Open</option>
					<option value="pending">Pending</option>
					<option value="closed">Closed</option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td>Type:</td>
			<td>
				<select id="filter_by_type">
					<option value="all">All</option>
					<option value="user">User</option>
					<option value="guest">Guest</option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td>Category:</td>
			<td>
				<select id="filter_by_category">
					<option value="all">All</option>
					<?php 
					foreach ($categories as $category){
						echo '<option value="'.$category->id.'">'.$category->name.'</option>';
					}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td>Priority:</td>
			<td>
				<select id="filter_by_priority">
					<option value="all">All</option>
					<option value="normal">Normal</option>
					<option value="high">High</option>
					<option value="medium">Medium</option>
					<option value="low">Low</option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td>No of Tickets:</td>
			<td>
				<select id="filter_by_no_of_ticket">
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_search">
	<table>
		<tr>
			<td><input type="text" id="filter_by_search" placeholder="Search Tickets..." /></td>
		</tr>
	</table>
</div>