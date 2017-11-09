<div class="col-md-7 col-sm-9 main_backup">

<div class="memberlogin-wps col-md-12 products_page">
  <h2>Blogs<a class="category_add" href="<?php echo base_url('adminblogs/add_blog')?>">Add New Blog</a></h2>
  <div class="col-md-12"> </div>
  
 <table class="table table-hover table-striped table_hd1">
    <thead class="table_heading">
		<tr>
			<th>Title</th>
            <th>Image</th>
            <th>Status</th>
            <th width="10%">Actions</th>
			
		</tr>
	</thead>
	<!-- Table Header -->

	<!-- Table Body -->
	 <tbody>    <?php $i=1;
	 
	             if(!empty($blogs))
				 {
                 foreach($blogs as $sub)
				 {
                 ?>
                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
                    <td> <?php echo $sub['title']?></td>
                    <td> <img src="<?php echo base_url().$sub['image']?>" width="100" height="100"/></td>
                    <th id="serviceActive-<?php echo $sub['id']; ?>"><?php echo ($sub['is_active']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to inactivate" class="btn btn-sm btn-success" onclick="activate(\''.$sub['id'].'\', \'0\')">Active</a>' : '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''.$sub['id'].'\', \'1\')">Inactive</a>'; ?></th>
                    <td class="textbutton"> <a href='<?php echo base_url('adminblogs/add_blog/'.$sub['id'])?>' data-toggle="tooltip" data-placement="top" title="Edit" class="glyphicon glyphicon-pencil view_button"></a></td>
                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('adminblogs/deleteblog/'.$sub['id'])?>' class="glyphicon glyphicon-remove"></a></td>
                   </tr>
             <?php
				 $i++; }
				 }else{?>
					 <tr ><td colspan="6" style="text-align:center">No records found</td></tr>
				<?php  }
                 ?>
                

	</tbody>
	<!-- Table Body -->

</table>
</div>
</div>
<script type="text/javascript">
function activate(ID, status)
{
	var dataString = "ID="+ID+"&status="+status;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url('adminblogs/updateBlogStatus'); ?>',
		data: dataString,
		success: function (data) {
			if(data)
			{
				var html = '';
				if(status == 0)
					html = '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''+ID+'\', \'1\')">Inactive</a>';
				else 
					html = '<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Click here to inactivate" onclick="activate(\''+ID+'\', \'0\')">Active</a>';
				$("#serviceActive-"+ID).html(html);
			}
		}
	});
}

</script>