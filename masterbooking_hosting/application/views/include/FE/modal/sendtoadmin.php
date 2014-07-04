<?php 
  if ($this->session->userdata('create')) {
            echo $this->session->userdata('create');
            $this->session->unset_userdata('create');
        }  
        if ($this->session->userdata('error')) {
            echo $this->session->userdata('error');
            $this->session->unset_userdata('error');
        } 
?>

<div class="modal fade sendtoadmin" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <?php 
          echo form_open("site/sendtoadmin",'class="form_subscribe"');
        ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h2 class="modal-title">More Passenger</h2>
        </div>
      <div class="modal-body">
        <table>
        </tr>
        <tr>
            <td>Email<span class="require">*</span> :</td>
            <td>
                <?php
                    $emailpass = array('name' => 'email','value'=> set_value('email'),'class' => 'form-control');
                    echo form_input($emailpass);?>
                    <span style="color:red;"><?php echo form_error('email'); ?></span>
          </td>
        </tr>
       
      </table>
      <br />
      <p style="font-size:15px;">NOTE: all (<span class="require">*</span>) are requirement<p>
                      </div>
                            <div class="modal-footer">
                            <?php echo form_submit(array("name"=>"btn_sending","class"=>"frm_profile","id"=>"frm_profile","value"=>set_value("frm_profile","submit"),"class"=>"btn btn-primary")); ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
      
      <?php 
          echo form_close();
        ?>
    </div>
  </div>
</div>