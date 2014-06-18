<?php  echo form_open_multipart('site/customizes/transportation', 'class="form-horizontal"'); ?>
<div class="col-sm-12 form-booking" id="transportation">
	<h2> Choose Transportation </h2>
	<hr>
	   		<div class="col-sm-12">
	   			<?php 
	   			echo form_hidden("amount_main_object", count($recordTransportation));
	   			$transOrder = 0;
	   			foreach ($recordTransportation as $tp_record) {
	   				$transOrder++;
	   				// Disable day of a week
		   			$daysOfWeekDisabled = '';
		   			if ($recordTransportation[$transOrder-1]['sunday'] == 0) $daysOfWeekDisabled .= "0, ";
		   			if ($recordTransportation[$transOrder-1]['monday'] == 0) $daysOfWeekDisabled .= "1, ";
		   			if ($recordTransportation[$transOrder-1]['tuesday'] == 0) $daysOfWeekDisabled .= "2, ";
		   			if ($recordTransportation[$transOrder-1]['wednesday'] == 0) $daysOfWeekDisabled .= "3, ";
		   			if ($recordTransportation[$transOrder-1]['thursday'] == 0) $daysOfWeekDisabled .= "4, ";
		   			if ($recordTransportation[$transOrder-1]['friday'] == 0) $daysOfWeekDisabled .= "5, ";
		   			if ($recordTransportation[$transOrder-1]['saturday'] == 0) $daysOfWeekDisabled .= "6";
	   			?>
	   			<div class="col-sm-3">
	   				<?php $transportation = array(
	   					'src' => 'user_uploads/thumbnail/original/'.$tp_record['pho_source'],
	   					'alt' => 'customize',
	   					'class' => 'img-thumbnail images-dashboard',
	   					'title' => 'Customize'
	   					);
	   				?>
		    		<?php echo img($transportation);?>
	   			</div>
	   			<div class="col-sm-9">
	   				<?php 
	   					$transportation = $this->general_lib->get_transportation();
	   					$checked = false;
	   					if ($transportation != '') {
	   						if (isset($transportation[$tp_record['tp_id']])) {
	   							if ($transportation[$tp_record['tp_id']] == $tp_record['tp_id']) {
			   						$checked = true;
			   					}
	   						}
	   					}
	   					
	   					$checkbox_transportation = array(
	   						'value' => $tp_record['tp_id'], 
	   						'checked' => $checked, 
	   						'class' => 'check_main_element', 
	   						'name' => 'checkbox_transportation['.$tp_record['tp_id'].']', 
	   						'id' => "checkbox_transportation"
	   					);
	   					echo form_checkbox($checkbox_transportation);
	   				?>   
	   				<label><?php echo $tp_record['tp_name'];?></label>
	   				<p><?php echo $tp_record['tp_textbooking'];?></p>
	   				<div class="form-group">
				        <label class="col-sm-2 control-label">Departure Date :</label>
				        <div class="col-sm-4">
				            <?php
				            	$start_date = date("Y-m-d");
				        		$departure_date = $this->general_lib->get_departure_transportation();
				   				if ($departure_date != '') { 
				   					if (isset($departure_date[$tp_record['tp_id']])) {
				   						$start_date = $departure_date[$tp_record['tp_id']];
				   					}
			   					}
			                    $departure = array(
			                    	'id'=>'start_date_'.$transOrder, 
			                    	'name' => 'trans_departure['.$tp_record['tp_id'].']', 
			                    	'class' => 'form-control checkin checkin_'.$transOrder,
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => $start_date, 
			                    	'checkin_attr'=>$tp_record['start_date'], 
			                    	'daysOfWeekDisabled'=>$daysOfWeekDisabled
			                    );
			                    echo form_input($departure);
				            ?>
				        </div>
				        <label class="col-sm-2 control-label">Return Date :</label>
				        <div class="col-sm-4">
				            <?php 
				            $end_date = date("Y-m-d");
				        		$return_date = $this->general_lib->get_return_date_transportation();
				   				if ($return_date != '') { 
				   					if (isset($return_date[$tp_record['tp_id']])) {
				   						$end_date = $return_date[$tp_record['tp_id']];
				   					}
			   					}
			                    $return = array(
			                    	'id'=>'end_date_'.$transOrder, 
			                    	'name' => 'trans_return['.$tp_record['tp_id'].']', 
			                    	'class' => 'form-control checkout',
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => $end_date, 
			                    	'checkin_attr'=>$tp_record['end_date'], 
			                    	'daysOfWeekDisabled'=>$daysOfWeekDisabled
			                    );
			                    echo form_input($return);
				            ?>
				        </div>
			    	</div>
			    	<div class="form-group">
				        <label class="col-sm-4 control-label">Amount of Seat :</label>
				        <div class="col-sm-3">
				        <?php
				        	$amount_people[0] = "-- Select --";
			                for ($i=1; $i <= $this->session->userdata("people"); $i++) { 
			                		$amount_people[$i] = $i;
			                }
			                $peopleSelect = $this->session->userdata("people") ? $this->session->userdata("people") : 0;
			                $amountPeopleTransport = $this->general_lib->get_people_transportation();
			                if ($amountPeopleTransport != '') {
			                	if (isset($amountPeopleTransport[$tp_record['tp_id']])) {
			                		foreach ($amountPeopleTransport[$tp_record['tp_id']] as $amount) {
			                			$peopleSelect = $amount;
			                		}
			                	}
			                }
			                echo form_dropdown('peopleTransportation['.$tp_record['tp_id'].'][]', 
								$amount_people, 
								$peopleSelect, 
								'class="form-control people" id="amount_people_transport"'
							);
				        ?>
				        </div>
			    	</div>
			    	<!--<h3>Sub Transportations</h3>
			    	<?php
				    		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
							$subTransportation = mod_feCustomize::selectSubTransportation($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $tp_record['tp_id']);
							$subtransportation = array();
							if($subTransportation->num_rows() > 0){
								foreach($subTransportation->result() as $subtp){
									$recodeavaliable = site::convertDateToRangeSub($findate, $subtp->start_date, $subtp->end_date);				
									if($recodeavaliable){
										$avRecord = json_decode(json_encode($subtp), true); 
										array_push($subtransportation, $avRecord);
									}
								}
							}
				    ?>	
				    <?php 
				    $subActOrder = 0;
				    foreach ($subtransportation as $sub_transportation) {
				    	$subActOrder++;
				    ?>   	
			    	<div class="form-group">
			    		<div class="col-sm-3">
			    			<?php $transportation = array(
			    				'src' => 'user_uploads/thumbnail/original/'.$sub_transportation['pho_source'],
			    				'alt' => 'customize',
			    				'class' => 'img-thumbnail images-dashboard',
			    				'title' => 'Customize'
			    				);
			    			?>
		    				<?php echo img($transportation);?>
			    		</div>
			    		<div class="col-sm-6">
			    			<label> 
			    				<?php 
				   					$subTrans = $this->general_lib->get_sub_transportation();
				   					$checked = false;
				   					if ($subTrans != '') { 
				   						if (isset($subTrans[$tp_record['tp_id']])) {
				   							foreach ($subTrans[$tp_record['tp_id']] as $item) {
			   									if ($item == $sub_transportation['tp_id']) {
							   						$checked = true;
							   					}
				   							}
				   						}
				   					}

				   					$checkbox_subTrans = array(
				   						'value' => $sub_transportation['tp_id'], 
				   						'checked' => $checked, 
				   						'class' => 'check_sub_element checkbox_sub_trans', 
				   						'name' => 'checkbox_subTrans['.$tp_record['tp_id'].']['.$sub_transportation['tp_id'].']', 
				   						'id' => 'checkbox_sub_trans_'.$subActOrder,
				   						'order' => $subActOrder
				   					);
				   					echo form_checkbox($checkbox_subTrans);
				   				?> 
			    				<?php echo $sub_transportation['tp_name'];?>
			    			</label>
	   						<p><?php echo $sub_transportation['tp_textbooking'];?></p>
			    		</div>
			    		<div class="col-sm-3">
			    			<label class="col-sm-3 control-label">N/Passenger:</label>
			    				<?php
						        	$amount_people[0] = "-- Select --";
					                for ($i=1; $i <= $this->session->userdata("people"); $i++) { 
					                	$amount_people[$i] = $i;
					                }
					                $peopleSelect = $this->session->userdata("people") ? $this->session->userdata("people") : 0;
					                $amountPeopleSubTransport = $this->general_lib->get_people_sub_transportation();
					                if ($amountPeopleSubTransport != '') {
					                	if (isset($amountPeopleSubTransport[$sub_transportation['tp_id']])) {
					                		foreach ($amountPeopleSubTransport[$sub_transportation['tp_id']] as $amount) {
					                			$peopleSelect = $amount;
					                		}
					                	}
					                }
					                echo form_dropdown('peopleSubTransportation['.$sub_transportation['tp_id'].'][]', 
										$amount_people, 
										$peopleSelect, 
										'class="form-control col-sm-4 people" id="amount_sub_people_transport"'
									);
						        ?>
			    		</div>
			    		<div class="clear_both"></div>
			    	</div>
			    	<?php }?>-->
			    	<h3>Extra Products</h3>
				    	<?php
				    		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
							$extraproduct = mod_feCustomize::selectExtraProductTransportation($this->session->userdata('ftvID'), $tp_record['tp_id']);
							$extra = array();
							if($extraproduct->num_rows() > 0){
								foreach($extraproduct->result() as $ep_tp){
									$recodeavaliable = site::convertDateToRangeSub($findate, $ep_tp->start_date, $ep_tp->end_date);				
									if($recodeavaliable){
										$avRecord = json_decode(json_encode($ep_tp), true); 
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
					   					$sub_trans_extra_pro = $this->general_lib->get_sub_trans_extr_product();
					   					$checked = false;
					   					if ($sub_trans_extra_pro != '') { 
					   						if (isset($sub_trans_extra_pro[$tp_record['tp_id']])) {
					   							foreach ($sub_trans_extra_pro[$tp_record['tp_id']] as $item) {
				   									if ($item == $ep_result['ep_id']) {
								   						$checked = true;
								   					}
					   							}
					   						}
					   					}

					   					$checkbox_sub_trans = array(
					   						'value' => $ep_result['ep_id'], 
					   						'checked' => $checked, 
					   						'class' => 'check_sub_element checkbox_subactivity', 
					   						'name' => 'sub_trans_extra_product['.$tp_record['tp_id'].']['.$ep_result['ep_id'].']', 
					   						'id' => 'checkbox_subactivity_'.$accExtraOrder,
					   						'order' => $accExtraOrder
					   					);
					   					echo form_checkbox($checkbox_sub_trans);
					   					?>
					   					<?php echo $ep_result['ep_name'];?>
					   				</label>
					   				<p><?php echo $ep_result['ep_bookingtext']; ?></p>
					   			</div>
					   			<div class="col-sm-2">
					   				<label>Amount of Extra Product</label>
					   				<?php 
						   				$value = "";
						   				$amountExtras = $this->general_lib->get_sub_trans_amount_extra();
						   				if ($amountExtras != '') {
						   					if (isset($amountExtras[$tp_record['tp_id']][$ep_result['ep_id']])) {
						   						$value = $amountExtras[$tp_record['tp_id']][$ep_result['ep_id']];
						   					}
						   				}

					   					$input = array(
					   							"name"=>"amountTransExtras[".$tp_record['tp_id']."][".$ep_result['ep_id']."]",
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
	   		<?php echo anchor("site/customizes/accommodation","Previous", array('role'=>'button', 'class'=>'btn btn-default btn-sm')); ?>
			<?php $input = array('name' => 'btnTransportation', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
			<p></p>
			<?php echo form_close(); ?>
</div>