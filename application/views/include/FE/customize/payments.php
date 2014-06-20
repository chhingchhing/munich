<div class="col-sm-12 form-booking" id="payments">
	<h2>Payments</h2>
	<hr>
	<div id="pay_feedback"></div>
	<?php 
	echo form_open('site/pay_later_customize', 'class="form-horizontal" name="frm_pay_later"');
	// echo anchor("site/customizes/personal-info","Add your member(s)", array('role' => 'button', 'class' => 'btn btn-success btn-sm'));
	if ($this->session->userdata('pay_later') == true) {
		echo anchor(
			"#", 
			"Add info all passengers!", 
			"class='btn btn-success btn-sm' data-target='.addmorepassenger_modal' data-toggle='modal'"
		);
	} else {
		echo anchor("site/pay_later_customize","Pay Later", array('role' => 'button', 'class' => 'btn btn-warning btn-sm', 'id' => 'pay_later'));
	}
	echo nbs();
	?>
	<button type="submit" class="btn btn-primary btn-sm" name="btnFinishCusBooking" id="btnFinishCusBooking"> Finish </button>
	<?php
	echo form_close();
	?>
	
<p></p>
</div>
	<!-- end div home -->
