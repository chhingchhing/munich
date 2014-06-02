<!-- start accommodation -->
<?php
$option[] = "-- Select --";
for ($i=1; $i <= $this->session->userdata("people"); $i++) {
	$option[$i] = "$i Room(s), $i Guest(s)";
}

$double_room_1bed[] = "-- Select --";
for ($i=1; $i <= $this->session->userdata("people")/2; $i++) {
	$double_room_1bed[$i] = "$i Room(s), ".($i * 2)." Guest(s)";
}

$double_room_2beds[] = "-- Select --";
for ($i=1; $i <= $this->session->userdata("people")/2; $i++) { 
	$double_room_2beds[$i] = "$i Room(s), ".($i * 2)." Guest(s)";
}
?>
<?php  echo form_open_multipart('site/customizes/accommodation', 'class="form-horizontal"'); ?>
	   <div class="col-sm-12 form-booking" id="accommodation">
	   		<h2>Choose Accommodation</h2>
	   		<hr>
	   		<div class="col-sm-12">
	   			<?php 
	   			echo form_hidden("amount_main_object", count($recordAccommodation));
	   			$accOrder = 0;
	   			foreach ($recordAccommodation as $acc) {
	   				$accOrder++;
	   				// Disable day of a week
		   			$daysOfWeekDisabled = '';
		   			if ($recordAccommodation[$accOrder-1]['sunday'] == 0) $daysOfWeekDisabled .= "0, ";
		   			if ($recordAccommodation[$accOrder-1]['monday'] == 0) $daysOfWeekDisabled .= "1, ";
		   			if ($recordAccommodation[$accOrder-1]['tuesday'] == 0) $daysOfWeekDisabled .= "2, ";
		   			if ($recordAccommodation[$accOrder-1]['wednesday'] == 0) $daysOfWeekDisabled .= "3, ";
		   			if ($recordAccommodation[$accOrder-1]['thursday'] == 0) $daysOfWeekDisabled .= "4, ";
		   			if ($recordAccommodation[$accOrder-1]['friday'] == 0) $daysOfWeekDisabled .= "5, ";
		   			if ($recordAccommodation[$accOrder-1]['saturday'] == 0) $daysOfWeekDisabled .= "6";
	   			?>
	   			<div class="col-sm-3">
	   				<?php 
			            $accomodation_img = array(
			            	'src' => 'user_uploads/thumbnail/original/'.$acc['pho_source'], 
			            	'alt' => 'accomodation',
			            	'class' => 'img-thumbnail images-dashboard',
			            	'title' => 'Accomodation'
			            );
			        ?>
			        <?php echo anchor('accommodation/list_record',img($accomodation_img)).br(1);?>
	   			</div>
	   			<div class="col-sm-9">
	   				<?php
	   					$accommodation = $this->general_lib->get_accommodation();
	   					$checked = false;
	   					if ($accommodation != '') {
	   						if (isset($accommodation[$acc['acc_id']])) {
	   							if ($accommodation[$acc['acc_id']] == $acc['acc_id']) {
			   						$checked = true;
			   					}
	   						}
	   					}
	   					
	   					$checkbox_accommodation = array(
	   						'value' => $acc['acc_id'], 
	   						'checked' => $checked, 
	   						'class' => 'check_main_element', 
	   						'name' => 'checkbox_accommodation[]', 
	   						'id' => "checkbox_accommodation"
	   					);
	   					?> 
	   				<h4 id="<?php echo "main_act_order_$accOrder"; ?>" order="<?php echo $accOrder; ?>">
	   					<?php echo form_checkbox($checkbox_accommodation).nbs(); ?>
	   					<?php echo $acc['clf_name'];?>
	   				</h4>
	   				<p><?php echo $acc['acc_bookingtext'];?></p>
	   				<div class="form-group">
				        <label class="col-sm-2 control-label">Check In :</label>
				        <div class="col-sm-4">
				            <?php
					            $start_date = date("Y-m-d");
				        		$check_in_date = $this->general_lib->get_checkin_date_accommodation();
				   				if ($check_in_date != '') { 
				   					if (isset($check_in_date[$accOrder-1])) {
				   						$start_date = $check_in_date[$accOrder-1];
				   					} else {
				   						$start_date = date('Y-m-d');
				   					}
			   					} else {
			   						$start_date = date('Y-m-d');
			   					}
			                    $checkIn = array(
			                    	'id'=>'start_date_'.$accOrder, 
			                    	'name' => 'checkIn[]', 
			                    	'class' => 'form-control checkin checkin_'.$accOrder,
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => $start_date, 
			                    	'checkin_attr'=>$acc['start_date'], 
			                    	'daysOfWeekDisabled'=>$daysOfWeekDisabled
			                    );
			                    echo form_input($checkIn);
			                ?>
						</div>
						<label class="col-sm-2 control-label">Check Out :</label>
						<div class="col-sm-4">
							<?php
								$end_date = date("Y-m-d");
				        		$check_out_date = $this->general_lib->get_checkout_date_accommodation();
				   				if ($check_out_date != '') { 
				   					if (isset($check_out_date[$accOrder-1])) {
				   						$end_date = $check_out_date[$accOrder-1];
				   					} else {
				   						$end_date = date('Y-m-d');
				   					}
			   					} else {
			   						$end_date = date('Y-m-d');
			   					}
			                    $checkOut = array(
			                    	'id'=>'end_date_'.$accOrder,
			                    	'name' => 'checkOut[]', 
			                    	'class' => 'form-control checkout',
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => $end_date, 
			                    	'checkout_attr'=>$acc['end_date']
			                    );
			                    echo form_input($checkOut);
				            ?>
				        </div>
			    	</div>
			    	<div class="form-group">
				        <label class="col-sm-3 control-label">Amount of Passenger :</label>
				        <div class="col-sm-3">
				        <?php 
			                $amount_people[0] = "-- Select --";
			                for ($i=1; $i <= $this->session->userdata("people"); $i++) { 
			                		$amount_people[$i] = $i;
			                }
			                $peopleSelect = $this->session->userdata("people") ? $this->session->userdata("people") : 0;
			                $amountPeopleAccommodation = $this->general_lib->get_people_accommodation();
			                
			                if ($amountPeopleAccommodation != '') {
			                	if (isset($amountPeopleAccommodation[$accOrder-1])) {
			                		$peopleSelect = $amountPeopleAccommodation[$accOrder-1];
			                	}
			                }
			                echo form_dropdown('peopleAccommodation[]', 
								$amount_people, 
								$peopleSelect, 
								'class="form-control people" id="get_amount_people_room"'
							);
				        ?>
				        </div>
			    	</div>
			    	<div class="form-group room_types">
				        <label class="col-sm-3 control-label">Single Room (1 Bed, 1 Guest):</label>
				        <div class="col-sm-9" id='single'>
				        	<?php 
				        	$single_selected = 0;
				        	$single_rooms = $this->general_lib->get_single_room_accommodation();
			                if ($single_rooms != '') {
			                	if (isset($single_rooms[$accOrder-1])) {
			                		$single_selected = $single_rooms[$accOrder-1];
			                	}
			                }
				        	echo form_dropdown("single[]", $option, $single_selected, "class='form-control room_types' id='single'");
				        	?>
				        </div>
			    	</div>
			    	<div class="form-group room_types">
				        <label class="col-sm-3 control-label"><?php echo $acc['rt_name'];?> Double Room (1 Bed, 2 Guests) :</label>
				        <div class="col-sm-9" id="double_room_1bed">
				        	<?php 
				        	$double1bed_selected = 0;
				        	$double1bed_rooms = $this->general_lib->get_double_room_1bed_accommodation();
			                if ($double1bed_rooms != '') {
			                	if (isset($double1bed_rooms[$accOrder-1])) {
			                		$double1bed_selected = $double1bed_rooms[$accOrder-1];
			                	}
			                }
				        	echo form_dropdown(
				        		"double_room_1 bed[]", 
				        		$double_room_1bed, 
				        		$double1bed_selected, 
				        		"class='form-control room_types' id='double_room_1bed'"
				        	);
				        	?>
				        </div>
			    	</div>
			    	<div class="form-group room_types">
				        <label class="col-sm-3 control-label">Double Room (2 Beds, 2 Guests) :</label>
				        <div class="col-sm-9" id="double_room_2beds">
				        	<?php 
				        	$double2beds_selected = 0;
				        	$double2beds_rooms = $this->general_lib->get_double_room_2beds_accommodation();
			                if ($double2beds_rooms != '') {
			                	if (isset($double2beds_rooms[$accOrder-1])) {
			                		$double2beds_selected = $double2beds_rooms[$accOrder-1];
			                	}
			                }
				        	echo form_dropdown(
				        		"double_room_2beds[]", 
				        		$double_room_2beds, 
				        		$double2beds_selected, 
				        		"class='form-control room_types' id='double_room_2beds'"
				        	);
				        	?>
				        </div>
			    	</div>
			    	<!-- <h3>Sub Accommodations</h3>
			    	<?php
			    		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
						$subAccommodation = mod_fecustomize::selectSubAccommodation($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $acc['acc_id']);
						$subaccommodation = array();
						if ($subAccommodation->num_rows() > 0) {
							foreach ($subAccommodation->result() as $subacc) {
								$recodeavaliable = site::convertDateToRangeSub($findate, $subacc->start_date, $subacc->end_date);	
								if ($recodeavaliable) {
									$avRecord = json_decode(json_encode($subacc), true);
									array_push($subaccommodation, $avRecord);
								}
							}
						}
				    ?>
			    	<?php foreach ($subaccommodation as $sub_accommodation) {?>
				    	<div class="col-sm-12">
				    		<div class="col-sm-3">
				   				<?php $customize_img = array(
					   				'src' => 'user_uploads/thumbnail/original/'.$sub_accommodation['pho_source'],
					   				'alt' => 'customize',
					   				'class' => 'img-thumbnail images-dashboard',
					   				'title' => 'Customize'
				   				);?>
					    		<?php echo img($customize_img).br(1);?>
				   			</div>
				   			<div class="col-sm-9">
				   				<label>
				   					<?php echo form_checkbox(array(
						   					'name' => 'checkbox_sub_accommodation[]', 
						   					'id' => 'checkbox_sub_accommodation', 
						   					'class' => 'check_sub_element'
					   					), 
				   						$sub_accommodation['acc_id']
				   					);?>   
				   					<?php echo $sub_accommodation['acc_name'];?>
				   				</label>
				   				<p><?php echo $sub_accommodation['acc_bookingtext']; ?></p>
				   			</div>
				   			<div class="clear_both"></div>
				    	</div>
			    	<?php }?> -->
				    	
				    	<h3>Extra Products</h3>
				    	<?php
				    		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
							$extraproduct = mod_feCustomize::selectExtraProductAccommodation($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $acc['acc_id']);
							$extra = array();
							if($extraproduct->num_rows() > 0){
								foreach($extraproduct->result() as $ep_acc){
									$recodeavaliable = site::convertDateToRangeSub($findate, $ep_acc->start_date, $ep_acc->end_date);				
									if($recodeavaliable){
										$avRecord = json_decode(json_encode($ep_acc), true); 
										array_push($extra, $avRecord);
									}
								}
							}
					    ?>
					    <?php foreach ($extra as $ep_result) {?>
						    <div class="col-sm-12">
					    		<div class="col-sm-3">
					   				<?php $extras = array('src' => 'user_uploads/thumbnail/original/'.$ep_result['pho_source'],'alt' => 'customize','class' => 'img-thumbnail images-dashboard','title' => 'Customize');?>
						    		<?php echo img($extras).br(1);?>
					   			</div>
					   			<div class="col-sm-7">
					   				<label>
					   					<?php 
					   					$checked = $this->session->userdata('extraactivity');
					   					$checkbox_extra = array('value' => $ep_result['ep_id'], 'checked' => !$checked ? false : true, 'class' => 'check_sub_element', 'name' => 'checkbox_extra[]', 'id' => 'checkbox_extra');
					   					echo form_checkbox($checkbox_extra);
					   					?>
					   					<?php echo $ep_result['ep_name'];?>
					   				</label>
					   				<p><?php echo $ep_result['ep_bookingtext']; ?></p>
					   			</div>
					   			<div class="col-sm-2">
					   				<label>Amount of Extra Product</label>
					   				<input type="text" name="amountextras[]" class="form-control amount_extras" />
					   				<?php ?>
					   			</div>
					   			<div class="clear_both"></div>
							</div>
						<?php } ?>
	   			</div>
	   			<?php }?>	
	   		</div> 			
	   		<?php echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-info btn-sm')); ?>
			<?php $input = array('name' => 'btnAccommodation', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
			<p></p>
	   </div> 
<?php echo form_close(); ?>
<!-- end accommodation -->