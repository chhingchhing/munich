<?php $this->load->view(INCLUDE_FE.'before_content'); ?> 
<?php 
	//echo 'working it';
 ?>
<?php  echo form_open('site/paysucceed/'.$this->uri->segment(4), 'class="frmaddpassinfo"'); ?>

<div class="row clearfix">
	<div class="col-lg-8" style="padding-left: 0px;">	
<!-- Personal Information -->
	<h4 class="infoheader">Personal Information</h4>
<?php 
	if($passengerbooking != false){
		if($passengerbookingrecord->num_rows() > 0){
?>
	<table class="table table-striped table-hover table-bordered">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
		</tr>
<?php
			foreach($passengerbookingrecord->result() as $value){
?>
		<tr>
			<td><?php echo $value->pass_lname.' '.$value->pass_fname; ?></td>
			<td><?php echo $value->pass_email; ?></td>
			<td><?php echo $value->pass_phone; ?></td>
		</tr>
<?php
			}
?>
	</table>
<?php
		}
	}
?>
		<table class="tb error">
			<tr>
				<td class="firstTD"><strong>First Name <span class="required">*</span>:</strong></td>
				<td><?php echo form_input(array('name'=>'fname', 'value'=>set_value('fname'),'class'=>'form-control')); ?></td>
				<td><?php echo form_error('fname'); ?></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Last Name <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'lname', 'value'=>set_value('lname'),'class'=>'form-control')); ?></td>
				<td><?php echo form_error('lname'); ?></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Gender <span class="required">*</span>: </strong></td>
				<td>
				<?php 
					if(isset($packagefinalStep['gendercheck']) and $packagefinalStep['gendercheck'] == 'M') $m = true; else $m = false;
					if(isset($packagefinalStep['gendercheck']) and $packagefinalStep['gendercheck'] == 'F') $f = true; else $f = false;
					if(isset($packagefinalStep['gendercheck']) and $packagefinalStep['gendercheck'] == 'O') $o = true; else $o = false;
				?>
				<?php echo form_radio(array('name'=>'gender', 'value'=>'M', 'class'=>set_value('m'), 'checked'=> $m)).nbs(3).'Male'.nbs(5); ?>
				<?php echo form_radio(array('name'=>'gender', 'value'=>'F', 'class'=>set_value('f'), 'checked'=> $f)).nbs(3).'Female'.nbs(5); ?>
				<?php echo form_radio(array('name'=>'gender', 'value'=>'O', 'class'=>set_value('o'), 'checked'=> $o)).nbs(3).'Other'; ?></td>
				<td><p><?php if(isset($packagefinalStep['gendercheck']) and $packagefinalStep['gendercheck'] == FALSE) echo "The gender field is required"; else echo ''; ?></p></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Email <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'uemail', 'value'=>set_value('uemail'),'class'=>'form-control')); ?></td>
				<td><?php echo form_error('uemail'); ?></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Phone <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'phone', 'value'=>set_value('phone'),'class'=>'form-control')); ?></td>
				<td><?php echo form_error('phone'); ?></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Mobile Phone :</strong> </td>
				<td><?php echo form_input(array('name'=>'mobilephone', 'value'=>set_value('mobilephone', $packagefinalStep['mobilephoneinput']),'class'=>'form-control')); ?></td>
				<td><p><?php if(isset($packagefinalStep['mobilePhoneError'])) echo $packagefinalStep['mobilePhoneError']; else echo ''; ?></p></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Country <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'country', 'value'=>set_value('country'),'class'=>'form-control')); ?></td>
				<td><?php echo form_error('country'); ?></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>City <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'city', 'value'=>set_value('city'),'class'=>'form-control')); ?></td>
				<td><?php echo form_error('city'); ?></td>
			</tr>
			<!-- <tr>
				<td class="firstTD"><strong>Postal Code <span class="required">*</span>:</strong> </td>
				<td><?php //echo form_input(array('name'=>'postalcode', 'value'=>set_value('postalcode'),'class'=>'form-control')); ?></td>
				<td><?php //echo form_error('postalcode'); ?></td>
			</tr> -->
			<tr>
				<td class="firstTD"><strong>Address <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'address', 'value'=>set_value('address'),'class'=>'form-control')); ?></td>
				<td><?php echo form_error('address'); ?></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>About You :</strong> </td>
				<td><?php echo form_textarea(array('name'=>'aboutYou', 'value'=>set_value('aboutYou', $packagefinalStep['aboutYouInput']),'class'=>'form-control','rows'=>'2')); ?></td>
				<td></td>
			</tr>	
		</table>
		<br />

	<?php echo form_submit(array('name'=>'submitmorepassenger', 'value'=>'Submit', 'class'=>'btn btn-primary submitmorepassenger')).nbs(3); ?>
	<?php echo anchor('','No thanks ', 'class="btn btn-default"'); ?>
	</div>
<?php  echo form_close(); ?>
	<!-- <div class="col-lg-4" style="padding-left: 0px;">
		<h4 class="infoheader">What is this page mean?</h4>
		You can add any passenger information which avalable for 4 people.
	</div> -->
	<div class="col-lg-4">
	<h4 class="infoheader">Your Booking</h4>
		<?php 
			if(isset($getbooking)){
				if($getbooking->num_rows()){
					foreach($getbooking->result() as $bookingValue){
		?>
				<table class="tb">
					<tr>
						<td class="firstTD"><strong>Booking Date :</strong> </td>
						<td><?php echo $bookingValue->bk_date; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Type :</strong> </td>
						<td><?php echo $bookingValue->bk_type; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Departure :</strong> </td>
						<td><?php echo $bookingValue->bk_arrival_date; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Return :</strong> </td>
						<td><?php echo $bookingValue->bk_return_date; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>People :</strong> </td>
						<td><?php echo $bookingValue->bk_total_people; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Price :</strong> </td>
						<td><?php echo $bookingValue->bk_pay_price; ?> $</td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Pay Status :</strong> </td>
						<td><?php echo $bookingValue->bk_pay_status; ?></td>
					</tr> 
				</table>
		<?php
					}
				}
			}
		?>
	</div>
</div>

<style>
	.tb td {
		padding:10px;
		font-size: 12px;
	}
	.firstTD {
		padding-left: 0px !important;
	}
	.infoheader {
		color:#3F703F;
	}
	.error p, .txtError, .required{
		color:red;
	}
</style>
<?php $this->load->view(INCLUDE_FE.'after_content'); ?>