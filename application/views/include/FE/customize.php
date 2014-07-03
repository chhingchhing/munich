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
			<?php 
				$uri4 = $this->uri->segment('4');
				$menus = array(
					'' => 'Trip Info',
					'transportation' => 'Transportation',
					'accommodation' => 'Accommodation',
					'activities' => 'Activities',
					'extra-service' => 'Extra Services',
					'personal-info' => 'Personal Information',
					'payments' => 'Payment',
				);
				foreach ($menus as $key => $value) { 
					if ($uri4 == $key) { ?>
						<li class='active'><?php echo anchor("site/customizes/$key","$value"); ?></li>
					<?php } else { ?>
						<li><?php echo anchor("site/customizes/$key","$value"); ?></li>
					<?php }
				}
			?>
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

			// Initialize variable
			$tpSum = 0;
			$tpSubSum = 0;
			$sumTpExt = 0;
			$sumAcc = 0;
			$sumAct = 0;
			$sumSubAct = 0;
			$sumActExt = 0;
			$sumExtp = 0;
				// echo "<div class='form-order-customize'>";
					if($this->session->userdata('ftvID')) echo '<b>Festival : </b>'.MU_Model::getForiegnTableName('festival', array('ftv_id'=>$this->session->userdata('ftvID')), 'ftv_name').'<br/>';
					if($this->session->userdata('lcID')) echo '<b>Location : </b>'.MU_Model::getForiegnTableName('location', array('lt_id'=>$this->session->userdata('lcID')), 'lt_name');
				// echo "</div>";
				
				/* get main transportations */
				echo "<div class='form-order-customize'>";
					echo '<h4>Transportation : </h4>';
					$tps = $this->general_lib->get_transportation();
					if ($tps !='') {
						$tpPeople = $this->general_lib->get_people_transportation();
						$tpDepartureDate = $this->general_lib->get_departure_transportation();
						$tpReturnDate = $this->general_lib->get_return_date_transportation();
						echo "<dl>";
						echo "<dt>Transportations:</dt>";
						foreach ($tps as $key => $tpsID) {
							foreach ($tpPeople[$tpsID] as $person) {
								echo "<dd>- ". MU_Model::getForiegnTableName('transportation', array('tp_id' => $tpsID), 'tp_name');
								$tpPrice = MU_Model::getForiegnTableName('transportation', array('tp_id' => $tpsID), 'tp_saleprice');
								$tpPrice = $tpPrice * $person;
								$tpSum += $tpPrice;
								echo ' $ ' .$tpPrice;
								echo "<dd>";
							}
						}
						echo "</dl>";

						/* Calculate the extra products of transportation */
						$tpExtra = $this->general_lib->get_sub_trans_extr_product();
						if ($tpExtra !='') {
							echo "<dl>";
							echo "<dt>Extra Products:</dt>";
							$amountTpExtra = $this->general_lib->get_sub_trans_amount_extra();
							foreach ($tpExtra as $key => $amountExtras) {
								foreach ($amountExtras as $id) {
									foreach ($amountTpExtra as $arrAmount) {
										echo '<dd>- '.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $id), 'ep_name');
										$tpExtrasPrice = MU_Model::getForiegnTableName('extraproduct', array('ep_id'=> $id), 'ep_saleprice');
										$tpExtrasPrice = $tpExtrasPrice * $arrAmount[$id];
										$sumTpExt += $tpExtrasPrice;
										echo ': $'.$tpExtrasPrice;
										echo "</dd>";
									}
								}
							}
							echo "</dl>";
						}
					}
				echo "</div>";
				echo "<div class='form-order-customize'>";
				// Calcuation the price of Accommodations
				echo '<h4>Accommodation : </h4>';
				// echo "<hr/>";
				$acc = $this->general_lib->get_accommodation();
				if($acc != ''){
					$amount_room_booked = $this->general_lib->get_amount_book_room();
					$rooms = $this->general_lib->get_room_type_accommodation();
					$check_in_date = $this->general_lib->get_checkin_date_accommodation();
			   		$check_out_date = $this->general_lib->get_checkout_date_accommodation();
					echo "<dl>";
					echo "<dt>Hotel:</dt>";
					if ($rooms != "") {
						foreach ($acc as $accom_id) {
							foreach ($rooms[$accom_id] as $main_acc) {
								foreach ($main_acc as $rtID) {
									$room = 0;
									foreach ($amount_room_booked[$accom_id] as $array) {
										foreach ($array as $sub_arr) {
											foreach ($sub_arr as $num_rm) {
												if ($num_rm != '') {
													$room = $num_rm;
												}
											}
										}
										if ($check_in_date != '') { 
						   					if (isset($check_in_date[$accom_id])) {
						   						$start_date = $check_in_date[$accom_id];
						   					}
					   					}
										if ($check_out_date != '') { 
						   					if (isset($check_out_date[$accom_id])) {
						   						$end_date = $check_out_date[$accom_id];
						   					} 
					   					}
					   					$nights = $this->general_lib->getAmountDaysBetweenDates($start_date, $end_date);
									}
									$roomType = $this->mod_fecustomize->getAllRoomTypeEachPassenger($rtID)->result();
									foreach ($roomType as $item) {
										$accPrice = ($item->dhht_price * $room) * $nights;
										$sumAcc += $accPrice;
										echo "<dd>- ".$nights. " Nights </dd>";
										echo "<dd>- ".$item->rt_name." (<b>".$item->ht_alias."</b>): $".$accPrice."</dd>";
									}
								}
							}
						}
					} else {
						echo "No accommodation selected";
					}
					echo "</dl>";
					/* calculate extra products of accommodation*/
					$extraAcc = $this->general_lib->get_sub_acc_extr_product();
					if($extraAcc != ''){
						echo "<dl>";
						echo "<dt>Extra Products:</dt>";
						$amountextra = $this->general_lib->get_sub_acc_amount_extra();
						foreach ($extraAcc as $key => $extPro) {
							$amountExtra = 0;
							if ($amountextra != '') {
								foreach ($extPro as $id) {
									foreach ($amountextra as $items) {
										$amountExtra = $items[$id];
									}
									echo '<dd>- '.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $id), 'ep_name');
									$priceExtra = 	MU_Model::getForiegnTableName('extraproduct', array('ep_id'=>$id), 'ep_saleprice');
									$priceExtra = $priceExtra * $amountExtra;
									$sumActExt += $priceExtra;
									echo ': $'.$priceExtra;
									echo '</dd>';
								}
							}
						}
						echo "</dl>";
					}
				}
				echo "</div>";
				echo "<div class='form-order-customize'>";
				// get main activities and calculate price of amounts of activities
				echo '<h4>Activities : </h4>';
				$acts = $this->general_lib->get_main_activities();
				if($acts != ''){
					$actPeople = $this->general_lib->get_people_main_activity();
					echo "<dl>";
					echo "<dt>Activities:</dt>";
					foreach($acts as $key => $actsID){
						foreach ($actPeople[$actsID] as $amount) {
							$passAmount = $amount;
						}
						echo '<dd>- '.MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_name');
						$actPrice = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
						$actPrice = $actPrice * $passAmount;
						$sumAct += $actPrice;
						echo ': $'.$actPrice;
						echo "</dd>";
					}
					echo "</dl>";
					/*   calculation price of sub activities */        
					$sub = $this->general_lib->get_sub_activities();
					if($sub != ""){
						$actPeople = $this->general_lib->get_people_sub_activity();
						echo "<dl>";
						echo "<dt>Sub Activities:</dt>";
						foreach ($sub as $key => $arrActs) {
							foreach ($arrActs as $actsID) {
								foreach ($actPeople as $amount) {
									$passSubAmount = $amount[$actsID];
								}
								echo '<dd>- '.MU_Model::getForiegnTableName('activities', array('act_id' => $actsID), 'act_name');
								$subActPrice = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
								$subActPrice = $subActPrice * $passSubAmount;
								$sumSubAct += $subActPrice;
								echo ': $'.$subActPrice;
								echo '</dd>';
							}
						}
						echo "</dl>";
					}
					/* calculate extra products of activity*/
					$extraactivity = $this->general_lib->get_extra_activities();
					if($extraactivity != ''){
						echo "<dl>";
						echo "<dt>Extra Products:</dt>";
						$amountextra = $this->general_lib->get_amount_extra();
						$order = 0;
						foreach ($extraactivity as $key => $extPro) {
							$order++;
							foreach ($extPro as $id) {
								foreach ($amountextra as $items) {
									echo '<dd>- '.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $id), 'ep_name');
									$epPrice = 	MU_Model::getForiegnTableName('extraproduct', array('ep_id'=>$id), 'ep_saleprice');
									$epPrice = $epPrice * $items[$id];
									$sumActExt += $epPrice;
									echo ': $'.$epPrice;
									echo '</dd>';
								}
								
							}
						}
						echo "</dl>";
					}
				}
				echo "</div>";
				echo "<div class='form-order-customize'>";
				/* get all checked extra products */
				echo '<h4>Extra Products : </h4>';
				$extraProducts = $this->general_lib->get_extra_services();
				if ($extraProducts !='') {
					echo "<dl>";
					$amountExtraProducts = $this->general_lib->get_num_extra_services();
					$expOrder = 0;
					$value = 0;
					foreach ($extraProducts as $key => $extID) {
						$expOrder++;
						if (isset($amountExtraProducts[$extID])) {
		   					foreach ($amountExtraProducts[$extID] as $val) {
		   						$value = $val;
		   					}
		   				}
						echo "<dd>- ". MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $extID), 'ep_name');
						$exPrice = MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $extID), 'ep_saleprice');
						$price = $exPrice * $value;
						$sumExtp += $price;
						echo ' $ ' .$price;
						echo "</dd>";
					}
					echo "</dl>";
				}
				echo "</div>";
				// Booking Fee
				$booking_fee = $this->general_lib->get_booking_fee();
				echo form_hidden('booking_fee_sess', $booking_fee);

				$total = 0;
				$total += $sumAct + $sumSubAct + $sumActExt + $sumAcc + $tpSum + $tpSubSum + $sumTpExt + $sumExtp;
				echo form_hidden('total', $total);
				$total = $total + $booking_fee;
				$this->session->set_userdata('total', $total);
				echo '<h3> Total : $'.$total.'</h3>';
				
				echo form_hidden('has_passenger', $this->session->userdata('has_passenger'));

			?>			
		</div>
		<!-- end calculate form order -->		
	</div>
	<hr>	
	<!-- I am in include/fe/customize.php -->
</div>
<?php $this->load->view(INCLUDE_FE.'after_content'); ?>

