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
	   		<?php //echo anchor("#", "Edit Personal Info", "id='edit_profile_pass'"); 
	   		?>
	   		<hr>
	   		<div class="col-sm-12">
	   			<div class='col-sm-9'>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Passenger firstname <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					        <?php 
					        	echo form_hidden("passenger_id", $passenger_info->pass_id);
					        	$pfname = array(
					        	'name' => 'pfname', 
					        	'class' => 'form-control input_require disabled_input', 
					        	'placeholder' => 'Passenger firstname',
					        	'value' => $passenger_info->pass_fname,
					        	); 
					        	echo form_input($pfname); 
					        ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Passenger lastname <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php $plname = array(
					         	'name' => 'plname', 
					         	'class' => 'form-control input_require disabled_input', 
					         	'placeholder' => 'Passenger lastname',
					         	'value' => $passenger_info->pass_lname,
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
					         	); 
					         	echo form_input($pemail); 
					        ?>
					        <span class="help-block">Example: username@example.com</span>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Home phone <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php $phphone = array(
					         	'name' => 'phphone', 
					         	'class' => 'form-control input_require disabled_input', 
					         	'placeholder' => 'Home phone',
					         	'value' => $passenger_info->pass_phone,
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
					         <?php $pcountry = array(
					         	'name' => 'pcountry', 
					         	'class' => 'form-control input_require disabled_input', 
					         	'placeholder' => 'Country',
					         	'value' => $passenger_info->pass_country
					         	); 
					         	echo form_input($pcountry); 
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>
		   			<div class="form-group">
		   				<label class="col-sm-4 control-label">Gender <span class="require">*</span>:</label>
		   				<div class="col-sm-7">
					         <?php 
					         $pgender = array('selected' => '--- selected --- ','F' => 'Female' , 'M' => 'Male'); 
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
					         	); 
					         	echo form_textarea($paddress); 
					         ?>
					    </div>
					    <p class="help-block error"></p>
		   			</div>

				</div>

	   			<div class='col-sm-3'>
	   				<div class="panel-group" id="accordion">
					  <div class="panel panel-success">
					    <div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-toggle="collapse" data-parent="#accordion" href="#members">
					          Members of trip <span class="caret"></span>
					        </a>
					      </h4>
					    </div>
					    <div id="members" class="panel-collapse collapse in">
					      <div class="panel-body">
					        <?php 
					        if (isset($members)) {
					        	if ($members->num_rows() > 0) {
						        	foreach ($members->result() as $item) {
						        		echo anchor('site/customizes/each-member/'.$item->pass_id, ucwords($item->pass_fname." ".$item->pass_lname));
						    		}
						    	}
					        } else {
					        	echo "No member(s) added for this booking.";
					        }
					        ?>
					      </div>
					    </div>
					  </div>
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
				echo anchor("site/customizes/payments"," Next ", array('role'=>'button', 'class'=>'btn btn-primary btn-sm'));
				echo nbs();
				echo anchor(
					"#", 
					"Add info all passengers!", 
					"class='btn btn-success btn-sm' data-target='.addmorepassenger' data-toggle='modal'"
					); 
			}
			?>
<p></p>
<?php echo form_close(); ?>
</div>
<!-- End Div control form Personal Information -->
