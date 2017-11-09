<?php if(is_array($bids) && count($bids)){ ?>
<?php /*?><table class="table table-bordered table-hovered">
  <tbody>
    <tr>
      <th scope="col">Ticket Number</th>
      <td><?=$reservation_details['etstNumber'];?></td>
      <th scope="col">PNR</th>
      <td><?=$reservation_details['PNR'];?></td>
    </tr>
    <tr>
      <th scope="col">Source City</th>
      <td><?=$reservation_details['sourceCity'];?></td>
      <th scope="col">Destination City</th>
      <td><?=$reservation_details['destinationCity'];?></td>
    </tr>
    <tr>
      <th scope="col">Journey Date</th>
      <td><?=date("Y-m-d", strtotime($reservation_details['journeyDate']));?></td>
      <th scope="col">Total fare with taxes</th>
      <td align="right"><?=number_format($reservation_details['totalFareWithTaxes'],2);?></td>
    </tr>
    
    <tr>
      <th scope="col">Discount Amount</th>
      <td align="right"><?=number_format($reservation_details['discount_amount'],2);?></td>
      <th scope="col">Total</th>
      <td align="right"><?=number_format($reservation_details['Total'],2);?></td>
    </tr>
    
    
     <?php if($reservation_details['ticketStatus'] == 'REFUNDED'){ ?>
     
      <tr>
      <th scope="col">Refunded Amount</th>
      <td align="right"><?=number_format($reservation_details['refundAmount'],2);?></td>
      <th scope="col">Cancelled Amount</th>
      <td align="right"><?=number_format($reservation_details['cancelledAmount'],2);?></td>
    </tr>
    
    <?php } ?>
    <tr>
      <th scope="col">Service Provider</th>
      <td><?=$reservation_details['serviceProvider'];?></td>
      <th scope="col">Service Type</th>
      <td><?=$reservation_details['serviceType'];?></td>
    </tr>
    <tr>
      <th scope="col">Boarding Point</th>
      <td><?=$reservation_details['boardingPoint'];?></td>
      <th scope="col">Ticket Status</th>
      <td><?=$reservation_details['ticketStatus'];?></td>
    </tr>
    <tr> 
   <tr>
      <th scope="col">Email ID</th>
      <td><?=$reservation_details['emailID'];?></td>
      <th scope="col">Mobile No</th>
      <td><?=$reservation_details['mobile'];?></td>
    </tr>
    <tr> 
  </tbody>
</table><?php */?>
<h3>Bid  details</h3>
<table class="table table-bordered table-hovered">
  <tbody>
    <tr>
      <th scope="col">S No</th>
      <th scope="col">Name</th>
      <th scope="col">Amount</th>
    </tr>
    <?php $sno = 0; foreach($bids as $bid){ ?>
    <tr>
    <td><?=++$sno;?></td>
    <td><?=$bid['useremail'];?></td>
    <td><?=$bid['amount'];?></td>

    </tr>
    <?php } ?>
  </tbody>
</table>
<?php }else{ ?>
<p>Invalid comment.</p>	
<?php } ?>
