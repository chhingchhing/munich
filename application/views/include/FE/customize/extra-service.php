<?php  echo form_open_multipart('site/customizes/extra-service', 'class="form-horizontal"'); ?>
<div class="col-sm-12 form-booking" id="extra_service">
	   		<h2>Welcome to Extra Service Page </h2>
	   		<hr>
	   		<div class="col-sm-12">
	   			<?php foreach ($recordExtraProducts as  $extra) { ?>
	   				<div class="col-sm-3">
	   					<?php $extra_img = array('src' => 'user_uploads/thumbnail/original/'.$extra['pho_source'],'alt' => 'customize','class' => 'img-thumbnail images-dashboard','title' => 'Customize extra products');?>
		    			<?php echo img($extra_img);?>
	   				</div>
	   				<div class="col-sm-7">
	   					<?php echo form_checkbox($checkbox_transportation = array('name' => 'checkbox_transportation[]', 'id' => 'checkbox_transportation'), $extra['ep_id']);?>   
		   				<label><?php echo $extra['ep_name'];?></label>
		   				<p><?php echo $extra['ep_bookingtext'];?></p>
	   				</div>
	   				<div class="col-sm-2">
	   					<label>Amount of Products</label>
	   					<?php 
	   						$expAmount = array('class' => 'form-control', 'name' => 'expAmount[]');
	   						echo form_input($expAmount);
	   					?>
	   				</div>
	   				<div class="clear_both"></div>
	   			<?php } ?>
	   		</div>
	   		<?php echo anchor("site/customizes/transportation","Previous", array('role' => 'button', 'name' => 'btnExtraService', 'class' => 'btn btn-info btn-sm')); ?>
	   		<?php $input = array('name' => 'btnExtraService', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
<p></p>
<?php echo form_close(); ?>
</div>
	   
