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
						$actPrice = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
						$actPrice = $actPrice * $actPeople[$order-1];
						echo '  $'.$actPrice;
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
							$subActPrice = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
							$subActPrice = $subActPrice * $actPeople[$order-1];
							echo ' $'.$subActPrice;
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
							echo '<b> Extra products : </b>'.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $extPro), 'ep_name');
							$epPrice = 	MU_Model::getForiegnTableName('extraproduct', array('ep_id'=>$extPro), 'ep_saleprice');
							$epPrice = $epPrice * $amountextra[$order-1];
							echo ' $'.$epPrice . '<br/>';
						}
					}
				}
				// Calcuation the price of Accommodations

				/* get main transportations */
				$tps = $this->general_lib->get_transportation();
				if ($tps !='') {
					$tpPeople = $this->general_lib->get_people_transportation();
					$tpDepartureDate = $this->general_lib->get_departure_transportation();
					$tpReturnDate = $this->general_lib->get_return_date_transportation();
					$tpOrder = 0;
					foreach ($tps as $key => $tpsID) {
						$tpOrder++;
						echo '<b>Transportation : </b>'.MU_Model::getForiegnTableName('transportation', array('tp_id' => $tpsID), 'tp_name');
						$tpPrice = MU_Model::getForiegnTableName('transportation', array('tp_id' => $tpsID), 'tp_saleprice');
						$tpPrice = $tpPrice * $tpPeople[$tpOrder-1];
						echo ' $ ' .$tpPrice.'<br/>';
					}
					/*calculate the price of sub transportations */
					$subTP = $this->general_lib->get_sub_transportation();
					if ($subTP !='') {
						$subTPPeople = $this->general_lib->get_people_sub_transportation();
						$tpOrder = 0;
						foreach ($subTP as $key => $subTPID) {
							$tpOrder++;
							echo '<b> Sub Transportation : </b>'.MU_Model::getForiegnTableName('transportation', array('tp_id'=> $subTPID), 'tp_name');
							$subTpPrice = MU_Model::getForiegnTableName('transportation', array('tp_id'=> $subTPID), 'tp_saleprice');
							$subTpPrice = $subTpPrice * $subTPPeople[$tpOrder-1];
							echo ' $ '.$subTpPrice. '<br/>'; 

						}
					}
					/* Calculate the extra products of transportation */
					$tpExtra = $this->general_lib->get_sub_trans_extr_product();
					if ($tpExtra !='') {
						$amountTpExtra = $this->general_lib->get_sub_trans_amount_extra();
						$tpExtraOrder = 0;
						foreach ($tpExtra as $key => $amountExtras) {
							var_dump($amountTpExtra[$amountExtras]);
							$tpExtraOrder++;
							echo '<b> Extra Products : </b>'.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $amountExtras), 'ep_name');
							$tpExtrasPrice = MU_Model::getForiegnTableName('extraproduct', array('ep_id'=> $amountExtras), 'ep_saleprice');
							$tpExtrasPrice = $tpExtrasPrice * $amountTpExtra[$amountExtras];
							echo ' $ '.$tpExtrasPrice.'<br/>';
						}
					}
				}
				/* get all checked extra products */
				$extraProducts = $this->general_lib->get_extra_services();
				if ($extraProducts !='') {
					$amountExtraProducts = $this->general_lib->get_num_extra_services();
					$expOrder = 0;
					foreach ($extraProducts as $key => $extID) {
						$expOrder++;
						if (isset($amountExtraProducts[$extID])) {
		   					foreach ($amountExtraProducts[$extID] as $val) {
		   						$value = $val;
		   					}
		   				}
						echo '<b> Extra Products : </b>'.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $extID), 'ep_name');
						$exPrice = MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $extID) , 'ep_saleprice');
						$exPrice = $exPrice * $value;
						echo ' $ ' .$exPrice .'<br/>';
					}
				}
				$total = 0;
				if(isset($tpPrice)){
					$total = $actPrice + $subActPrice + $epPrice + $tpPrice + $subTpPrice + $tpExtrasPrice + $exPrice;
					echo '<h3> Total : $'.$total.'</h3>';
				}else{
					echo "<br> Total = 0";
				}

			?>
			
		</div>
		<!-- end calculate form order -->		
	</div>
	<hr>

	
	<!-- I am in include/fe/customize.php -->
</div>

<?php $this->load->view(INCLUDE_FE.'after_content'); ?>

