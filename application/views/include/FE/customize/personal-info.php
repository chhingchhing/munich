<div class="col-sm-12" id="feedback_bar"></div>
<?php 
$new_sess_passenger = $this->session->userdata('new_passenger_id');
$login_sess_passenger = $this->session->userdata("passenger");
$disabled = $login_sess_passenger ? "disable" : $new_sess_passenger ? "disable" : '';
if (isset($arr_messages)) {
	if ($arr_messages != "") { ?>
		<div class="alert alert-<?php echo $arr_messages['sms_type']; ?> alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong><?php echo $arr_messages['sms_title']; ?></strong> <?php echo $arr_messages['sms_value']; ?>		
		</div>
<?php }
}
?>
<?php  echo form_open_multipart('site/customizes/personal-info', 'class="form-horizontal" name="frm_personal_info" '); ?>
<!-- Start Div Control Form Personal Information -->
<div class="col-sm-12 form-booking" id="personal_info">
	   		<h2>Personal Information</h2>
	   		<hr>
	   		<div class="col-sm-12">
	   			<div class='col-sm-9'>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Passenger Firstname <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					        <?php 
					        	echo form_hidden("passenger_id", $passenger_info->pass_id);
					        	$pfname = array(
					        	'name' => 'pfname', 
					        	'class' => 'form-control input_require disabled_input', 
					        	'placeholder' => 'Passenger firstname',
					        	'value' => $passenger_info->pass_fname,
					        	'required' => 'required'
					        	); 
					        	echo form_input($pfname); 
					        ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Passenger Lastname <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php $plname = array(
					         	'name' => 'plname', 
					         	'class' => 'form-control input_require disabled_input', 
					         	'placeholder' => 'Passenger lastname',
					         	'value' => $passenger_info->pass_lname,
					         	'required' => 'required'
					         	); 
					         	echo form_input($plname); 
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Email <span class="require">*</span>: </label>
		   				<div class="col-sm-7">
					        <?php $pemail = array(
					         	'type' => "email",
					         	'name' => 'pemail', 
					         	'class' => 'form-control input_email disabled_input',
					         	'placeholder' => 'Email',
					         	'value' => $passenger_info->pass_email,
					         	'required' => 'required'
					         	); 
					         	echo form_input($pemail); 
					        ?>
					        <span class="help-block">Example: username@example.com</span>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Home Phone <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php $phphone = array(
					         	'name' => 'phphone', 
					         	'class' => 'form-control input_require disabled_input', 
					         	'placeholder' => 'Home phone',
					         	'value' => $passenger_info->pass_phone,
					         	'required' => 'required'
					         	); 
					         	echo form_input($phphone); 
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Mobile phone :</label>
		   				<div class="col-sm-7">
					         <?php $pmobile = array(
					         	'name' => 'pmobile', 
					         	'class' => 'form-control disabled_input', 
					         	'placeholder' => 'Mobile phone ',
					         	'value' => $passenger_info->pass_mobile,
					         	); 
					         	echo form_input($pmobile); 
					         ?>
					    </div>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Company :</label>
		   				<div class="col-sm-7">
					         <?php $pcompany = array(
					         	'name' => 'pcompany', 
					         	'class' => 'form-control disabled_input', 
					         	'placeholder' => 'Company',
					         	'value'=> $passenger_info->pass_company,
					         	); 
					         	echo form_input($pcompany); 
					        ?>
					    </div>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Country <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php 
					         echo country_dropdown('pcountry', 'cont', 'form-control input_require', $passenger_info->pass_country, array('KH','CA','US'), '');					        
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Gender <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php 
					         $pgender = array('' => '--- selected --- ','F' => 'Female' , 'M' => 'Male'); 
					         echo form_dropdown("pgender", $pgender, $passenger_info->pass_gender,"class = 'form-control' "); 
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Address <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php $paddress = array(
					         	'name' => 'paddress', 
					         	'class' => 'form-control input_require', 
					         	'placeholder' => 'Passenger Address', 
					         	'rows' => '3',
					         	'value' => $passenger_info->pass_address,
					         	'required' => 'required'
					         	); 
					         	echo form_textarea($paddress); 
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			
<div class="form-group">
		   				<label class="col-sm-4 control-label">Additional Info:</label>
		   				<div class="col-sm-7 checkbox">
					         <?php
					         $bk_fee_val = 15; 
					         $checked = false;
					         if ($this->general_lib->get_booking_fee() != '') {
					         	$checked =  true;
					         }
					         $bk_fee = array(
					         	'name' => 'pbk_fee',
					         	'clas' => 'form-control',
					         	'value' => $bk_fee_val,
					         	'checked' => $checked,
					         	'required' => 'required'
					         );
					         echo '<span class="require">*</span>'.form_checkbox($bk_fee).' Booking Fee $'.$bk_fee_val;
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label"></label>
		   				<div class="col-sm-7 checkbox">
					         <?php
					         $checked = false;
					         if ($this->general_lib->get_booking_fee() != '') {
					         	$checked =  true;
					         }
					         $bk_term_condition = array(
					         	'name' => 'pterm_condition',
					         	'clas' => 'form-control',
					         	'checked' => $checked,
					         	'required' => 'required'
					         );
					         echo '<span class="require">*</span>'.form_checkbox($bk_term_condition).' Term Condition';
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
				</div>
	   			<div style='clear: both'></div>

	   		</div>
	   		
	   		<?php echo anchor("site/customizes/extra-service","Previous", array('role'=>'button', 'class'=>'btn btn-default btn-sm')); ?>
			<?php 
			$input = array('name' => 'btnPersonalInfo', 'class' => 'btn btn-primary btn-sm', 'value' => ' Save '); 
			echo form_submit($input);
			echo nbs();
			if ($passenger_info->pass_id != "") {
				if ($this->general_lib->get_booking_fee() != '') {
					echo anchor("site/customizes/payments"," Next ", array('role'=>'button', 'class'=>'btn btn-primary btn-sm'));
				} else {
					echo anchor("site/customizes/payments"," Next ", array('role'=>'button', 'class'=>'btn btn-primary btn-sm', 'disabled'=>'disabled'));
				}
			} else {
				echo anchor("site/customizes/payments"," Next ", array('role'=>'button', 'class'=>'btn btn-primary btn-sm', 'disabled'=>'disabled'));
			}
			echo nbs();
			?>
<p></p>
<?php echo form_close(); ?>
</div>
<!-- End Div control form Personal Information -->
