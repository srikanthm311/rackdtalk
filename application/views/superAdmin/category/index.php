<div class="col-md-10 col-sm-9 main_backup dashboard-left-main">
<div class="col-md-12 col-sm-9 main_backup dashboard-left-main">



<div class="memberlogin-wps col-md-10 products_page category-super">

  <div class="dashboard-main-block">
      <div class="dashboard-main-hdng"><h2>Categories</h2></div>
      <div class="dashboard-main-btn"><a class="category_add" href="<?php echo base_url('superadmincategory/add_category')?>">Add New Category</a></div>
    </div>

  <div class="col-md-12"> </div>

  

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>   

           <th>Category Uid</th>

			<th>Category Name</th>

            <th>Status</th>

            <th width="10%">Edit</th>
            
            <th width="10%">Delete</th>

			

		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($Categories))

				 {

                 foreach($Categories as $sub)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">

                    <td> <?php echo $sub['category_uid']?></td>

                    <td> <?php echo $sub['category_name']?></td>

                  <?php /*?>  <td><?php echo $sub['slug']?></td><?php */?>

                    <th id="serviceActive-<?php echo $sub['id']; ?>"><?php echo ($sub['is_active']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to inactivate" class="btn btn-sm btn-success" onclick="activate(\''.$sub['id'].'\', \'0\')">Active</a>' : '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''.$sub['id'].'\', \'1\')">Inactive</a>'; ?></th>

                    <td class="textbutton"> <a href='<?php echo base_url('superadmincategory/add_category/'.$sub['id'])?>' data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></a></td>

                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('superadmincategory/deletecategory/'.$sub['id'])?>' class="fa fa-trash"></a></td>

                   </tr>

             <?php

				 $i++; }

				 }else{?>

					 <tr ><td colspan="5" style="text-align:center">No records found</td></tr>

				<?php  }

                 ?>

                



	</tbody>

	<!-- Table Body -->



</table>



</div>

<script type="text/javascript">

function activate(catID, status)

{

	var dataString = "catID="+catID+"&status="+status;

	$.ajax({

		type: "POST",

		url: '<?php echo base_url('superadmincategory/updateMenuStatus'); ?>',

		data: dataString,

		success: function (data) {

			if(data)

			{

				var html = '';

				if(status == 0)

					html = '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''+catID+'\', \'1\')">Inactive</a>';

				else 

					html = '<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Click here to inactivate" onclick="activate(\''+catID+'\', \'0\')">Active</a>';

				$("#serviceActive-"+catID).html(html);

			}

		}

	});

}



</script>