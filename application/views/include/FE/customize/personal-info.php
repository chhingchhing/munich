<?php  echo form_open_multipart('site/customizes/personal-info', 'class="form-horizontal"'); ?>
<!-- Start Div Control Form Personal Information -->
<div class="col-sm-12 form-booking" id="personal_info">
	   		<h2>Personal Information</h2>
	   		<hr>
	   		<div class="col-sm-12">
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Passenger firstname :</label>
	   				<div class="col-sm-5">
				        <?php $pfname = array('name' => 'pfname', 'class' => 'form-control', 'placeholder' => 'Passenger firstname'); echo form_input($pfname); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Passenger lastname :</label>
	   				<div class="col-sm-5">
				         <?php $plname = array('name' => 'plname', 'class' => 'form-control', 'placeholder' => 'Passenger lastname'); echo form_input($plname); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Email : </label>
	   				<div class="col-sm-5">
				         <?php $pemail = array('name' => 'pemail', 'class' => 'form-control', 'placeholder' => 'Email'); echo form_input($pemail); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Home phone :</label>
	   				<div class="col-sm-5">
				         <?php $phphone = array('name' => 'phphone', 'class' => 'form-control', 'placeholder' => 'Home phone '); echo form_input($phphone); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Mobile phone :</label>
	   				<div class="col-sm-5">
				         <?php $pmobile = array('name' => 'pmobile', 'class' => 'form-control', 'placeholder' => 'Mobile phone '); echo form_input($pmobile); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Company :</label>
	   				<div class="col-sm-5">
				         <?php $pcompany = array('name' => 'pcompany', 'class' => 'form-control', 'placeholder' => 'Company'); echo form_input($pcompany); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Country :</label>
	   				<div class="col-sm-5">
				         <?php $pcountry = array('name' => 'pcountry', 'class' => 'form-control', 'placeholder' => 'Country'); echo form_input($pcountry); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Gender :</label>
	   				<div class="col-sm-5">
				         <?php $pgender = array('selected' => '--- selected --- ','F' => 'Female' , 'M' => 'Male'); echo form_dropdown("gender", $pgender,"","class = form-control"); ?>
				    </div>
	   			</div>
	   			<div class="form-group">
	   				<label class="col-sm-3 control-label">Address :</label>
	   				<div class="col-sm-5">
				         <?php $paddress = array('name' => 'paddress', 'class' => 'form-control', 'placeholder' => 'Passenger Address', 'rows' => '3'); echo form_textarea($paddress); ?>
				    </div>
	   			</div>
	   		</div>
	   		<?php echo anchor("site/customizes/extra-service","Previous", array('role'=>'button', 'class'=>'btn btn-info btn-sm')); ?>
			<?php $input = array('name' => 'btnExtraService', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
<p></p>
<?php echo form_close(); ?>
</div>
<!-- End Div control form Personal Information -->
