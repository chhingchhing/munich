<?php 
  if(! $this->session->userdata('ftvID') && ! $this->session->userdata('lcID')){
  	redirect('site/booking');
  }
?>
<!-- Trip Information -->
<div class="row clearfix wrap_customize">
<div class="col-sm-12 titleBooking">
<h1>Trip Information</h1>
</div>
<div class="col-sm-12">

<?php echo form_open('site/packages/tripinfo'); ?>
<div id="trip_info" class="tab-pane col-sm-12 active form-booking">
	<table class="tb">
		<tr>
			<td class="firstTD"><strong>Amount People <span class="required">*</span>:</strong></td>
			<td><?php echo form_input(array('name'=>'numPassenger', 'value'=>set_value('numPassenger'),'class'=>'form-control numPassenger')); ?></td>
			<td style="color:red;"><?php echo form_error('numPassenger'); ?></td>
		</tr>
		<tr>
			<td class="firstTD"><strong>Departure Date <span class="required">*</span>:</strong> </td>
			<td><?php echo form_input(array('name'=>'dpDate', 'value'=>set_value('dpDate'),'class'=>'form-control dpDatef', 'id'=>"dpDatefe", 'data-date-format'=>'yyyy-mm-dd')); ?></td>
			<td style="color:red;"><?php echo form_error('dpDate'); ?></td>
		</tr>
		<!-- <tr>
			<td class="firstTD"><strong>Return Date <span class="required">*</span>: </strong></td>
			<td><?php // echo form_input(array('name'=>'rtDate', 'value'=>set_value('rtDate'), 'class'=>'form-control rtDatef', 'data-date-format'=>'yyyy-mm-dd')); ?></td>
			<td><?php // echo form_error('rtDate'); ?></td>
		</tr> -->		
	</table>

<?php 
	echo form_submit(array('name'=>'tripinfoSubmit', 'value'=>'Next', 'class'=>'tripinfoSubmit btn btn-primary')).nbs(5);
	echo anchor('site/booking/tour_type', 'Back', 'class="btn btn-default"');
?>

	</div>
<?php
	echo form_close(); 
?>

</div>
</div>