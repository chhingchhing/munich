<!-- start accommodation -->
<?php  echo form_open_multipart('site/customizes/accommodation', 'class="form-horizontal"'); ?>
	   <div class="col-sm-12 form-booking" id="accommodation">
	   		<h2>Choose Accommodation</h2>
	   		<hr>
	   		<div class="col-sm-12">
	   			<?php foreach ($recordAccommodation as $acc) {?>
	   					<div class="col-sm-3">
	   				<?php 
			            $accomodation_img = array('src' => 'user_uploads/thumbnail/original/'.$acc['pho_source'], 'alt' => 'accomodation','class' => 'img-thumbnail images-dashboard','title' => 'Accomodation'
			            );
			        ?>
			        <?php echo anchor('accommodation/list_record',img($accomodation_img)).br(1);?>
	   			</div>
	   			<div class="col-sm-9">
	   				<?php echo form_checkbox($checkbox_accommodation = array('name' => 'checkbox_accommodation[]', 'id' => 'checkbox_accommodation'), $acc['acc_id']);?>   
					<label><?php echo $acc['acc_name'];?></label>
	   				<p><?php echo $acc['acc_bookingtext'];?></p>
	   				<div class="form-group">
				        <label class="col-sm-2 control-label">Check In :</label>
				        <div class="col-sm-4">
				        	<?php
			        			$day_avaliable['monday'] 	= $acc['monday'];
				                $day_avaliable['tuesday'] 	= $acc['tuesday'];
				                $day_avaliable['wednesday'] = $acc['wednesday'];
				                $day_avaliable['thursday'] 	= $acc['thursday'];
				                $day_avaliable['friday'] 	= $acc['friday'];
				                $day_avaliable['saturday'] 	= $acc['saturday'];
				                $day_avaliable['sunday'] 	= $acc['sunday'];
				            	$new = site::convertDateToRangeFromFE($day_avaliable, $acc['start_date'], $acc['end_date']);
			                    $txtFrom = array('id'=>'dp4' ,'name' => 'txtFrom', 'class' => 'form-control','data-date-format'=>'yyyy-mm-dd','style'=>'', 'value' => $this->session->userdata('txtFrom') ? $this->session->userdata('txtFrom') : "");
			                    echo form_input($txtFrom);
				            ?>
						</div>
						<label class="col-sm-2 control-label">Check Out :</label>
						<div class="col-sm-4">
							<?php
			        			$day_avaliable['monday'] 	= $acc['monday'];
				                $day_avaliable['tuesday'] 	= $acc['tuesday'];
				                $day_avaliable['wednesday'] = $acc['wednesday'];
				                $day_avaliable['thursday'] 	= $acc['thursday'];
				                $day_avaliable['friday'] 	= $acc['friday'];
				                $day_avaliable['saturday'] 	= $acc['saturday'];
				                $day_avaliable['sunday'] 	= $acc['sunday'];
				            	$new = site::convertDateToRangeFromFE($day_avaliable, $acc['start_date'], $acc['end_date']);
			                    $txtTo = array('id'=>'dp5' ,'name' => 'txtTo', 'class' => 'form-control','data-date-format'=>'yyyy-mm-dd','style'=>'', 'value' => $this->session->userdata('txtTo') ? $this->session->userdata('txtTo') : "");
			                    echo form_input($txtTo);
				            ?>
				        </div>
			    	</div>
			    	<div class="form-group">
				        <label class="col-sm-3 control-label">Amount of Room :</label>
				        <div class="col-sm-3">
				            <select class="form-control">
								<option>1</option>
								<option>2</option>
								<option>3</option>
							</select>
				        </div>
			    	</div>
			    	<h3>Sub Accommodations</h3>
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
					   				<?php $customize_img = array('src' => 'user_uploads/thumbnail/original/'.$sub_accommodation['pho_source'],'alt' => 'customize','class' => 'img-thumbnail images-dashboard','title' => 'Customize');?>
						    		<?php echo img($customize_img).br(1);?>
					   			</div>
					   			<div class="col-sm-9">
					   				<label>
					   					<?php echo form_checkbox($checkbox_sub_accommodation = array('name' => 'checkbox_sub_accommodation[]', 'id' => 'checkbox_sub_accommodation'), $sub_accommodation['acc_id']);?>   
					   					<?php echo $sub_accommodation['acc_name'];?>
					   				</label>
					   				<p><?php echo $sub_accommodation['acc_bookingtext']; ?></p>
					   			</div>
					   			<div class="clear_both"></div>
					    	</div>
				    	<?php }?>
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