

<div class="modal fade passenger_detailbookingform" tabindex="-1" role="dialog" aria-labelledby="passenger_detailbookingform" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <center><h2>Details Passenger booking</h2></br></center>   
                    
                            <?php

                            $id = 1;
                            if ($this->uri->segment(3)) {
                                $id = $this->uri->segment(3) + 1;
                            } else {
                                $id = 1;
                            }

                             ?>
                           <?php if ($passengerbooking_info->num_rows > 0) { ?>
                            <?php foreach($passengerbooking_info->result() as $row) { ?>
                      <div class="table-responsive">
                          <table class="table table-bordered">
                            <tr>
                                    <th>Booking ID </th> <td><?php echo $id++ ; ?></td> 
                            </tr>
                            <tr>
                                    <th>Booking Type </th> <td><?php echo $row->bk_type ; ?></td> 
                            </tr>
                            <tr>
                                    <th>Booking date</th> <td><?php echo $row->bk_date; ?></td>
                            </tr>
                            <tr>
                                    <th>Arrival date</th> <td><?php echo $row->bk_arrival_date; ?></td>
                            </tr>
                            <tr>
                                    <th>Booking total people</th> <td><?php echo $row->bk_total_people; ?></td>
                            </tr>
                            <tr>
                                    <th>Booking pay date</th> <td><?php echo $row->bk_pay_date ; ?></td>
                            </tr>
                             <tr>
                                    <th>Booking pay prices</th> <td><?php echo $row->bk_pay_price ; ?></td>
                            </tr>
                            <tr>
                                    <th>Payment</th> <td><?php echo $row->bk_pay_status; ?></td>
                            </tr>   
                             
                                    <th>Package start date</th> <td><?php echo $row->pkcon_start_date; ?></td>
                             </tr>
                             <tr>
                                    <th>Package end date</th> <td><?php echo $row->pkcon_end_date ; ?></td>
                             </tr>
                              
                             <tr>
                                    <th>Package description</th> <td><?php echo $row->pkcon_description ; ?></td>
                             </tr>
                           </table>

             </div>         
                       <?php } ?>
                   <?php } ?>

                   <div class="btn_popupclose">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   </div>
       
                
            
    </div>
  </div>
</div>