<?php  echo form_open_multipart('site/customizes/extra-service', 'class="form-horizontal"'); ?>
<div class="col-sm-12 form-booking" id="extra_service">
	   		<h2>Welcome to Extra Service Page </h2>
	   		<hr>
	   		
	   		<?php echo anchor("site/customizes/transportation","Previous", array('role'=>'button', 'class'=>'btn btn-info btn-sm')); ?>
			<?php $input = array('name' => 'btnExtraService', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
<p></p>
<?php echo form_close(); ?>
</div>
	   <!-- end div home -->