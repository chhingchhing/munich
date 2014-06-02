<?php $this->load->view(INCLUDE_FE.'before_content'); ?>   
<br />
<br />

<div class="row clearfix wrap_customize">
	<div class="col-sm-12 titleBooking">
		<h1>Booking Tour</h1>
	</div>
	<div class="col-sm-12">
		<div class="col-sm-10">
			<ul class="nav nav-tabs menu_customize">
			   <li><?php echo anchor("site/customizes/","Trip info"); ?></li>
			   <li><?php echo anchor("site/customizes/activities","Activities"); ?></li>
			   <li><?php echo anchor("site/customizes/accommodation","Accommodation"); ?></li>
			   <li><?php echo anchor("site/customizes/transportation","Transportation"); ?></li>
			   <li><?php echo anchor("site/customizes/extra-service","Extra Services"); ?></li>
			   <li><?php echo anchor("site/customizes/personal-info","Personal Information"); ?></li>
			   <li><?php echo anchor("site/customizes/payments","Payment"); ?></li>
			</ul>			
		<hr>
			<div class="tab-content">
			   	<?php 
			   		if($this->uri->segment(4)){
			   			$this->load->view(INCLUDE_FE_CUSTOMIZE.$this->uri->segment(4));
			   		}else{
			   			$this->load->view(INCLUDE_FE_CUSTOMIZE.'trip-info');
			   		}
			   	?>
			</div>
		</div>
		<!-- start calculate form order -->
		<div class="col-sm-2 form-order">
			<h3>Order</h3>
			<hr/>
			<?php 

				if($this->session->userdata('ftvID')) echo '<b>Festival : </b>'.MU_Model::getForiegnTableName('festival', array('ftv_id'=>$this->session->userdata('ftvID')), 'ftv_name').'<br/>';
				if($this->session->userdata('lcID')) echo '<b>Location : </b>'.MU_Model::getForiegnTableName('location', array('lt_id'=>$this->session->userdata('lcID')), 'lt_name');
				$acts = $this->general_lib->get_main_activities();
				if($acts != ''){
					$actPeople = $this->general_lib->get_people_main_activity();
					$order = 0;
					foreach($acts as $key => $actsID){
						$order++;
						echo '<p>';
						echo '<b>Activities : </b>'.MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_name');
						$price = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
						$price = $price * $actPeople[$order-1];
						echo '  $'.$price;
						echo '</p>';
					}
					$sub = $this->general_lib->get_sub_activities();
					if($sub != ""){
						$actPeople = $this->general_lib->get_people_sub_activity();
						$order = 0;
						foreach ($sub as $key => $actsID) {
							$order++;
							echo "<p>";
							echo '<b> Sub Activities </b>'.MU_Model::getForiegnTableName('activities', array('act_id' => $actsID), 'act_name');
							$price = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
							$price = $price * $actPeople[$order-1];
							echo ' $'.$price;
							echo '</p>';
						}
					}
					/* calculate extra products of activity*/
					$extraactivity = $this->general_lib->get_extra_activities();
					if($extraactivity != ''){
						$amountextra = $this->general_lib->get_amount_extra();
						$order = 0;
						foreach ($extraactivity as $key => $extPro) {
							$order++;
							echo '<b> Extra products </b>'.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $extPro), 'ep_name');
							$epPrice = 	MU_Model::getForiegnTableName('extraproduct', array('ep_id'=>$extPro), 'ep_saleprice');
							$epPrice = $epPrice * $amountextra[$order-1];
							echo ' $'.$epPrice;
						}
					}
				}
				// Calcuation the price of Accommodations
				/*$accs = $this->general_lib->get_accommodation();
				if($accs != ''){
					$singleRoom = $this->general_lib->get_single_room_accommodation();
					$doubleRoomOneBed = $this->general_lib->get_double_room_1bed_accommodation();
					$doubleRoomTwoBed = $this->general_lib->get_double_room_2beds_accommodation();
					$getCheckIn = $this->general_lib->get_checkin_date_accommodation();
					$getCheckOut = $this->general_lib->get_checkout_date_accommodation();
					$accOrders = 0;
					foreach ($accs as $key => $accsID){
						$accOrders++;
						echo '<p>';
						echo '<b>Accommodations : </b>'.MU_Model::getForiegnTableName('accommodation', array('acc_id'=>$accsID), 'acc_name');
						$price = MU_Model::getForiegnTableName('accommodation', array('acc_id'=>$accsID), 'acc_saleprice');						
						if($singleRoom != ''){
							if (isset($singleRoom[$accOrders-1])) {
								$priceSingleRoom = $price * $singleRoom[$accOrders-1];
							}
						}
						if($doubleRoomOneBed != ''){
							if(isset($doubleRoomOneBed[$accOrders-1])){
								$priceDoubleRoomOneBed = $price * $doubleRoomOneBed[$accOrders-1];
							}
						}
						if ($doubleRoomTwoBed != '') {
							if (isset($doubleRoomTwoBed[$accOrders-1])) {
								$priceDoubleRoomTwoBed = $price * $doubleRoomTwoBed[$accOrders-1];
							}
						}
						$price =0;
						if($singleRoom != '' && $doubleRoomOneBed !=''){
							$price = $priceSingleRoom + $priceDoubleRoomOneBed;
							echo '  $'.$price.'<br/>';
						}else if($singleRoom != '' && $doubleRoomOneBed != '' && $doubleRoomTwoBed != ''){
							$price = $priceSingleRoom + $priceDoubleRoomOneBed + $priceDoubleRoomTwoBed;
							echo '  $'.$price.'<br/>';
						}else if($singleRoom != '' && $doubleRoomTwoBed != ''){
							$price = $priceSingleRoom + $priceDoubleRoomTwoBed;
							echo '  $'.$price.'<br/>';
						}else if($doubleRoomOneBed !='' && $doubleRoomTwoBed != ''){
							$price = $priceDoubleRoomOneBed + $priceDoubleRoomTwoBed;
							 echo '  $'.$price.'<br/>';
						}else{
							echo '<br/>'. 'You was not select room'; 
						}
					}
				}*/

				if($this->session->userdata('maintransportation')){
					$tps = $this->session->userdata('maintransportation');
					$tpamount = $this->session->userdata('tpAmountPeople');
					$tpDate = $this->session->userdata('tpDate');
					foreach ($tps as $rows => $tpsID) {
						echo '<b>Transportation : </b>'.MU_Model::getForiegnTableName('transportation', array('tp_id'=>$tpsID), 'tp_name');
						$tpPrice = MU_Model::getForiegnTableName('transportation', array('tp_id'=>$tpsID), 'tp_saleprice');
						$tpPrice = $tpPrice * $tpamount[$rows];
						echo '  $'.$tpPrice;
					}
					if($this->session->userdata('subtransportation')){
						$subtps = $this->session->userdata('subtransportation');
						$tpsubAmountpeople = $this->session->userdata('tpsubAmountpeople');
						foreach ($subtps as $key => $subtpsID) {
							echo '<b>Sub Transportation</b>'.MU_Model::getForiegnTableName('transportation', array('tp_id' => $subtpsID), 'tp_name');
							$tpPrice = MU_Model::getForiegnTableName('transportation', array('tp_id' => $subtpsID), 'tp_saleprice');
							$tpPrice = $tpPrice * $tpsubAmountpeople[$key];
							echo ' $'.$tpPrice;
						}
					}
				}
			?>
			<div class="table-responsive">
			    <table class="table">
			    	<tr>
			    		<td>List of Transportation</td>
			    		<td> : </td>
			    		<td> $ </td>
			    	</tr>
			    	<tr>
			    		<td>List of Extra product order</td>
			    		<td> : </td>
			    		<td> $ </td>
			    	</tr>
			    	<tr>
			    		<td><h3><b>Total</b></h3></td>
			    		<td><h3><b> : </b></h3></td>
			    		<td><h3><b></b></h3></td>
			    	</tr>
			    </table>
			</div>
		</div>
		<!-- end calculate form order -->		
	</div>
	<hr>

	
	<!-- I am in include/fe/customize.php -->
</div>

<?php $this->load->view(INCLUDE_FE.'after_content'); ?>

