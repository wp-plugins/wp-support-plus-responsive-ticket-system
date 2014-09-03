<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();

$sql="select t.id,t.type,t.subject,t.status,c.name as category,t.priority,t.created_by,t.guest_name,
		TIMESTAMPDIFF(MONTH,t.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,t.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,t.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,t.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,t.update_time,UTC_TIMESTAMP()) as date_modified_sec
		FROM {$wpdb->prefix}wpsp_ticket t 
		INNER JOIN {$wpdb->prefix}wpsp_catagories c ON t.cat_id=c.id ";
$where="WHERE t.created_by=".$current_user->ID.' ';
$order_by='ORDER BY t.update_time DESC ';
$limit_start=$_POST['page_no']*10;
$limit="LIMIT ".$limit_start.",10 ";

$sql.=$where;
$sql.=$order_by;
$tickets = $wpdb->get_results( $sql );
$current_page=$_POST['page_no']+1;
$total_pages=ceil($wpdb->num_rows/10);

$sql.=$limit;
$tickets = $wpdb->get_results( $sql );
?>
<div class="table-responsive">
	<table class="table table-striped table-hover" style="margin-top: 10px;">
	  <tr>
		  <th>#</th>
		  <th>Status</th>
		  <th>Subject</th>
		  <th class="category">Category</th>
		  <th class='priority'>Priority</th>
		  <th>Updated</th>
	  </tr>
	  <?php 
	  foreach ($tickets as $ticket){
		
		$raised_by='';
		if($ticket->type=='user'){
			$user=get_userdata( $ticket->created_by );
			$raised_by=$user->display_name;
		}
		else{
			$raised_by=$ticket->guest_name;
		}
		
		$modified='';
		if ($ticket->date_modified_month) $modified=$ticket->date_modified_month.' months ago';
		else if ($ticket->date_modified_day) $modified=$ticket->date_modified_day.' days ago';
		else if ($ticket->date_modified_hour) $modified=$ticket->date_modified_hour.' hours ago';
		else if ($ticket->date_modified_min) $modified=$ticket->date_modified_min.' minutes ago';
		else $modified=$ticket->date_modified_sec.' seconds ago';
		
		$status_color='';
		switch ($ticket->status){
			case 'open': $status_color='danger';break;
			case 'pending': $status_color='warning';break;
			case 'closed': $status_color='success';break;
		}
		$priority_color='';
		switch ($ticket->priority){
			case 'high': $priority_color='danger';break;
			case 'medium': $priority_color='warning';break;
			case 'normal': $priority_color='success';break;
			case 'low': $priority_color='info';break;
		}
		
		echo "<tr class='".$status_color."' style='cursor:pointer;' onclick='openTicket(".$ticket->id.");'>";
		echo "<td>".$ticket->id."</td>";
		echo "<td><span class='label label-".$status_color."' style='font-size: 13px;'>".ucfirst($ticket->status)."<span></td>";
		echo "<td>".substr($ticket->subject, 0,20)."...</td>";
		echo "<td class='category'>".$ticket->category."</td>";
		echo "<td class='priority'><span class='label label-".$priority_color."' style='font-size: 13px;'>".ucfirst($ticket->priority)."</span></td>";
		echo "<td>".$modified."</td>";
		echo "</tr>";
	  }
	  ?>
	</table>
	<?php 
	$prev_page_no=$current_page-1;
	$prev_class=(!$prev_page_no)?'disabled':'';
	$next_page_no=($total_pages==$current_page)?$current_page-1:$current_page;
	$next_class=($total_pages==$current_page)?'disabled':'';
	?>
	<ul class="pager" style="<?php echo ($total_pages==0)? 'display: none;':'';?>">
	  <li class="previous <?php echo $prev_class;?>"><a href="javascript:load_prev_page(<?php echo $prev_page_no;?>);">&larr; Newer</a></li>
	  <li><?php echo $current_page;?> of <?php echo $total_pages;?> Pages</li>
	  <li class="next <?php echo $next_class;?>"><a href="javascript:load_next_page(<?php echo $next_page_no;?>);">Older &rarr;</a></li>
	</ul>
	<div style="text-align: center;<?php echo ($total_pages==0)? '':'display: none;';?>">No Tickets Found</div>
	<hr style="<?php echo ($total_pages==0)? '':'display: none;';?>">
</div>