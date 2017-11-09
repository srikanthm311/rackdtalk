<div class="col-md-10 col-sm-9 main_backup">



<div class="memberlogin-wps col-md-12 products_page">

    <div class="dashboard-main-heading"><h2>Cities</h2></div>

  <div class="col-md-12"> </div>

  <div class="search cities-block">
   <table><tr>
   <th></th><th></th></tr>
   <tr>
  <form action="" method="post">
<td>
<select name="country_id" class="form-control country_drop form-shadow form-cities-width" id="country_id">
  <option value="">select country</option>
  <?php foreach($countries as $country){?>
  <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
  <?php }?>
  </select>
  </td>
  <td id="state_td">
      
  <select name="state_id" class="form-control state_drop form-shadow form-cities-width" id="state_id">
  <option value="">select state</option>
  <?php foreach($states as $state){?>
  <option value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
  <?php }?>
  </select>
  </td>
    <td>
      <input type="text" class="form-control form-shadow form-cities-width" name="state_title" placeholder="Enter State Name"/>
    </td>
  <td><input class="btn btn-primary btn-style-rev" style=" margin-left:20px" type="submit" value="search" /></td>
  <input type="hidden" name="identity" value="1">
  </form>
  </tr>
  </table>
  </div>
  
  <hr />

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>City Name</th>
            <th> state</th>
            <th>country</th>
            <th width="10%">Actions</th>

		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($cities))

				 { $cnt = $this->uri->segment(3);

                 foreach($cities as $city)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$cnt;?></td>
                    <td> <?php echo $city['name']?></td>
                    <td> <?php echo $city['state_name']?></td>
                    <td> <?php echo $city['country_name']?></td>
                    <td style=" text-align:center"><a href="<?php echo base_url('admin/edit_city/'.$city['id'])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

                   </tr>

             <?php

				 $i++; }

				 }else{?>

					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>

				<?php  }

                 ?>

                



	</tbody>

	<!-- Table Body -->



</table>
<?php if(isset($paginationLinks))echo $paginationLinks; ?>
</div>

</div>

<script type="text/javascript">

$('.country_drop').change(function () {
	var country_id = jQuery("#country_id option:selected").val();
	$.ajax({

		type: "POST",

		url: '<?php echo base_url('admin/getstates'); ?>',
		dataType: 'json',
		data: {'id': country_id}, 

		success: function (data) {

			if(data)
			{
			$( ".state_drop option" ).remove();
			   var combo = $(".state_drop");
   				$.each(data, function (index, element) {
      			combo.append("<option value='"+ element.id +"'>" + element.name + "</option>");
   				 });

			}

		}

	});

});



</script>