<?php  echo form_open_multipart('site/customizes/extra-service', 'class="form-horizontal"'); ?>
<div class="col-sm-12 form-booking" id="extra_service">
	   		<h2>Welcome to Extra Service Page </h2>
	   		<hr>
	   		<div class="col-sm-12">
	   			<?php 
	   			$order = 0;
	   			foreach ($recordExtraProducts as  $extra) { 
	   				$order++;
	   			?>
	   				<div class="col-sm-3">
	   					<?php $extra_img = array('src' => 'user_uploads/thumbnail/original/'.$extra['pho_source'],'alt' => 'customize','class' => 'img-thumbnail images-dashboard','title' => 'Customize extra products');?>
		    			<?php echo img($extra_img);?>
	   				</div>
	   				<div class="col-sm-7">
	   					<h4 class="fe_customize" id="<?php echo "main_act_order_$order"; ?>" order="<?php echo $order; ?>">
		   					<?php
		   					$mainExtraService = $this->general_lib->get_extra_services();
		   					$checked = false;
		   					if ($mainExtraService != '') {
		   						if (isset($mainExtraService[$extra['ep_id']])) {
		   							if ($mainExtraService[$extra['ep_id']] == $extra['ep_id']) {
				   						$checked = true;
				   					}
		   						}
		   					}
		   					
		   					$checkbox = array(
		   						'value' => $extra['ep_id'], 
		   						'checked' => $checked, 
		   						'class' => 'check_main_element', 
		   						'name' => 'checkbox_extra_service['.$extra['ep_id'].']', 
		   						'id' => "checkbox_main_extra_service"
		   					);
		   					echo form_checkbox($checkbox).nbs();
		   					echo $extra['ep_name'];
		   					?> 
	   					</h4>
		   				<p><?php echo $extra['ep_bookingtext'];?></p>
	   				</div>
	   				<div class="col-sm-2">
	   					<label>Amount of Products</label>
	   					<?php
			   				$value = "";
			   				$amountExtras = $this->general_lib->get_num_extra_services();

			   				if (isset($amountExtras[$extra['ep_id']])) {
			   					$main_value = $amountExtras[$extra['ep_id']["0"]];
			   					foreach ($main_value as $val) {
			   						$value = $val;
			   					}
			   				}
		   					$input = array(
		   							"name"=>"amountExpAmount[".$extra['ep_id']."][]",
		   							"class"=>"form-control amount_extras", 
		   							"value"=> $value,
		   							"id" => "amount_extra_".$order
		   						);
		   					echo form_input($input);
		   				?>
	   				</div>
	   				<div class="clear_both"></div>
	   			<?php } ?>
	   		</div>
	   		<?php echo anchor("site/customizes/transportation","Previous", array('role' => 'button', 'name' => 'btnExtraService', 'class' => 'btn btn-default btn-sm')); ?>
	   		<?php $input = array('name' => 'btnExtraService', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
<p></p>
<?php echo form_close(); ?>
</div>
	   
