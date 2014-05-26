<!-- start activity -->
<?php  echo form_open_multipart('site/customizes/activities', 'class="form-horizontal"'); ?>
	   <div class="col-sm-12 form-booking" id="activities">
	   		<h2>Choose Activity</h2>
	   		<hr>
	   		<?php 
	   		$actID = 0;
	   		foreach ($recordActivities as $rows){ 
	   			$actID++;
	   			?> 				
	   			<div class="col-sm-3">
	   				<?php $customize_img = array('src' => 'user_uploads/thumbnail/original/'.$rows['pho_source'],'alt' => 'customize','class' => 'img-thumbnail images-dashboard','title' => 'Customize');?>
		    		<?php echo img($customize_img).br(1);?>
	   			</div>
	   			<div class="col-sm-9">
	   				<h4>
	   					<?php
	   					$mainactivity = $this->session->userdata('mainactivity');
	   					$checked = false;
	   					$checkbox_activity = array('value' => $rows['act_id'], 'checked' => $checked, 'class' => 'check_main_element', 'name' => 'checkbox_activity[]', 'id' => "checkbox_main_activity_$actID");
	   					echo form_checkbox($checkbox_activity);
	   					echo $rows['act_name'];
	   					?> 
	   				</h4>
	   				<p><?php echo $rows['act_bookingtext'];?></p>
			    	<div class="form-group">
				        <label class="col-sm-2 control-label">From Date :</label>
				        <div class="col-sm-4">
			        		<?php
			        			$day_avaliable['monday'] 		= $rows['monday'];
				                $day_avaliable['tuesday'] 		= $rows['tuesday'];
				                $day_avaliable['wednesday'] 	= $rows['wednesday'];
				                $day_avaliable['thursday'] 		= $rows['thursday'];
				                $day_avaliable['friday'] 		= $rows['friday'];
				                $day_avaliable['saturday'] 		= $rows['saturday'];
				                $day_avaliable['sunday'] 		= $rows['sunday'];
				            	$new = site::convertDateToRangeFromFE($day_avaliable, $rows['start_date'], $rows['end_date']);
			                    $txtFrom = array('id'=>'dp4' ,'name' => 'txtFrom', 'class' => 'form-control','data-date-format'=>'yyyy-mm-dd','style'=>'', 'value' => $this->session->userdata('txtFrom') ? $this->session->userdata('txtFrom') : "");
			                    echo form_input($txtFrom);
			                ?>
						</div>
						<label class="col-sm-2 control-label">To Date :</label>
						<div class="col-sm-4">
							<?php
			        			$day_avaliable['monday'] 	= $rows['monday'];
				                $day_avaliable['tuesday'] 	= $rows['tuesday'];
				                $day_avaliable['wednesday'] = $rows['wednesday'];
				                $day_avaliable['thursday'] 	= $rows['thursday'];
				                $day_avaliable['friday'] 	= $rows['friday'];
				                $day_avaliable['saturday'] 	= $rows['saturday'];
				                $day_avaliable['sunday'] 	= $rows['sunday'];
				            	$new = site::convertDateToRangeFromFE($day_avaliable, $rows['start_date'], $rows['end_date']);
			                    $txtTo = array('id'=>'dp5' ,'name' => 'txtTo', 'class' => 'form-control','data-date-format'=>'yyyy-mm-dd','style'=>'', 'value' => $this->session->userdata('txtTo') ? $this->session->userdata('txtTo') : "");
			                    echo form_input($txtTo);
				            ?>
				        </div>
			    	</div>
			    	<div class="form-group">
				        <label class="col-sm-4 control-label">Number of Passenger :</label>
				        <div class="col-sm-4">
				            <?php 
				            $arr_people_input = array(
				            	"name" => "actPeople",
				            	"class" => "form-control",
				            	"value" => $this->session->userdata("people") ? $this->session->userdata("people") : 0
				            	);
				            echo form_input($arr_people_input); 
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
				    	<?php foreach ($subactivity as $sub_activity) {?>
					    	<div class="col-sm-12">
					    		<div class="col-sm-3">
					   				<?php $customize_img = array('src' => 'user_uploads/thumbnail/original/'.$sub_activity['pho_source'],'alt' => 'customize','class' => 'img-thumbnail images-dashboard','title' => 'Customize');?>
						    		<?php echo img($customize_img).br(1);?>
					   			</div>
					   			<div class="col-sm-9">
					   				<label>
					   					<?php 
					   					$checked = $this->session->userdata('subactivity');
					   					$checkbox_subactivity = array('value' => $sub_activity['act_id'], 'checked' => !$checked ? false : true, 'class' => 'check_sub_element', 'name' => 'checkbox_subactivity[]', 'id' => 'checkbox_subactivity');
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
					            $arr_people_input = array(
					            	"name" => "actPeople",
					            	"class" => "form-control people_sub_activity",
					            	"value" => $this->session->userdata("people") ? $this->session->userdata("people") : 0
					            	);
					            echo form_input($arr_people_input); 
					            ?>
					        </div>
						    </div>
				    	<?php }?> 
				    	<h3>Extra Products</h3>
					    <?php
				    		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
							$extraproduct = mod_feCustomize::selectExtraProductActivity($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $rows['act_id']);
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
	   			<?php echo anchor("site/customizes/","Previous", array('role'=>'button', 'class'=>'btn btn-info btn-sm')); ?>
	   			<?php $input = array('name' => 'btnActivity', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>	   			   			   						
	   		<p></p>		
	   </div>
<?php echo form_close(); ?>
<!-- end activity -->