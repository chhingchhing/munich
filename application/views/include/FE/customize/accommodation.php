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
	   				<h4 class="fe_customize" id="<?php echo "main_act_order_$accOrder"; ?>" order="<?php echo $accOrder; ?>">
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
				   					}
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
				        <label class="col-sm-2 control-label">Room :</label>
				        <div class="col-sm-10">
				        	<div class="panel-group" id="accordion">
							  <div class="panel panel-success">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#roomType_<?php echo $accOrder; ?>">
							          Room <span class="caret"></span>
							        </a>
							      </h4>
							    </div>
							    <div id="roomType_<?php echo $accOrder; ?>" class="panel-collapse collapse">
							      <div class="panel-body">
							        <?php 
							        foreach ($room_types->result() as $item) {
							        	?>
							        	<div class='row'>
							        		<div class="col-xs-10">
							        			<span>
									        		<?php 
									        		$rooms = $this->general_lib->get_room_type_accommodation();
								   					$checked = false;
								   					if ($rooms != '') {
								   						if (isset($rooms[$item->rt_id])) {
								   							if ($rooms[$item->rt_id] == $item->rt_id) {
										   						$checked = true;
										   					}
								   						}
								   					}
									        		$room_type_checked = array(
								   						'value' => $item->rt_id, 
								   						'checked' => $checked, 
								   						'class' => 'check_main_element', 
								   						'name' => 'room_type_checked['.$item->rt_id.']', 
								   						'id' => "room_type_checked"
								   					);
									        		echo form_checkbox($room_type_checked);
									        		echo nbs();
									        		echo $item->rt_name;
									        		echo nbs(5);
									        		echo '(Amount people per room: '.$item->rt_people_per_room.')';
									        		?>
									        	</span>
							        		</div>
								        	<div class="col-xs-2">
								        		<?php 
								        		$amount_rooms_booked = $this->general_lib->get_amount_book_room();
								        		$value = '';
								        		if (isset($amount_rooms_booked[$item->rt_id])) {
								        			$value = $amount_rooms_booked[$item->rt_id];
								        		}
								        		$input = array(
								        			'name' => 'amount_book_room['.$item->rt_id.']',
								        			'class' => 'form-control input-sm',
								        			'value' => $value
								        			);
								        		echo form_input($input); 
								        		?>
								        	</div>
							        	</div>
							        	<?php
							        }
							        ?>
							      </div>
							    </div>
							  </div>
							</div>
				        </div>
			    	</div>
			    	
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
					    <?php 
					    $accExtraOrder = 0;
					    foreach ($extra as $ep_result) {
					    	$accExtraOrder++;
					    ?>
						    <div class="col-sm-12">
					    		<div class="col-sm-3">
					   				<?php $extras = array('src' => 'user_uploads/thumbnail/original/'.$ep_result['pho_source'],'alt' => 'customize','class' => 'img-thumbnail images-dashboard','title' => 'Customize');?>
						    		<?php echo img($extras).br(1);?>
					   			</div>
					   			<div class="col-sm-7">
					   				<label>
					   					<?php 
					   					$sub_acc_extra_pro = $this->general_lib->get_sub_acc_extr_product();
					   					$checked = false;
					   					if ($sub_acc_extra_pro != '') { 
					   						if (isset($sub_acc_extra_pro[$ep_result['ep_id']])) {
					   							if ($sub_acc_extra_pro[$ep_result['ep_id']] == $ep_result['ep_id']) {
							   						$checked = true;
							   					}
					   						}
					   					}

					   					$checkbox_sub_acc = array(
					   						'value' => $ep_result['ep_id'], 
					   						'checked' => $checked, 
					   						'class' => 'check_sub_element checkbox_subactivity', 
					   						'name' => 'sub_acc_extra_product[]', 
					   						'id' => 'checkbox_subactivity_'.$accExtraOrder,
					   						'order' => $accExtraOrder
					   					);
					   					echo form_checkbox($checkbox_sub_acc);
					   				?> 
					   					<?php echo $ep_result['ep_name'];?>
					   				</label>
					   				<p><?php echo $ep_result['ep_bookingtext']; ?></p>
					   			</div>
					   			<div class="col-sm-2">
					   				<label>Amount of Extra Product</label>
					   				<?php
					   				$value = "";
					   				$amountExtras = $this->general_lib->get_sub_acc_amount_extra();
				   					if (isset($amountExtras[$ep_result['ep_id']])) {
					   					$main_value = $amountExtras[$ep_result['ep_id']["0"]];
					   					foreach ($main_value as $val) {
					   						$value = $val;
					   					}
					   				}

				   					$input = array(
				   							"name"=>"amountAccExtras[".$ep_result['ep_id']."][]",
				   							"class"=>"form-control amount_extras", 
				   							"value"=> $value
				   						);
				   					echo form_input($input);
					   				?>
					   			</div>
					   			<div class="clear_both"></div>
							</div>
						<?php } ?>
	   			</div>
	   			<?php }?>	
	   		</div> 			
	   		<?php echo anchor("site/customizes/activities","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
			<?php $input = array('name' => 'btnAccommodation', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
			<p></p>
	   </div> 
<?php echo form_close(); ?>
<!-- end accommodation -->