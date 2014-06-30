<div class="col-sm-12 form-booking" id="payments">
	<h2>Payments</h2>
	<hr>
	<div id="pay_feedback"></div>
	<?php 
	echo form_open('site/pay_later_customize', 'class="form-horizontal" name="frm_pay_later"');
	echo anchor("site/customizes/personal-info","Previous", array('role'=>'button', 'class'=>'btn btn-default btn-sm')); 
	echo nbs(2);
	// if ($this->session->userdata('pay_later') == true) {
		/*echo anchor(
			"#", 
			"Add info all passengers!", 
			"class='btn btn-success btn-sm' data-target='.addmorepassenger_modal' data-toggle='modal'"
		);*/
		// echo nbs(2);
		// echo anchor("site/pay_later_customize","Pay Later", array('role' => 'button', 'class' => 'btn btn-primary btn-sm', 'id' => 'pay_later', 'disabled' => 'disabled'));
		?>
		<!-- <button type="submit" class="btn btn-primary btn-sm" name="btnFinishCusBooking" id="btnFinishCusBooking"> Finish </button> -->
		<?php
	// } else {
		/*echo anchor(
			"#", 
			"Add info all passengers!", 
			"class='btn btn-success btn-sm' data-target='.addmorepassenger_modal' data-toggle='modal' disabled='disabled' "
		);*/
		echo nbs(2);
		echo anchor("site/pay_later_customize","Pay Later", array('role' => 'button', 'class' => 'btn btn-primary btn-sm', 'id' => 'pay_later'));
		?>
		<!-- <button type="submit" class="btn btn-primary btn-sm" name="btnFinishCusBooking" id="btnFinishCusBooking" disabled="disabled"> Finish </button> -->
		<?php
	// }
	echo nbs();
	?>
	<?php
	echo form_close();
	?>
	
<p></p>
</div>
	<!-- end div home -->
