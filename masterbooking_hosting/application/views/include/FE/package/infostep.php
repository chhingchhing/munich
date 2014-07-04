<?php 
  if( ! $this->session->userdata('pkID') || ! $this->session->userdata('ftvID') || ! $this->session->userdata('lcID') || ! $this->session->userdata('dpd') || ! $this->session->userdata('nop')){
  	redirect('site/booking');
  }
?>
<div class="row clearfix wrap_customize">
<div class="col-sm-12 titleBooking">
	<h1>Booking Tours</h1>
	<h2>Provide Your Informations</h2>
</div>
<div class="col-sm-12">
<div class="col-sm-10">
<?php  echo form_open('site/packages/infostep', 'class="frminfo"'); ?>
<div id="trip_info" class="tab-pane col-sm-12 active form-booking">
	<?php 
		// $std = $this->session->userdata('pkstartdate') ? $this->session->userdata('pkstartdate') : "";
		// $endd = $this->session->userdata('pkenddate') ? $this->session->userdata('pkenddate') : "";
		echo form_input(array('name'=>'numPassenger', 'value'=>set_value('numPassenger', $this->session->userdata('nop')),'class'=>'form-control numPassenger hide'));
		// echo form_hidden('endd',$endd);	
		echo form_hidden('pkPrice', $this->session->userdata('pkprice'));	
	?>
