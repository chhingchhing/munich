<div class="panel-group" id="accordion">

  <!-- Start Personal Information -->
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#personal_info">
          Personal Info <?php echo ucwords($passenger_info->pass_fname.' '.$passenger_info->pass_lname); ?> <span class="caret"></span>
        </a>
      </h4>
    </div>
    <div id="personal_info" class="panel-collapse collapse in">
      <div class="panel-body">
      	<div id="each_personalInfo_feedback"></div>
      	<?php echo form_open_multipart('site/member_personal_info_customize_bk/'.$passenger_info->pass_id, 'class="form-horizontal" name="form_each_personal_info" '); ?>
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
	   			<div style='clear: both'></div>
	   		</div>
	   		<?php //echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
	   		<?php $input = array('name' => 'btnEachPersonalInfo', 'class' => 'btn btn-default btn-sm', 'value' => ' Save '); echo form_submit($input);?>
	   	<?php echo form_close(); ?>
      </div>
    </div>
  </div>





  <!-- Start Transportation -->
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#transportation">
          Transportation <span class="caret"></span>
        </a>
      </h4>
    </div>
    <div id="transportation" class="panel-collapse collapse">
      <div class="panel-body">
      	<div id="each_trans_feedback"></div>
      	<div class='col-sm-12'>
      		<div class="panel panel-info">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" href="#extra_transport">
			          Extra Product <span class="caret"></span>
			        </a>
			      </h4>
			    </div>
			    <div id="extra_transport" class="panel-collapse collapse in">
			      <div class="panel-body">
			      	<?php echo form_open_multipart('site/each_member_transportation/extra-pro', 'class="form-horizontal" name="form_each_trans_extra_pro" '); ?>
			      	<table class='table'>
			      		<tr>
			      			<th>Item</th>
			      			<th>Amount Book</th>
			      			<th>Yours</th>
			      		</tr>
			      	<?php 
				      	$extra_trans = $this->general_lib->get_sub_trans_extr_product();
				      	var_dump($extra_trans);
				      	if ($extra_trans != "") {
					      	foreach($extra_trans as $ep_id) {
					      		$exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
					      		$checkbox = array(
			   						'value' => $exact_info->ep_id, 
			   						'class' => 'each_subact', 
			   						'name' => 'each_subact['.$exact_info->ep_id.']'
			   					);
					      		?>
					      	<tr>
								<td><?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?></td>
								<td><?php 
								$amount_exta = $this->general_lib->get_sub_acc_amount_extra();
									$input = array(
										'value' => $amount_exta[$ep_id][0],
										'name' => 'amountTransExtras['.$ep_id.']',
										'class' => 'form-control input-sm'
										);
									echo form_input($input); 
									?>
								</td>
								<td>
									<?php 
									$inputYours = array(
										'name' => 'own_extra_amount['.$ep_id.'][]',
										'class' => 'form-control input-sm'
										);
									echo form_input($inputYours); 
									?>
								</td>
							</tr>
						<?php }
						} else {
							echo "No extra product.";
						} ?>
			      	</table>
			      	<?php //echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
			      	<?php $input = array('name' => 'btnEachTransportation', 'class' => 'btn btn-default btn-sm', 'value' => ' Save '); echo form_submit($input);?>
			      	<?php echo form_close(); ?>
			      </div>
			    </div>
			</div>
      	</div>
      </div>
    </div>
  </div>


  <!-- Start Accommodation -->
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#accommodation">
          Accommodation <span class="caret"></span>
        </a>
      </h4>
    </div>
    <div id="accommodation" class="panel-collapse collapse">
      <div class="panel-body">
	   	
      	<div class='col-sm-6'>
      		<div class="panel panel-info">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" href="#sub_acc">
			          Sub Accommodation <span class="caret"></span>
			        </a>
			      </h4>
			    </div>
			    <div id="sub_acc" class="panel-collapse collapse in">
			      <div class="panel-body">
			      	<?php echo form_open_multipart('site/customizes/personal-info', 'class="form-horizontal" name="form_each_acc" '); ?>
			      	<table class='table'>
			      		<tr>
				      		<th>Room</th>
				      		<th>Amount</th>
				      	</tr>
			      	<?php 
			      	$accom_roomtypes = $this->general_lib->get_room_type_accommodation();
			      	$amount_room_booked = $this->general_lib->get_amount_book_room();
			      	if ($accom_roomtypes != '') {
				      	foreach ($accom_roomtypes as $array_classf) {
				      		foreach ($array_classf as $roomsType) {
				      			foreach ($roomsType as $rtID) {
				      				$rooms = $this->mod_fecustomize->getAllRoomTypeEachPassenger($rtID)->result();
				      				foreach ($rooms as $item) {
							      		?>
							      	<tr>
										<td><?php echo $item->rt_name; ?></td>
										<td><?php echo $amount_room_booked[$item->rt_id]; ?></td>
									</tr>
							      		<?php
							      	}
				      			}
				      		}
				      	}
			      	} else {
			      		echo "No accommodation.";
			      	}
			      	?>
					</table>
					<?php //echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
					<?php $input = array('name' => 'btnEachSubAccommodation', 'class' => 'btn btn-default btn-sm', 'value' => ' Save '); echo form_submit($input);?>
					<?php echo form_close(); ?>
			      </div>
			    </div>
			</div>
      	</div>
      	<!-- Extra Product of Accommodation -->
      	<div class='col-sm-6'>
      		<div class="panel panel-info">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" href="#extra_acc">
			          Extra Product <span class="caret"></span>
			        </a>
			      </h4>
			    </div>
			    <div id="extra_acc" class="panel-collapse collapse in">
			      <div class="panel-body">
			      	<?php echo form_open_multipart('site/customizes/personal-info', 'class="form-horizontal" name="form_each_acc_extra_pro" '); ?>
			      	<table class='table'>
			      		<tr>
			      			<th>Item</th>
			      			<th>Amount</th>
			      		</tr>
			      	<?php 
			      	$extra_activities = $this->general_lib->get_sub_acc_extr_product();
			      	if ($extra_activities != "") {
				      	foreach($extra_activities as $ep_id) {
				      		$exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
				      		$checkbox = array(
		   						'value' => $exact_info->ep_id, 
		   						'class' => 'each_subact', 
		   						'name' => 'each_subact['.$exact_info->ep_id.']'
		   					);
				      		?>
				      	<tr>
							<td><?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?></td>
							<td><?php 
							$amount_exta = $this->general_lib->get_sub_acc_amount_extra();
								$input = array(
									'value' => $amount_exta[$ep_id][0],
									'name' => 'origin_extra',
									'class' => 'form-control input-sm'
									);
								echo form_input($input); 
								?>
							</td>
						</tr>
					<?php }
					} else {
						echo "No extra product.";
					} ?>
				</table>
				<?php //echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
				<?php $input = array('name' => 'btnEachSubAccExtraPro', 'class' => 'btn btn-default btn-sm', 'value' => ' Save '); echo form_submit($input);?>
				<?php echo form_close(); ?>
			      </div>
			    </div>
			</div>
      	</div>

      </div>
    </div>
  </div>


  <!-- Start Activities -->
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#activity">
          Activities <span class="caret"></span>
        </a>
      </h4>
    </div>
    <div id="activity" class="panel-collapse collapse">
      <div class="panel-body">
      	
      	<div class='col-sm-6'>
      		<div class="panel panel-info">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" href="#sub_activity">
			          Sub Activities <span class="caret"></span>
			        </a>
			      </h4>
			    </div>
			    <div id="sub_activity" class="panel-collapse collapse in">
			      <div class="panel-body">
			      	<?php echo form_open_multipart('site/customizes/personal-info', 'class="form-horizontal" name="form_each_act" '); ?>
			      	<table class='table'>
			      	<?php 
			      	$activities = $this->general_lib->get_sub_activities();
			      	if ($activities != '') {
			      	foreach($activities as $act_id) {
			      		$act_info = $this->mod_fecustomize->get_info_of_main_obj('activities', 'act_id', $act_id);
			      		$checkbox = array(
	   						'value' => $act_info->act_id, 
	   						'class' => 'each_subact', 
	   						'name' => 'each_subact['.$act_info->act_id.']'
	   					);
			      		?>
			      	<tr>
						<td><?php echo form_checkbox($checkbox). nbs(2). $act_info->act_name; ?></td>
						<td>There are only <?php $amountPeople = $this->general_lib->get_people_sub_activity(); echo $amountPeople[$act_info->act_id]; ?> member(s) for joining this action</td>
					</tr>
					<?php }
					} else {
						echo "No activities.";
					} ?>
					</table>
					<?php //echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
					<?php $input = array('name' => 'btnEachSubActivity', 'class' => 'btn btn-default btn-sm', 'value' => ' Save '); echo form_submit($input);?>
					<?php echo form_close(); ?>
			      </div>
			    </div>
			</div>
      	</div>
      	<!-- Extra Product -->
      	<div class='col-sm-6'>
      		<div class="panel panel-info">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" href="#extra_act">
			          Extra Product <span class="caret"></span>
			        </a>
			      </h4>
			    </div>
			    <div id="extra_act" class="panel-collapse collapse in">
			      <div class="panel-body">
			      	<?php echo form_open_multipart('site/customizes/personal-info', 'class="form-horizontal" name="form_each_act_extra_pro" '); ?>
			      	<table class='table'>
			      		<tr>
			      			<th>Item</th>
			      			<th>Amount</th>
			      		</tr>
			      	<?php 
			      	$extra_activities = $this->general_lib->get_extra_activities();
			      	if ($extra_activities != '') {
			      	foreach($extra_activities as $ep_id) {
			      		$exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
			      		$checkbox = array(
	   						'value' => $exact_info->ep_id, 
	   						'class' => 'each_subact', 
	   						'name' => 'each_subact['.$exact_info->ep_id.']'
	   					);
			      		?>
			      	<tr>
						<td><?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?></td>
						<td><?php 
						$amount_exta = $this->general_lib->get_amount_extra();
							$input = array(
								'value' => $amount_exta[$ep_id],
								'name' => 'origin_extra',
								'class' => 'form-control input-sm'
								);
							echo form_input($input); 
							?>
						</td>
					</tr>
					<?php }
					} else {
						echo "No extra product.";
					} ?>
				</table>
				<?php //echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
				<?php $input = array('name' => 'btnEachSubActExtraPro', 'class' => 'btn btn-default btn-sm', 'value' => ' Save '); echo form_submit($input);?>
				<?php echo form_close(); ?>
			      </div>
			    </div>
			</div>
      	</div>
      </div>
    </div>
  </div>


  <!-- Start Extra Services -->
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#extra_service">
          Extra Services <span class="caret"></span>
        </a>
      </h4>
    </div>
    <div id="extra_service" class="panel-collapse collapse">
      <div class="panel-body">

      	<!-- Extra Services -->
  		<div class="panel panel-info">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" href="#extra_services">
		          Extra Services <span class="caret"></span>
		        </a>
		      </h4>
		    </div>
		    <div id="extra_services" class="panel-collapse collapse in">
		      <div class="panel-body">
		      	<?php echo form_open_multipart('site/customizes/personal-info', 'class="form-horizontal" name="form_each_extra_service" '); ?>
		      	<table class='table'>
		      		<tr>
		      			<th>Item</th>
		      			<th>Amount</th>
		      		</tr>
		      	<?php 
		      	$extra_service = $this->general_lib->get_extra_services();
		      	if ($extra_service != "") {
		      	foreach($extra_service as $ep_id) {
		      		$exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
		      		$checkbox = array(
   						'value' => $exact_info->ep_id, 
   						'class' => 'each_extra_service', 
   						'name' => 'each_extra_service['.$exact_info->ep_id.']'
   					);
		      		?>
		      	<tr>
					<td><?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?></td>
					<td><?php 
					$amountExtras = $this->general_lib->get_num_extra_services();
						$input = array(
							'value' => $amountExtras[$ep_id][0],
							'name' => 'origin_extra_service',
							'class' => 'form-control input-sm'
							);
						echo form_input($input); 
						?>
					</td>
				</tr>
				<?php }
				} else {
					echo "No extra service.";
				} ?>
			</table>
			<?php //echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
			<?php $input = array('name' => 'btnEachExtrapService', 'class' => 'btn btn-default btn-sm', 'value' => ' Save '); echo form_submit($input);?>
			<?php echo form_close(); ?>
		      </div>
		    </div>
		</div>

      </div>
    </div>
  </div>

</div>