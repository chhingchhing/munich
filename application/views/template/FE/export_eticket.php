<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <script type="text/javascript">

            function printPage(id) {
                //alert('successfully');
                var html = "<fieldset>";
                html += document.getElementById(id).innerHTML;
                html += "</fieldset>";
                var printWin = window.open('', '', 'left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status =0');
                printWin.document.write(html);
                printWin.document.close();
                printWin.focus();
                printWin.print();
                printWin.close();

                var html = "<html>";
                html += "<head>";
                // html+="<style type='text/css'>.mytable{border:1px solid #ccc;}.mytable tr{background-color:#008000;color:#FFF;}</style>";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/bootstrap.css' media='print' />";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/bootstrap-responsive.css' media='print' />";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/style.css' media='print' />";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/demo_table_jui.css' media='print' />";
                html += "</head>";
                html += document.getElementById(id).innerHTML;
                html += "</html>";
           }
        </script>
    </head>
    <body>
         <fieldset id="report" style="border:1px solid #239DA9 ;margin: 0 auto;width:96%;height: auto; padding:20px;border-radius:5px;">
                <div>
                     <?php 
               // $passengerWith = '';
                foreach ($eticket_collection as $value){
                   $passengerWith = unserialize($value->pbk_pass_come_with);
                  // var_dump($passengerWith); die();
                ?>
                
                                   </div>
               <div style=" height: 50px;  margin:10px;">
                <img src="<?php echo base_url(); ?>assets/img/FE/cg-logo.png" align="center"   alt="logo" /><?php echo '<br/><div style="float:right;color:#239DA9;width:40%;text-align:right; margin-right: 1%; margin-top:-4%;"><span style="margin-right:8px;"><b>Print Date:</b></span>' . '<span style="color:#3488CC;"><b>' . date("D/M/Y") . '</b></span><br/>';
                    ?> 
                    <b><?php echo 'Booking Date : '.$value->bk_date;?></b><br />         
                   <img src="<?php echo base_url(); ?>assets/img/FE/printer.gif" align="center" onClick="return printPage('report');" id="image"  alt="image" title="Print"/><br />
              </div>

        <div>
        <?php
              echo '<h1 style="color: #239DA9;
                    font-family: verdana;
                    font-size: 20px;
                    font-weight: bold;
                    text-align: center;">E-ticket Masterbookingform.com</h1></div>';
         ?>
               
                <br />
                <div>
                    <img src="<?php echo base_url(); ?>assets/img/FE/etichet/booking_type.PNG" align="center"   alt="E-ticket" style="margin-left:100px;"/> 
                    <table style="margin-left:120px;font-size:13px;">
                        <tr>
                            <td>Country</td>
                            <td>:</td>
                            <td><?php echo $value->lt_name; ?></td>
                        </tr>
                         <tr>
                            <td>Type Of Booking</td>
                            <td>:</td>
                            <td><b><?php echo $value->bk_type; ?></b></td>
                        </tr>
                         <tr>
                            <td>Festival Type</td>
                            <td>:</td>
                            <td><b><?php echo $value->cuscon_ftv_id; ?></b></td>
                        </tr>
                        <tr>
                            <td>Festival Name</td>
                            <td>:</td>
                            <td><b><?php echo $value->cuscon_name; ?></b></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>:</td>
                            <td><b><?php echo $value->bk_pay_price.'$';?></b></td>
                        </tr>
                         <tr>
                            <td>Amout Of People</td>
                            <td>:</td>
                            <td><b><?php echo $value->bk_total_people.' '.'people';?></b></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <img src="<?php echo base_url(); ?>assets/img/FE/etichet/booking_information.PNG" align="center"   alt="E-ticket" style="margin-left:100px;"/><br/>
                    <img src="<?php echo base_url(); ?>assets/img/FE/etichet/activities.PNG" align="center"   alt="E-ticket" style="margin-left:116px;"/><br/>
                    
                        <!-- activity -->                        
                            <?php $getMainActivities = $value->pk_activities;
                             $un_activities = unserialize($getMainActivities);
                           // var_dump($un_activities);
                             if(isset($un_activities['main-activities'])){
                                foreach($un_activities['main-activities'] as $rows){
                                                                               
                           ?>
                           <div style="margin-left:141px;">
                     <table style="font-size:13px;">
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><b><?php echo $rows['act_name']; ?></b></td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>:</td>
                        <td><b><?php echo $rows['lt_name']; ?></b></td>
                    </tr>
                    <tr>
                        <td>Fetival Name</td>
                        <td>:</td>
                        <td><b><?php echo $rows['ftv_name']; ?></b></td>
                   </tr>
                    <tr>
                        <td>Activity Eticket</td>
                        <td>:</td>
                        <td><b><?php echo $rows['act_texteticket']; ?></b></td>
                   </tr>
                   <tr>
                        <td>Activity Payeddate</td>
                        <td>:</td>
                        <td><b><?php echo $rows['act_payeddate']; ?></b></td>
                   </tr>
                   <tr>
                        <td>Activity Dealine</td>
                        <td>:</td>
                        <td><b><?php echo $rows['act_deadline']; ?></b</td>
                   </tr>

                   
                       
                   <!-- the end of activities -->
                </table>
            </div>
             <!-- sub activities -->
              <img src="<?php echo base_url(); ?>assets/img/FE/etichet/sub_activities.PNG" align="center"   alt="E-ticket" style="margin-left:141px;"/>
             <div style="margin-left:141px;"> 
             <?php
               // var_dump($un_activities['sub-activities']);
                       if(isset($un_activities['sub-activities'][$rows['act_id']])){
                            foreach ($un_activities['sub-activities'][$rows['act_id']] as $row) { ?>
            <table style="font-size:13px;">
                <div>
                     <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><b><?php echo $row['act_name']; ?></b></td>
                   </tr>
                    <tr>
                        <td>Location</td>
                        <td>:</td>
                        <td><b><?php echo $row['lt_name']; ?></b></td>
                   </tr>
                   <tr>
                        <td>Fetival Name</td>
                        <td>:</td>
                        <td><b><?php echo $row['ftv_name']; ?></b></td>
                   </tr>
                    <tr>
                        <td>Activity Eticket</td>
                        <td>:</td>
                        <td><b><?php echo $row['act_texteticket']; ?></b></td>
                   </tr>
                   <tr>
                        <td>Activity Payeddate</td>
                        <td>:</td>
                        <td><b><?php echo $row['act_payeddate']; ?></b></td>
                   </tr>
                   <tr>
                        <td>Activity Dealine</td>
                        <td>:</td>
                        <td><b><?php echo $row['act_deadline']; ?></b</td>
                   </tr>
                </table>
            </div>
                <?php
                        }
                            }

                ?>
            <?php      }                                
                           }                           
                       ?>
            <!-- the end sub of activities -->

                <img src="<?php echo base_url(); ?>assets/img/FE/etichet/accommodation.PNG" align="center"   alt="E-ticket" style="margin-left:-24px;"/>               
            <div style="margin-left:-2px;">
                <table style="font-size:13px;">
                    <!-- start of accommodation -->
                        <?php 
                            $getAccommodation = $value->pk_accomodation; 
                            $accommodation = unserialize($getAccommodation);

                            //var_dump($accommodation);
                            if(isset($accommodation['main-accommodation'])){
                                foreach($accommodation['main-accommodation'] as $rows){
                        ?>

                    <tr>
                        <td>Accommodation Name</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['acc_name'].'</b>';?></td>
                    </tr>                        
                    <tr>
                        <td>Accommodation E-ticket</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['acc_texteticket'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Accommodation Booking Date</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['acc_hoteldate'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Accommodation Payed Date</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['acc_payeddate'].'</b>';?></td>
                    </tr>
                     <tr>
                        <td>Accommodation Date Line</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['acc_deadline'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Accommodation Facility</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['clf_name'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Accommodation Location</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['lt_name'].'</b>';?></td>
                    </tr>
                    <?php 
                           // var_dump($transportation['extraproduct-pk'][4]);
                            } 
                        }
                    ?>
                </table>
            </div>

                    <img src="<?php echo base_url(); ?>assets/img/FE/etichet/sub_accommodation.PNG" align="center"   alt="E-ticket" style="margin-left:-5px;"/>
            <div style="margin-left:21px;">
                <table style="font-size:13px;">
                        <?php 
                            //var_dump($accommodation['sub-accommodation']);
                            if(isset($accommodation['sub-accommodation'])){
                                foreach ($accommodation['sub-accommodation'][$rows['acc_id']] as $row) { ?>
                                    
                                    <tr>
                                        <td>Name</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['acc_name'].'</b>';?></td>
                                    </tr>  
                                    <tr>
                                        <td>Text Booking</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['acc_bookingtext'].'</b>';?></td>
                                    </tr>
                                    <tr>
                                        <td>E-Ticket</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['acc_texteticket'].'</b>';?></td>
                                    </tr>
                                    <tr>
                                        <td>Booking Date</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['acc_hoteldate'].'</b>';?></td>
                                    </tr>
                                    <tr>
                                        <td>Paid Date</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['acc_payeddate'].'</b>';?></td>
                                    </tr>
                                    <tr>
                                        <td>Deadline</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['acc_deadline'].'</b>';?></td>
                                    </tr>
                                    <tr>
                                        <td>Facility</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['clf_name'].'</b>';?></td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td>:</td>
                                        <td><?php echo '<b>'.$row['lt_name'].'</b>';?></td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                </table>
                </div>
                </table>
            </div>
            <!-- Transportation -->
            <img src="<?php echo base_url(); ?>assets/img/FE/etichet/trasportation.PNG" align="center"   alt="E-ticket" style="margin-left:115px;"/>               
            <div style="margin-left:135px;">
                <table style="font-size:13px;">
                    <tr>
                        <td>Trasportation Name</td>
                        <td>:</td>
                        <td> <?php 
                                $getTransportation = $value->pk_transportation;
                                $transportation = unserialize($getTransportation); 
                                //var_dump($transportation); 
                           // var_dump($transportation['extraproduct-pk'][4]);
                            if(isset($transportation['main-transport'])){
                                foreach($transportation['main-transport'] as $rows){
                                         echo '<b>'.$rows['tp_name'].'</b>';
                                }
                            }
                            ?>
                        </td>
                    </tr>`
                    <tr>
                        <td>E-ticket</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_texteticket'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Booking Date</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_providerdate'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Payed Date</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_payeddate'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Pay Deadline</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_payeddate'].'</b>';?></td>
                    </tr>
                          

                </table>
            </div>
             <img src="<?php echo base_url(); ?>assets/img/FE/etichet/sub-transportation.PNG" align="center"   as
                lt="E-ticket" style="margin-left:130px;"/>
            <div style="margin-left:150px;">
                    <table style="font-size:13px;">
                        <?php if(isset($transportation['sub-transport'])){
                                foreach ($transportation['sub-transport'][$rows['tp_id']] as $rows) { ?>
                    <tr>
                        <td>E-ticket</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_texteticket'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Booking Date</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_providerdate'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Payed Date</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_payeddate'].'</b>';?></td>
                    </tr>
                    <tr>
                        <td>Pay Deadline</td>
                        <td>:</td>
                        <td><?php echo '<b>'.$rows['tp_payeddate'].'</b>';?></td>
                    </tr>
                          
                            <?php    }
                                 }
                            ?>
                    </table>
            </div>
            <!-- End Transportation -->
                <img src="<?php echo base_url(); ?>assets/img/FE/etichet/information.PNG" align="cerynter"   as
                lt="E-ticket" style="margin-left:100px;"/>
                   <p style="margin-left:120px;">
                <!-- <p style="margin-left:130px;font-size:15px;"> -->
                
                <?php 
                $accompany = mod_index::getAccompany($passengerWith);

            $allPassengers = '';
            echo '<div class="clearfix">';
            foreach($accompany->result() as $rows){
                $allPassengers .= '<div class="col-lg-4 .col-xs-6"><p style="margin-left:120px;font-size:13px;"> 
                                Passenger Name: '.$rows->pass_fname.' '.$rows->pass_lname.'<br/>
                                Email: '.$rows->pass_email.'<br/>
                                Phone Number: '.$rows->pass_phone.'<br/>
                                Address: '.$rows->pass_address.'<br/>
                                Company: '.$rows->pass_company.'<br/>
                                Gender: '.$rows->pass_gender.'<br/>' ;
                $allPassengers .= '</p></div>';
            }
            echo $allPassengers;
            echo '</div>';
          //}?>
                </p>
                </div>
                <?php }?>
              </fieldset>


    
    </body>

     