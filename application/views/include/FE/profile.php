
<div class="row">
                <div class="col-md-4">
                     <?php if ($profile->num_rows > 0) { ?>
                       <?php foreach($profile->result() as $row) { ?>
                                        <span>
                                           <h2>Welcome to :&nbsp; &nbsp;<?php 
                                                echo ucfirst($row->pass_fname).'&nbsp;'.strtoupper($row->pass_lname);
                                                ?></h2>
                                        </span>

                       <div class="table-responsive">
                              <table class="table table-bordered">

                                <tr>
                                        <th>First Name</th> <td><?php echo $row->pass_fname; ?></td>
                                </tr>
                                <tr>
                                        <th>Last Name</th> <td><?php echo $row->pass_lname; ?></td>
                                </tr>
                                <tr>
                                        <th>Email</th> <td><?php echo $row->pass_email; ?></td>
                                </tr>
                                <tr>
                                        <th>Phone number </th> <td><?php echo $row->pass_phone; ?></td>
                                </tr>
                                <tr>
                                        <th>Address</th> <td><?php echo $row->pass_address; ?></td>
                                </tr>
                                 <tr>
                                        <th>Company</th> <td><?php echo $row->pass_company ; ?></td>
                                </tr>
                                <tr>
                                        <th>Gender</th> <td><?php echo $row->pass_gender; ?></td>
                                </tr>
                                
                            </table>
                       </div>
                    <?php }?>
                <?php }?>
                  <?php $this->load->view(INCLUDE_FE_MODEL."updateprofile"); ?>
                    <a href="#"><button class="btn btn-default" data-toggle="modal" data-target=".updateprofileuser">Edit Profile</button></a>
                </div>
          <div class="col-md-8">
             <?php $this->load->view(INCLUDE_FE_MODEL."morepassenger"); ?> 
                    <div class="table-responsive"><a href="#">
                      
                        <button class="btn-info btn-sm" data-toggle="modal" data-target=".addmorepassenger">More Passenger</button></a>
                        <h2>Passenger Booking information</h2>
                        <table class="table table-bordered">
                            <tr> 
                                <!-- <th>Passenger come with</th> -->
                                <th>NO</th>
                                <th>Booking date</th>
                                <th>Arrival date</th>
                                <th>Booking total people</th>
                                <th>Booking pay date</th>
                                <th>Booking pay prices</th>
                                <th>Action</th>

                            </tr>
                        <tbody class="tbl_body">
                            <?php if ($passengerbooking_info->num_rows > 0) { ?>
                               <?php foreach($passengerbooking_info->result() as $row) { ?>
                                    <tr>
                                            <!-- <td><?php// echo $row->pbk_pass_come_with; ?></td> -->
                                            <td><?php echo $row->bk_id;?></td>
                                            <td><?php echo $row->bk_date; ?></td>
                                            <td><?php echo $row->bk_arrival_date; ?></td>
                                            <td><?php echo $row->bk_total_people; ?></td>
                                            <td><?php echo $row->bk_pay_date; ?></td>
                                            <td><?php echo $row->bk_pay_price; ?></td>
                                            <td><?php echo anchor ('site/export_eticket/','Export E-tickit','title="Print"');?></td>
                                    </tr>
                               <?php }?>
                            <?php }?>
                        </tbody>
                        
                    </table>
                        <?php $this->load->view(INCLUDE_FE_MODEL."passenger_detailbookingform"); ?>

                    <a href="#"><button class="btn btn-default" data-toggle="modal" data-target=".passenger_detailbookingform">Passenger Detail Booking</button></a>		
                     
                 </div>   
            </div>

       </div>
       <?php echo '</br>';?>
       <div class="col-md-12">
            <?php foreach ($members->result() as $team_members) {?>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-success">
                        <div class="panel-heading">Team Member : <?php echo ucwords($team_members->pass_lname . ' ' . $team_members->pass_fname);?></div>
                        <!-- to add fields of each members -->
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">Transportations </div>
                                <div class="panel-body">
                                    <?php 
                                        $extra_tranportation = $this->general_lib->get_sub_trans_extr_product();
                                        if ($extra_tranportation != '') {
                                           foreach ($extra_tranportation as $ep_id) {
                                               $exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
                                                $checkbox = array(
                                                    'value' => $exact_info->ep_id, 
                                                    'class' => 'each_subact', 
                                                    'name' => 'each_subact['.$exact_info->ep_id.']'
                                                );
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $amount_exta = $this->general_lib->get_sub_acc_amount_extra();
                                                $input = array(
                                                    'value' => $amount_exta[$ep_id][0],
                                                    'name' => 'origin_extra',
                                                    'class' => 'form-control input-sm'
                                                    );
                                                echo form_input($input); 
                                            ?>
                                        </td>
                                    </tr>
                                    <?php }
                                        } else {
                                            echo "No extra product.";
                                        } 
                                    ?>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Accommodations  </div>
                                <div class="panel-body">
                                    <!-- start of accommodations --> 
                                        <div class="col-sm-6">
                                            <table class='table'>
                                                <tr>
                                                    <th>Room</th>
                                                    <th>Amount</th>
                                                </tr>
                                                <?php 
                                                $accom_roomtypes = $this->general_lib->get_room_type_accommodation();
                                                $amount_room_booked = $this->general_lib->get_amount_book_room();
                                                if ($accom_roomtypes != '') {
                                                    foreach ($accom_roomtypes as $array_classf) {
                                                        foreach ($array_classf as $roomsType) {
                                                            foreach ($roomsType as $rtID) {
                                                                $rooms = $this->mod_fecustomize->getAllRoomTypeEachPassenger($rtID)->result();
                                                                foreach ($rooms as $item) {
                                                                    ?>
                                                                <tr>
                                                                    <td><?php echo $item->rt_name; ?></td>
                                                                    <td><?php echo $amount_room_booked[$item->rt_id]; ?></td>
                                                                </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo "No accommodation.";
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="col-sm-6">
                                            <table class='table'>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Amount</th>
                                                </tr>
                                            <?php 
                                            $extra_activities = $this->general_lib->get_sub_acc_extr_product();
                                            if ($extra_activities != "") {
                                                foreach($extra_activities as $ep_id) {
                                                    $exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
                                                    $checkbox = array(
                                                        'value' => $exact_info->ep_id, 
                                                        'class' => 'each_subact', 
                                                        'name' => 'each_subact['.$exact_info->ep_id.']'
                                                    );
                                                    ?>
                                                <tr>
                                                    <td><?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?></td>
                                                    <td><?php 
                                                    $amount_exta = $this->general_lib->get_sub_acc_amount_extra();
                                                        $input = array(
                                                            'value' => $amount_exta[$ep_id][0],
                                                            'name' => 'origin_extra',
                                                            'class' => 'form-control input-sm'
                                                            );
                                                        echo form_input($input); 
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                            } else {
                                                echo "No extra product.";
                                            } ?>
                                        </table>
                                    </div>
                                    <!-- end of accommodations -->
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Activities  </div>
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <table class='table'>
                                            <?php 
                                            $activities = $this->general_lib->get_sub_activities();
                                            if ($activities != '') {
                                            foreach($activities as $act_id) {
                                                $act_info = $this->mod_fecustomize->get_info_of_main_obj('activities', 'act_id', $act_id);
                                                $checkbox = array(
                                                    'value' => $act_info->act_id, 
                                                    'class' => 'each_subact', 
                                                    'name' => 'each_subact['.$act_info->act_id.']'
                                                );
                                                ?>
                                            <tr>
                                                <td><?php echo form_checkbox($checkbox). nbs(2). $act_info->act_name; ?></td>
                                                <td>There are only <?php $amountPeople = $this->general_lib->get_people_sub_activity(); echo $amountPeople[$act_info->act_id]; ?> member(s) for joining this action</td>
                                            </tr>
                                            <?php }
                                            } else {
                                                echo "No activities.";
                                            } ?>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <table class='table'>
                                            <tr>
                                                <th>Item</th>
                                                <th>Amount</th>
                                            </tr>
                                            <?php 
                                                $extra_activities = $this->general_lib->get_extra_activities();
                                                if ($extra_activities != '') {
                                                    foreach($extra_activities as $ep_id) {
                                                        $exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
                                                        $checkbox = array(
                                                            'value' => $exact_info->ep_id, 
                                                            'class' => 'each_subact', 
                                                            'name' => 'each_subact['.$exact_info->ep_id.']'
                                                        );
                                            ?>
                                            <tr>
                                                <td><?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?></td>
                                                <td>
                                                    <?php 
                                                        $amount_exta = $this->general_lib->get_amount_extra();
                                                        $input = array(
                                                            'value' => $amount_exta[$ep_id],
                                                            'name' => 'origin_extra',
                                                            'class' => 'form-control input-sm'
                                                        );
                                                        echo form_input($input); 
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php }
                                            } else {
                                                echo "No extra product.";
                                            } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Extra Products  </div>
                                <div class="panel-body">
                                    <table class='table'>
                                        <tr>
                                            <th>Item</th>
                                            <th>Amount</th>
                                        </tr>
                                        <?php 
                                            $extra_service = $this->general_lib->get_extra_services();
                                            if ($extra_service != "") {
                                                foreach($extra_service as $ep_id) {
                                                    $exact_info = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $ep_id);
                                                    $checkbox = array(
                                                        'value' => $exact_info->ep_id, 
                                                        'class' => 'each_extra_service', 
                                                        'name' => 'each_extra_service['.$exact_info->ep_id.']'
                                                    );
                                            ?>
                                        <tr>
                                            <td><?php echo form_checkbox($checkbox). nbs(2). $exact_info->ep_name; ?></td>
                                            <td>
                                                <?php 
                                                    $amountExtras = $this->general_lib->get_num_extra_services();
                                                    $input = array(
                                                        'value' => $amountExtras[$ep_id][0],
                                                        'name' => 'origin_extra_service',
                                                        'class' => 'form-control input-sm'
                                                    );
                                                    echo form_input($input); 
                                                ?>
                                            </td>
                                        </tr>
                                        <?php }
                                        } else {
                                            echo "No extra service.";
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end add fields of each members -->
                    </div>
                    
                        </br>
                </div>
            <?php  }?>             
        </div>