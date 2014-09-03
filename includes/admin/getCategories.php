<?php 
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>
<div class="table-responsive" style="margin-top: 10px;">
	<table class="table table-striped">
		<tr>
			<th>Category Name</th>
			<th>Action</th>
		</tr>
		<?php foreach ($categories as $category){?>
			<tr>
				<td><?php echo $category->name;?></td>
				<td>
					<?php if($category->id!=1){?>
					<img alt="Edit" onclick="editCategory(<?php echo $category->id;?>,'<?php echo $category->name;?>');" class="catEdit" title="Edit" src="<?php echo WCE_PLUGIN_URL.'asset/images/edit.png';?>" />
					<img alt="Edit" onclick="deleteCategory(<?php echo $category->id;?>,'<?php echo $category->name;?>');" class="catDelete" title="Delete" src="<?php echo WCE_PLUGIN_URL.'asset/images/delete.png';?>" />
					<?php }?>
				</td>
			</tr>
		<?php }?>
	</table>
</div>
<div id="createCategoryContainer">
	<input id="newCatName" class="form-control" style="width: 250px;margin-bottom: 10px;" type="text" placeholder="Enter Category Name" >
	<button class="btn btn-success" onclick="createNewCategory();">Create New Category</button>
</div>
<div id="editCategoryContainer" style="display: none;">
	<input type="hidden" id="editCatID" value="">
	<input id="editCatName" class="form-control" style="width: 250px;margin-bottom: 10px;" type="text" >
	<button onclick="updateCategory();" class="btn btn-success">Update Category</button>
</div>