<!-- start accommodation -->
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

	   			<div id="feedback_bar"></div>

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
	   						'name' => 'checkbox_accommodation['.$acc['acc_id'].']', 
	   						'id' => "checkbox_accommodation"
	   					);
	   					?> 
	   				<h4 class="fe_customize" id="<?php echo "main_act_order_$accOrder"; ?>" order="<?php echo $accOrder; ?>">
	   					<?php echo form_checkbox($checkbox_accommodation).nbs(); ?>
	   					<?php echo $acc['clf_name'];?>
	   				</h4>
	   				<p><strong>Desc:</strong> <?php echo $acc['acc_bookingtext'];?></p>
	   				<div class="form-group">
				        <label class="col-sm-2 control-label">Check In :</label>
				        <div class="col-sm-4">
				            <?php
					            $start_date = date("Y-m-d");
					            $class = '';
				        		$check_in_date = $this->general_lib->get_checkin_date_accommodation();
				   				if ($check_in_date != '') { 
				   					if (isset($check_in_date[$acc['acc_id']])) {
				   						$start_date = $check_in_date[$acc['acc_id']];
				   						$class = 'date-accomm';
				   					}
			   					}
			                    $checkIn = array(
			                    	'id'=>'start_date_'.$accOrder, 
			                    	'name' => 'checkIn['.$acc['acc_id'].']', 
			                    	'class' => "form-control checkin checkin_$accOrder $class date_in",
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => $start_date, 
			                    	'checkin_attr'=>$acc['start_date'], 
			                    	'daysOfWeekDisabled'=>$daysOfWeekDisabled,
			                    	'accommodation_id' => $acc['acc_id'],
			                    	'classification_id' => $acc['classification_id'],
			                    	'hotel_id' => $acc['dhht_id']
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
				   					if (isset($check_out_date[$acc['acc_id']])) {
				   						$end_date = $check_out_date[$acc['acc_id']];
				   						$class = 'date-accomm-chk-out';
				   					}
			   					}
			                    $checkOut = array(
			                    	'id'=>'end_date_'.$accOrder,
			                    	'name' => 'checkOut['.$acc['acc_id'].']', 
			                    	'class' => "form-control checkout $class date_out",
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => $end_date, 
			                    	'checkout_attr'=>$acc['end_date'],
			                    	'accommodation_id' => $acc['acc_id'],
			                    	'classification_id' => $acc['classification_id'],
			                    	'hotel_id' => $acc['dhht_id']
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
			                	if (isset($amountPeopleAccommodation[$acc['acc_id']])) {
			                		$peopleSelect = $amountPeopleAccommodation[$acc['acc_id']];
			                	}
			                }
			                echo form_dropdown('peopleAccommodation['.$acc['acc_id'].'][]', 
								$amount_people, 
								$peopleSelect, 
								'class="form-control people" id="get_amount_people_room"'
							);
				        ?>
				        </div>
			    	</div>
			    	<div class='form-group'>
			    		<label class="col-sm-4 control-label">List of accommodation offering :</label>
			    	</div>

			    <div id="room_offering_<?php echo $acc['acc_id']; ?>">
			    	<?php 
			        $hotels = $this->mod_fecustomize->getAllHotels($acc['classification_id']);
			        $htOrder = 0;
			        foreach ($hotels->result() as $hotel) {
			        	$detail_hotels =  $this->mod_fecustomize->getHotelDetailByHotelIDAndClassification($acc['classification_id'], $hotel->dhht_id)->result();
			        	$htOrder++;
			        	?>
			    	<div class="form-group room_types col-sm-12">
				        <div class="col-sm-12">
				        	<div class="panel-group" id="accordion">
							  <div class="panel panel-success">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#roomType_<?php echo $htOrder; ?>">
							        	<span class="icon icon-home"></span> 
							          Offer <?php echo $htOrder; ?><span class="caret"></span>
							        </a>
							      </h4>
							    </div>
							    <div id="roomType_<?php echo $htOrder; ?>" class="panel-collapse collapse in">
							      <div class="panel-body">
							        <?php 
							        foreach ($detail_hotels as $item) {
							        	?>
							        	<div class='row'>
							        		<div class="col-xs-9">
							        			<span>
									        		<?php 
									        		$rooms = $this->general_lib->get_room_type_accommodation();
								   					$checked = false;
								   					if ($rooms != '') {
								   						if (isset($rooms[$acc['acc_id']])) {
								   							foreach ($rooms[$acc['acc_id']] as $rm_hotel) {
								   								foreach ($rm_hotel as $each_item) {
								   									if ($each_item == $item->rt_id) {
												   						$checked = true;
												   					}
								   								}
								   							}
								   						}
								   					}

								   					$amount_available = 0;
								   					$amount_rm_booked = $this->mod_fecustomize->getAmountRoomBooking($start_date, $end_date,$item->dhcl_id,$item->dhht_id,$item->dhrt_id);
								   					foreach ($amount_rm_booked->result() as $rm_book_obj) {
								   						$amount_booked = $rm_book_obj;
								   					}

								   					$actual_stock = $item->dhrm_originalstock;
								   					$num_booked = $amount_booked->amount_book;
													$amount_availabled = $actual_stock - $num_booked;

													$room_date_available = $this->mod_fecustomize->getRoomDateAvailable($start_date, $end_date, $item->dhrt_id, $item->dhht_id, $item->dhcl_id);
													if ($amount_availabled <= 0) {
														echo "<span class='require'>* </span>It will available from <span class='amount-room'>".$room_date_available."</span>, Amount room: <span class='amount-room'>".$item->dhrm_originalstock."</span><br/>";
													} else {
														echo "<span class='require'>* </span>It available <span class='amount-room'>today</span>, Amount room: <span class='amount-room'>".$amount_availabled."</span><br/>";
													}

													$room_type_checked = array(
								   						'value' => $item->rt_id, 
								   						'checked' => $checked, 
								   						'class' => 'check_main_element', 
								   						'name' => 'room_type_checked['.$acc['acc_id'].']['.$item->dhht_id.']['.$item->rt_id.']', 
								   						'id' => "room_type_checked"
								   					);
									        		echo form_checkbox($room_type_checked);
									        		echo form_hidden('hotelIDs['.$acc['classification_id'].']['.$item->dhht_id.']', $item->dhht_id);
									        		echo nbs();
									        		echo $item->rt_name;
									        		echo nbs();
									        		echo '(Amount people per room: <spa class="amount-room">'.$item->rt_people_per_room.'</span>)';
									        		
									        		?>
									        	</span>
							        		</div>
								        	<div class="col-xs-3">
								        		<?php 
								        		$amount_rooms_booked = $this->general_lib->get_amount_book_room();
								        		$value = '';
								        		if (isset($amount_rooms_booked[$acc['acc_id']])) {
								        			foreach ($amount_rooms_booked[$acc['acc_id']] as $item_arra) {
									        			if (isset($item_arra[$acc['dhcl_id']][$item->rt_id])) {
									        				$value = $item_arra[$acc['dhcl_id']][$item->rt_id];
									        			}
									        		}
								        		}
								        		
								        		// if ($amount_availabled > 0) {
								        			$input = array(
									        			'name' => 'amount_book_room['.$acc['acc_id'].']['.$acc['dhht_id'].']['.$acc['dhcl_id'].']['.$item->rt_id.']',
									        			'class' => 'form-control input-sm theTooltip',
									        			'placeholder' => 'Amount Room',
									        			'value' => $value,
									        			'data-toggle' => 'tooltip',
									        			'data-placement' => 'top',
									        			'title' => 'Amount Room'
									        			);
									        		echo form_input($input); 
								        		// }
								        		
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
			    	<?php
					}
			        ?>
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
					   						if (isset($sub_acc_extra_pro[$acc['acc_id']])) {
					   							foreach ($sub_acc_extra_pro[$acc['acc_id']] as $item) {
				   									if ($item == $ep_result['ep_id']) {
								   						$checked = true;
								   					}
					   							}
					   						}
					   					}

					   					$checkbox_sub_acc = array(
					   						'value' => $ep_result['ep_id'], 
					   						'checked' => $checked, 
					   						'class' => 'check_sub_element checkbox_subactivity', 
					   						'name' => 'sub_acc_extra_product['.$acc['acc_id'].']['.$ep_result['ep_id'].']', 
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
					   					if ($amountExtras != '') {
						   					if (isset($amountExtras[$acc['acc_id']][$ep_result['ep_id']])) {
						   						$value = $amountExtras[$acc['acc_id']][$ep_result['ep_id']];
						   					}
						   				}

				   					$input = array(
				   							"name"=>"amountAccExtras[".$acc['acc_id']."][".$ep_result['ep_id']."]",
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
	   		<?php echo anchor("site/customizes/transportation","Previous", array('role' => 'button', 'class' => 'btn btn-default btn-sm')); ?>
			<?php $input = array('name' => 'btnAccommodation', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
			<p></p>
	   </div> 
<?php echo form_close(); ?>
<!-- end accommodation -->