<div class="modal fade addmorepassenger" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

        <?php  echo form_open_multipart('site/customize_more_passenger', 'class="form-horizontal" name="frm_personal_info_modal" '); ?>
        <!-- Start Div Control Form Personal Information -->
        <div class="col-sm-12 form-booking" id="personal_info">
                <h2>Personal Information</h2>
                <hr>        
                <div class="col-sm-12">
                  <div class="form-group" id="feedback_bar"></div>
                  
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Passenger firstname <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                        <?php 
                          echo form_hidden("passenger_id", $passenger_info->pass_id);
                          $pfname = array(
                          'name' => 'pfname', 
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Passenger firstname',
                          'value' => $passenger_info->pass_fname
                          ); 
                          echo form_input($pfname); 
                        ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Passenger lastname <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php $plname = array(
                          'name' => 'plname', 
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Passenger lastname',
                          'value' => $passenger_info->pass_lname
                          ); 
                          echo form_input($plname); 
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Email <span class="require">*</span>: </label>
                    <div class="col-sm-5">
                        <?php $pemail = array(
                          'type' => "email",
                          'name' => 'pemail', 
                          'class' => 'form-control input_email',
                          'placeholder' => 'Email',
                          'value' => $passenger_info->pass_email
                          ); 
                          echo form_input($pemail); 
                        ?>
                        <span class="help-block">Example: username@example.com</span>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Home phone <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php $phphone = array(
                          'name' => 'phphone', 
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Home phone',
                          'value' => $passenger_info->pass_phone
                          ); 
                          echo form_input($phphone); 
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Mobile phone :</label>
                    <div class="col-sm-5">
                         <?php $pmobile = array(
                          'name' => 'pmobile', 
                          'class' => 'form-control', 
                          'placeholder' => 'Mobile phone ',
                          'value' => $passenger_info->pass_mobile
                          ); 
                          echo form_input($pmobile); 
                         ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Company :</label>
                    <div class="col-sm-5">
                         <?php $pcompany = array(
                          'name' => 'pcompany', 
                          'class' => 'form-control', 
                          'placeholder' => 'Company',
                          'value'=> $passenger_info->pass_company
                          ); 
                          echo form_input($pcompany); 
                        ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Country <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php $pcountry = array(
                          'name' => 'pcountry', 
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Country',
                          'value' => $passenger_info->pass_country
                          ); 
                          echo form_input($pcountry); 
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Gender <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php 
                         $pgender = array('selected' => '--- selected --- ','F' => 'Female' , 'M' => 'Male'); 
                         echo form_dropdown("gender", $pgender, $passenger_info->pass_gender,"class = form-control"); 
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Address <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php $paddress = array(
                          'name' => 'paddress', 
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Passenger Address', 
                          'rows' => '3',
                          'valu' => $passenger_info->pass_address
                          ); 
                          echo form_textarea($paddress); 
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <?php $input = array('name' => 'btnPersonalInfoModal', 'class' => 'btn btn-primary btn-sm', 'value' => ' Submit '); echo form_submit($input);?>
                </div>
        <?php echo form_close(); ?>
        </div>
        <!-- End Div control form Personal Information -->
    </div>
  </div>
</div>