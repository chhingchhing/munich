<!-- start activity -->
<?php  echo form_open_multipart('site/customizes/activities', 'class="form-horizontal"'); ?>
	   <div class="col-sm-12 form-booking" id="activities">
	   		<h2>Choose Activity</h2>
	   		<hr>
	   		<?php 
	   		echo form_hidden("amount_main_activity", count($recordActivities));
	   		$actOrder = 0;
	   		foreach ($recordActivities as $rows){ 
	   			$actOrder++;
	   			// Disable day of a week
	   			$daysOfWeekDisabled = '';
	   			if ($recordActivities[$actOrder-1]['sunday'] == 0) $daysOfWeekDisabled .= "0, ";
	   			if ($recordActivities[$actOrder-1]['monday'] == 0) $daysOfWeekDisabled .= "1, ";
	   			if ($recordActivities[$actOrder-1]['tuesday'] == 0) $daysOfWeekDisabled .= "2, ";
	   			if ($recordActivities[$actOrder-1]['wednesday'] == 0) $daysOfWeekDisabled .= "3, ";
	   			if ($recordActivities[$actOrder-1]['thursday'] == 0) $daysOfWeekDisabled .= "4, ";
	   			if ($recordActivities[$actOrder-1]['friday'] == 0) $daysOfWeekDisabled .= "5, ";
	   			if ($recordActivities[$actOrder-1]['saturday'] == 0) $daysOfWeekDisabled .= "6";

	   			$day_avaliable['monday'] 	= $rows['monday'];
                $day_avaliable['tuesday'] 	= $rows['tuesday'];
                $day_avaliable['wednesday'] = $rows['wednesday'];
                $day_avaliable['thursday'] 	= $rows['thursday'];
                $day_avaliable['friday'] 	= $rows['friday'];
                $day_avaliable['saturday'] 	= $rows['saturday'];
                $day_avaliable['sunday'] 	= $rows['sunday'];
            	$new = site::convertDateToRangeFromFE($day_avaliable, $rows['start_date'], $rows['end_date']);

	   			?> 				
	   			<div class="col-sm-3">
	   				<?php $customize_img = array(
		   				'src' => 'user_uploads/thumbnail/original/'.$rows['pho_source'],
		   				'alt' => 'customize',
		   				'class' => 'img-thumbnail images-dashboard',
		   				'title' => 'Customize'
		   			);?>
		    		<?php echo img($customize_img).br(1);?>
	   			</div>
	   			<div class="col-sm-9">
	   				<h4 id="<?php echo "main_act_order_$actOrder"; ?>" order="<?php echo $actOrder; ?>">
	   					<?php
	   					$mainactivity = $this->general_lib->get_main_activities();
	   					$checked = false;
	   					if ($mainactivity != '') {
	   						if (isset($mainactivity[$rows['act_id']])) {
	   							if ($mainactivity[$rows['act_id']] == $rows['act_id']) {
			   						$checked = true;
			   					}
	   						}
	   					}
	   					
	   					$checkbox_activity = array(
	   						'value' => $rows['act_id'], 
	   						'checked' => $checked, 
	   						'class' => 'check_main_element', 
	   						'name' => 'checkbox_activity[]', 
	   						'id' => "checkbox_main_activity"
	   					);
	   					echo form_checkbox($checkbox_activity).nbs();
	   					echo $rows['act_name'];
	   					?> 
	   				</h4>
	   				<p><?php echo $rows['act_bookingtext'];?></p>
			    	<div class="form-group">
				        <label class="col-sm-2 control-label">From Date :</label>
				        <div class="col-sm-4">
			        		<?php
			                    $txtFrom = array(
			                    	'id'=>'start_date_'.$actOrder, 
			                    	'name' => 'txtFrom', 
			                    	'class' => 'form-control checkin checkin_'.$actOrder,
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => date("Y-m-d"), 
			                    	'checkin_attr'=>$rows['start_date'], 
			                    	'daysOfWeekDisabled'=>$daysOfWeekDisabled
			                    );
			                    echo form_input($txtFrom);
			                ?>
						</div>
						<label class="col-sm-2 control-label">To Date :</label>
						<div class="col-sm-4">
							<?php
			                    $txtTo = array(
			                    	'id'=>'end_date_'.$actOrder,
			                    	'name' => 'txtTo', 
			                    	'class' => 'form-control checkout',
			                    	'data-date-format'=>'yyyy-mm-dd',
			                    	'value' => date("Y-m-d"), 
			                    	'checkout_attr'=>$rows['end_date']
			                    );
			                    echo form_input($txtTo);
				            ?>
				        </div>
			    	</div>
			    	<div class="form-group">
				        <label class="col-sm-4 control-label">Number of Passenger :</label>
				        <div class="col-sm-4">
				            <?php 
			                $amount_people[0] = "-- Select --";
			                for ($i=1; $i <= $this->session->userdata("people"); $i++) { 
			                		$amount_people[$i] = $i;
			                }
			                $amountPeopleMainActivity = $this->general_lib->get_people_main_activity();
			                if ($amountPeopleMainActivity != '') {
			                	if ($amountPeopleMainActivity[$actOrder-1]) {
			                		echo form_dropdown('actPeopleMainActivity[]', $amount_people, $amountPeopleMainActivity[$actOrder-1], 'class="form-control"');
			                	}
			                } else {
							echo form_dropdown('actPeopleMainActivity[]', $amount_people, $this->session->userdata("people") ? $this->session->userdata("people") : 0, 'class="form-control"');
			                }
				            ?>
				        </div>
				    </div>
				    <h3>Sub Activities</h3>
				    <?php
				    		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
							$subActivity = mod_feCustomize::selectSubActivity($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $rows['act_id']);
							$subactivity = array();
							if($subActivity->num_rows() > 0){
								foreach($subActivity->result() as $subact){
									$recodeavaliable = site::convertDateToRangeSub($findate, $subact->start_date, $subact->end_date);				
									if($recodeavaliable){
										$avRecord = json_decode(json_encode($subact), true); 
										array_push($subactivity, $avRecord);
									}
								}
							}
				    ?>
				    	<?php 
				    	$subActOrder = 0;
				    	foreach ($subactivity as $sub_activity) {
				    		$subActOrder++;
				    		?>
					    	<div class="col-sm-12">
					    		<div class="col-sm-3">
					   				<?php $customize_img = array(
						   				'src' => 'user_uploads/thumbnail/original/'.$sub_activity['pho_source'],
						   				'alt' => 'customize',
						   				'class' => 'img-thumbnail images-dashboard',
						   				'title' => 'Customize'
					   				);?>
						    		<?php echo img($customize_img).br(1);?>
					   			</div>
					   			<div class="col-sm-9">
					   				<label>
					   					<?php 
					   					$subactivity = $this->general_lib->get_sub_activities();
					   					$checked = false;
					   					if ($subactivity != '') { 
					   						if (isset($subactivity[$sub_activity['act_id']])) {
					   							if ($subactivity[$sub_activity['act_id']] == $sub_activity['act_id']) {
							   						$checked = true;
							   					}
					   						}
					   					}

					   					$checkbox_subactivity = array(
					   						'value' => $sub_activity['act_id'], 
					   						'checked' => $checked, 
					   						'class' => 'check_sub_element', 
					   						'name' => 'checkbox_subactivity[]', 
					   						'id' => 'checkbox_subactivity'
					   					);
					   					echo form_checkbox($checkbox_subactivity);
					   					?>   
					   					<?php echo $sub_activity['act_name'];?>
					   				</label>
					   				<p><?php echo $sub_activity['act_bookingtext']; ?></p>
					   			</div>
					    	</div>
					    	<div class="form-group">
						      <label class="col-sm-4 control-label">Number of Passenger :</label>
					        <div class="col-sm-4">
					        	<?php 
					            $amount_people[0] = "-- Select --";
				                for ($i=1; $i <= $this->session->userdata("people"); $i++) { 
				                		$amount_people[$i] = $i;
				                }
				                $amountPeople = $this->general_lib->get_people_sub_activity();
				                if ($amountPeople != '') {
				                	if ($amountPeople[$subActOrder-1]) {
				                		echo form_dropdown('actPeopleSubActivity[]', $amount_people, $amountPeople[$subActOrder-1], 'class="form-control people_sub_activity" id="subPeople"');
				                	}
				                } else {
								echo form_dropdown('actPeopleSubActivity[]', $amount_people, 0, 'class="form-control people_sub_activity" id="subPeople"');
				                }
					            ?>
					        </div>
						    </div>
				    	<?php }?> 
				    	<h3>Extra Products</h3>
				    <?php
			    		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
						$extraproduct = mod_feCustomize::selectExtraProductActivity($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $rows['act_id']);
						//var_dump($extraproduct->result());
						$extra = array();
						if($extraproduct->num_rows() > 0){
							foreach($extraproduct->result() as $ep_result){
								$recodeavaliable = site::convertDateToRangeSub($findate, $ep_result->start_date, $ep_result->end_date);				
								if($recodeavaliable){
									$avRecord = json_decode(json_encode($ep_result), true); 
									array_push($extra, $avRecord);
								}
							}
						}
				    ?>
				    <?php 
				    $extraOrder = 0;
				    foreach ($extra as $ep_result) {?>
				    <?php $extraOrder++; ?>
					    <div class="col-sm-12">
				    		<div class="col-sm-3">
				   				<?php $extras = array(
					   				'src' => 'user_uploads/thumbnail/original/'.$ep_result['pho_source'],
					   				'alt' => 'customize',
					   				'class' => 'img-thumbnail images-dashboard',
					   				'title' => 'Customize'
				   				);?>
					    		<?php echo img($extras).br(1);?>
				   			</div>
				   			<div class="col-sm-7">
				   				<label>
				   					<?php 
				   					$extra_activity = $this->general_lib->get_extra_activities();
				   					$checked = false;
				   					if ($extra_activity != '') { 
				   						if (isset($extra_activity[$ep_result['ep_id']])) {
				   							if ($extra_activity[$ep_result['ep_id']] == $ep_result['ep_id']) {
						   						$checked = true;
						   					}
				   						}
				   					}

				   					$checkbox_extra = array(
				   						'value' => $ep_result['ep_id'], 
				   						'checked' => $checked, 
				   						'class' => 'check_sub_element', 
				   						'name' => 'checkbox_extra[]', 
				   						'id' => 'checkbox_extra'
				   					);
				   					echo form_checkbox($checkbox_extra);
				   					?>
				   					<?php echo $ep_result['ep_name'];?>
				   				</label>
				   				<p><?php echo $ep_result['ep_bookingtext']; ?></p>
				   			</div>
				   			<div class="col-sm-2">
				   				<label>Amount of Extra Product</label>
				   				<?php
				   				$amountextras = $this->general_lib->get_amount_extra();
				   				if ($amountextras != '') { 
				   					if ($amountextras[$extraOrder-1]) {
				   						$input = array(
				   							"name"=>"amountextras[]",
				   							"class"=>"form-control amount_extras", 
				   							"value"=>$amountextras[$extraOrder-1]
				   						);
					   					echo form_input($input);
				   					} else {
				   						$input = array("name"=>"amountextras[]", "class"=>"form-control amount_extras");
					   					echo form_input($input);
				   					}
			   					} else {
			   						$input = array("name"=>"amountextras[]", "class"=>"form-control amount_extras");
					   				echo form_input($input);
			   					}
				   				
				   				?>
				   			</div>
				   			<div class="clear_both"></div>
						</div>
					<?php } ?>
	   				</div>
	   			<?php }?>
	   			<?php echo anchor("site/customizes/","Previous", array('role'=>'button', 'class'=>'btn btn-info btn-sm')); ?>
	   			<?php $input = array('name' => 'btnActivity', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>	   			   			   						
	   		<p></p>		
	   </div>
<?php echo form_close(); ?>
<!-- end activity -->