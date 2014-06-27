<div class="modal fade addmorepassenger_modal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

        <?php  echo form_open_multipart('site/customize_more_passenger', 'class="form-horizontal" name="frm_personal_info_modal" id="frm_personal_info_modal" '); ?>
        <!-- Start Div Control Form Personal Information -->
        <div class="col-sm-12 form-booking" id="personal_info">
                <h2>Personal Information</h2>
                <hr>        
                <div class="col-sm-12">
                  <div class="form-group" id="feedback_bar_modal"></div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Passenger firstname <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                        <?php 
                          $pfname = array(
                          'name' => 'pfname', 
                          'title' => 'First Name',
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Passenger firstname',
                          'value' => ''
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
                          'title' => 'Last Name',
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Passenger lastname',
                          'value' => ''
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
                          'title' => 'Email',
                          'class' => 'form-control input_email',
                          'placeholder' => 'Email',
                          'value' => ''
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
                          'title' => 'Phone',
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Home phone',
                          'value' => ''
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
                          'value' => ''
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
                          'value'=> ''
                          ); 
                          echo form_input($pcompany); 
                        ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Country <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php 
                         echo country_dropdown('pcountry', 'cont', 'form-control input_require', '', array('KH','CA','US'), '');
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Gender <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php 
                         $pgender = array('' => '--- selected --- ','F' => 'Female' , 'M' => 'Male'); 
                         echo form_dropdown("pgender", $pgender, '',"class = form-control title = Gender"); 
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Address <span class="require">*</span>:</label>
                    <div class="col-sm-5">
                         <?php $paddress = array(
                          'name' => 'paddress', 
                          'title' => 'Address',
                          'class' => 'form-control input_require', 
                          'placeholder' => 'Passenger Address', 
                          'rows' => '3',
                          'valu' => ''
                          ); 
                          echo form_textarea($paddress); 
                         ?>
                    </div>
                    <p class="help-block error"></p>
                  </div>
                </div>
                <div>
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