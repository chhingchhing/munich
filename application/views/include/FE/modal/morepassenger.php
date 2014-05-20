<div class="modal fade addmorepassenger" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <?php 
          echo form_open("site/morepassenger",'class="form_subscribe"');
        ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h2 class="modal-title">More Passenger</h2>
        </div>
      <div class="modal-body">
        <!-- start of booking id -->
          <div class="form-group">
            <label class="col-sm-4 control-label">Booking ID<span class="require">*</span> :</label>
            <div class="col-sm-6">
               <?php
              $booking_id = array();
              $booking_id[''] = "--- select ---";
              if(isset($passengerbooking_info))
                if($passengerbooking_info->num_rows > 0){
                  foreach($passengerbooking_info->result() as $value){
                    $booking_id[$value->bk_id] = $value->bk_id; 
                  }
                }
              ?>
                <?php
                  echo form_dropdown('txtBooking',$booking_id,set_value('txtBooking') ,'class="form-control"'); 
                ?>
                <span style="color:red;"><?php echo form_error('txtBooking'); ?></span>
            </div>
         </div>
        <!-- end of booking id -->
                            <div class="form-group">
                               <label class="col-sm-4 control-label">First Name <span class="require">*</span> :</label>
                               <div class="col-sm-6">
                                   <?php
                                       $firstnamepass = array('name' => 'fname','value'=> set_value('fname'),'class' => 'form-control');
                                       echo form_input($firstnamepass); 
                                       ?>
                                   <span style="color:red;"><?php echo form_error('fname'); ?></span>
                               </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Last Name <span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                        $lastnamepass = array('name' => 'lname','value'=> set_value('lname'),'class' => 'form-control');
                                        echo form_input($lastnamepass); 
                                        ?>
                                    <span style="color:red;"><?php echo form_error('lname'); ?></span>
                                </div>
                             </div>
                             <div class="form-group">
                                <label class="col-sm-4 control-label">Password <span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                        $password = array('name' => 'password','value'=> set_value('password'),'class' => 'form-control');
                                        echo form_input($password); 
                                        ?>
                                    <span style="color:red;"><?php echo form_error('password'); ?></span>
                                </div>
                             </div>
                              <div class="form-group">
                                <label class="col-sm-4 control-label">Email <span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                        $emailpass = array('name' => 'email','value'=> set_value('email'),'class' => 'form-control');
                                        echo form_input($emailpass); 
                                        ?>
                                    <span style="color:red;"><?php echo form_error('email'); ?></span>
                                </div>
                             </div>
                             <div class="form-group">
                                <label class="col-sm-4 control-label">Mobile Phone<span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                        $phonepass = array('name' => 'phone','value'=> set_value('phone'),'class' => 'form-control');
                                        echo form_input($phonepass); 
                                        ?>
                                    <span style="color:red;"><?php echo form_error('phone'); ?></span>
                                </div>
                             </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Telephone<span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                        $telephone = array('name' => 'telephone','value'=> set_value('telephone'),'class' => 'form-control');
                                        echo form_input($telephone); 
                                        ?>
                                </div>
                             </div>



                              <div class="form-group">
                                <label class="col-sm-4 control-label">Address<span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                        $addresspass = array('name' => 'address','value'=> set_value('address'),'class' => 'form-control');
                                        echo form_textarea($addresspass); 
                                        ?>
                                    <span style="color:red;"><?php echo form_error('address'); ?></span>
                                </div>
                             </div>
                             <div class="form-group">
                                <label class="col-sm-4 control-label">Company <span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php
                                        $companypass = array('name' => 'company','value'=> set_value('company'),'class' => 'form-control');
                                        echo form_input($companypass); 
                                        ?>
                                    <span style="color:red;"><?php echo form_error('company'); ?></span>
                                </div>
                             </div>
                            <div class="form-group">
                            <label class="col-sm-4 control-label">Gender<span class="require">*</span> :</label>
                                <div class="col-sm-6">
                                    <?php 
                                    //$txtGender = array('' => '-- Select --', 'F' => 'Female', 'M' => 'Male');
                                    echo form_dropdown('gender',$old_gender,set_value('gender') ,'class="form-control"'); ?>
                                    <span style="color:red;"><?php echo form_error('gender'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="col-sm-4 control-label">Status<span class="require">*</span> :</label>
                            <div class="col-sm-6">
                                <?php
                                  $txtStatus = array('0' => 'Unpublished','1' => 'Published');
                                 echo form_dropdown('txtStatus',$txtStatus,set_value('txtStatus') ,'class="form-control"'); ?>
                                <span style="color:red;"><?php echo form_error('txtStatus'); ?></span>
                            </div>
                           </div>
                          </div>
                            <div class="modal-footer">
                            <?php echo form_submit(array("name"=>"addmore_profile","class"=>"frm_profile","id"=>"frm_profile","value"=>set_value("frm_profile","submit"),"class"=>"btn btn-primary")); ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
         
      
      <?php 
          echo form_close();
        ?>
    </div>
  </div>
</div>