<!-- Personal Information -->
	<h4 class="infoheader">Personal Information</h4>
		<table class="tb">
			<tr>
				<td class="firstTD"><strong>First Name <span class="required">*</span>:</strong></td>
				<td><?php echo form_input(array('name'=>'fname', 'value'=>set_value('fname'),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php echo form_error('fname'); ?></p></span></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Last Name <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'lname', 'value'=>set_value('lname'),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php echo form_error('lname'); ?></p></span></td>
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
				<td><span class="txtError"><p><?php if(isset($packagefinalStep['gendercheck']) and $packagefinalStep['gendercheck'] == FALSE) echo "The gender field is required"; else echo ''; ?></p></span></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Email <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'uemail', 'value'=>set_value('uemail'),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php echo form_error('uemail'); ?></p></span></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Phone <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'phone', 'value'=>set_value('phone'),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php echo form_error('phone'); ?></p></span></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Mobile Phone :</strong> </td>
				<td><?php echo form_input(array('name'=>'mobilephone', 'value'=>set_value('mobilephone', $packagefinalStep['mobilephoneinput']),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php if(isset($packagefinalStep['mobilePhoneError'])) echo $packagefinalStep['mobilePhoneError']; else echo ''; ?></p></span></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Country <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'country', 'value'=>set_value('country'),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php echo form_error('country'); ?></p></span></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>City <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'city', 'value'=>set_value('city'),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php echo form_error('city'); ?></p></span></td>
			</tr>
			<!-- <tr>
				<td class="firstTD"><strong>Postal Code <span class="required">*</span>:</strong> </td>
				<td><?php //echo form_input(array('name'=>'postalcode', 'value'=>set_value('postalcode'),'class'=>'form-control')); ?></td>
				<td><?php //echo form_error('postalcode'); ?></td>
			</tr> -->
			<tr>
				<td class="firstTD"><strong>Address <span class="required">*</span>:</strong> </td>
				<td><?php echo form_input(array('name'=>'address', 'value'=>set_value('address'),'class'=>'form-control')); ?></td>
				<td><span class="txtError"><p><?php echo form_error('address'); ?></p></span></td>
			</tr>
			<tr>
				<td class="firstTD"><strong>Special Request :</strong> </td>
				<td><?php echo form_textarea(array('name'=>'aboutYou', 'value'=>set_value('aboutYou', $packagefinalStep['aboutYouInput']),'class'=>'form-control','rows'=>'2')); ?></td>
				<td></td>
			</tr>	
		</table>
<!-- Payment Information -->
	<h4 class="infoheader">Payment Information</h4>
		<p>Tell us, What will you pay?</p>
		<?php 
			if(isset($packagefinalStep['paycheck']) and $packagefinalStep['paycheck'] == 'paylater') $p = true; else $p = false;
			if(isset($packagefinalStep['paycheck']) and $packagefinalStep['paycheck'] == 'paynow') $i = true; else $i = false;
		?>
		<span class="txtError"><p><?php if(isset($packagefinalStep['paycheck']) and $packagefinalStep['paycheck'] == FALSE) echo "The payment method field is required"; else echo ''; ?> </p></span>
		<?php echo form_radio(array('name'=>'payby', 'value'=>set_value('paylater','paylater'), 'class'=>'', 'checked'=>$p)).nbs(3).'Pay later'.br(1); ?>
		<?php echo form_radio(array('name'=>'payby', 'value'=>set_value('paynow', 'paynow'), 'class'=>'', 'checked'=>$i)).nbs(3).'Pay now'.br(2); ?>
<!-- Additional Information -->
	<h4 class="infoheader">Additional Information</h4>
		<?php 
			if(isset($packagefinalStep['bookingfeecheck']) and $packagefinalStep['bookingfeecheck'] == TRUE) $bf = true; else $bf = false;
		?>
		<?php echo form_checkbox(array('name'=>'bookingfee', 'value'=>set_value('bookingfee',15), 'class'=>'bookingfee','checked'=>$bf)).nbs(3).'Booking Fee 15$'.br(1); ?>
		<span class="txtError"><p><?php if(isset($packagefinalStep['bookingfeecheck']) and $packagefinalStep['bookingfeecheck'] == FALSE) echo "The booking fee field is required"; else echo ''; ?> </p></span>
		<?php 
			if(isset($packagefinalStep['termcheck']) and $packagefinalStep['termcheck'] == TRUE) $tc = true; else $tc = false;
		?>
		<?php echo form_checkbox(array('name'=>'term','value'=>set_value('term','checkterm'), 'class'=>'','checked'=>$tc)).nbs(3).'<span class="termcondition">Agree with Term and Condition</span>'.br(1); ?>
		<span class="txtError"><p><?php if(isset($packagefinalStep['termcheck']) and $packagefinalStep['termcheck'] == FALSE) echo "The term and condition field is required"; else echo ''; ?> </p></span>
		<div class="termcondition_content" style="display:none;border:1px solid #CCCCCC;padding:10px;">
			Term Condition Information...
		</div>
		<br />
	<?php echo form_submit(array('name'=>'btnFinalstep', 'value'=>'Submit', 'class'=>'btn btn-primary btnfinalstep')).nbs(3); ?>
	<?php echo anchor('site/packages/showservice','Back', 'class="btn btn-default"'); ?>
	</div>

<?php  echo form_close(); ?>
	</div>
	<div class="col-lg-2" style="padding: 0px; border:1px solid #ccc; background:#F5F5F5;border-radius:5px;">
		<h4 class="infoheader" style="padding:5px;border-bottom: 1px dotted #cccccc;">Price</h4>
		<p style="padding:5px;" id="pricepk" data-price="<?php echo $this->session->userdata('pkprice'); ?>">Package: $<?php echo $this->session->userdata('pkprice'); $totals = $this->session->userdata('pkprice') * $this->session->userdata('nop'); ?> / person</p>
		<?php 
		if($this->session->userdata('extraservice')){
			$extraservice = $this->session->userdata('extraservice');
			$extraserviceamount = $this->session->userdata('extraserviceamount');
			$epPrice = 0;
			foreach($extraservice as $key){
				$epPricetemp = MU_Model::getForiegnTableName('extraproduct', array('ep_id'=>$key), 'ep_saleprice');
				$epPrice += ($epPricetemp * $extraserviceamount[$key]);
			}
			$totals += $epPrice;
			echo '<p style="padding:5px;" id="exservice" data-price="'.$epPrice.'">Extra Service: $'.$epPrice.'</p>';
		}
		?>
		<p style="padding:5px;">People: <span id="ppl"><?php echo $this->session->userdata('nop'); ?></span></p>
		<p class="moreprice"></p>
		<p style="padding:5px;"><b>Totals: </b> $<span id="totals"><?php echo $totals; ?></span></p>
	</div>
</div>
</div>