<?php  echo form_open_multipart('site/customizes/customizeTrip', 'class="form-horizontal" id="trip_info"'); ?>
<div class="tab-pane col-sm-12 active form-booking" id="trip_info">
	   		<h2>Trip Informations</h2>
	   		<hr>
	   		<div id="feedback_bar_modal"></div>
	   		<?php 
	   		?>
	   		<div class="col-sm-12">
		   		<div class="form-group">
			        <label class="col-sm-3 control-label">From :</label>
		                <?php
		                    $txtFrom = array('id'=>'d1' ,'name' => 'txtFrom', 'title'=>'From', 'class' => 'form-control input_require_trip_info','data-date-format'=>'yyyy-mm-dd','style'=>'width:210px;', 'value' => $this->session->userdata('txtFrom') ? $this->session->userdata('txtFrom') : "");
		                    echo form_input($txtFrom);
		                ?>
			    </div>
			    <div class="form-group">
			        <label class="col-sm-3 control-label">To :</label>
		                <?php
		                    $txtTo = array('id'=>'d2' ,'name' => 'txtTo', 'title'=>'To', 'class' => 'form-control input_require_trip_info','data-date-format'=>'yyyy-mm-dd','style'=>'width:210px;', 'value' => $this->session->userdata('txtTo') ? $this->session->userdata('txtTo') : "");
		                    echo form_input($txtTo);
		                ?>
			    </div>
			    <div class="form-group">
			        <label class="col-sm-3 control-label">Amount of People :</label>
			        <div class="col-sm-2">
			            <?php 
			            $people = array('name' => 'people', 'title'=>'Amount of People', 'class' => 'form-control input_require_trip_info', 'value' => $this->session->userdata("people") ? $this->session->userdata("people") : 0); 
			            echo form_input($people);
			            ?>
			        </div>
			    </div>
			</div>
			<?php $input = array('name' => 'btnTripInfo', 'class' => 'btn btn-primary btn-sm', 'value' => ' Next '); echo form_submit($input);?>
			
<p></p>
<?php echo form_close(); ?>
</div>
	   <!-- end div home -->