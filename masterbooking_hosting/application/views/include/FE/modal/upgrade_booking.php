<div class="modal fade upgrade_booking" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <?php 
          echo form_open("site/upgrade_booking",'class="form_subscribe"');
        ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h2 class="modal-title">More Product</h2>
        </div>
    <div class="modal-body">
      <table>
        <tr>
            <td>Booking ID<span class="require">*</span> :</td>
            <td>
                 <?php
                $booking_id = array();
                $booking_id[''] = "--- select ---";
                if(isset($passengerbooking_info)){
                  if($passengerbooking_info->num_rows > 0){
                    foreach($passengerbooking_info->result() as $value){
                      $booking_id[$value->bk_id] = $value->bk_id; 
                    }
                  }
                }
                ?>
                  <?php
                    echo form_dropdown('txtBooking',$booking_id,set_value('txtBooking') ,'class="form-control"'); 
                  ?>
                  <span style="color:red;"><?php echo form_error('txtBooking'); ?></span>
          </td>
        </tr>
        <tr>
            <td>Extra Service <span class="require">*</span> :</td>
            <td><?php 
                $extraservices = array();
                $extraservices[''] = "--- select ---";
                    if($extraService->num_rows > 0){
                        foreach($extraService->result() as $value){
                            $extraservices[$value->ep_id] = $value->ep_name;
                        }
                    }
                echo form_dropdown('upgradextraservice', $extraservices, '', 'class="es form-control"');
            ?></td>
        </tr>
      </table>
  	</div>
  	<div class="modal-footer">
        <?php echo form_submit(array("name"=>"addmore_service","class"=>"frm_profile","id"=>"frm_profile","value"=>set_value("frm_profile","submit"),"class"=>"btn btn-primary")); ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>    
      <?php 
          echo form_close();
        ?>
    </div>
  </div>
</div>