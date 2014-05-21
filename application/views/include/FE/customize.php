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
			<?php 

				if($this->session->userdata('ftvID')) echo '<b>Festival : </b>'.MU_Model::getForiegnTableName('festival', array('ftv_id'=>$this->session->userdata('ftvID')), 'ftv_name').'<br/>';
				if($this->session->userdata('lcID')) echo '<b>Location : </b>'.MU_Model::getForiegnTableName('location', array('lt_id'=>$this->session->userdata('lcID')), 'lt_name');
				if($this->session->userdata('mainactivity')){
					$acts = $this->session->userdata('mainactivity');
					$actPeople = $this->session->userdata('peopleAmount');
					foreach($acts as $key => $actsID){
						echo '<p>';
						echo '<b>Activities : </b>'.MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_name');
						$price = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
						$price = $price * $actPeople[$key];
						echo '  $'.$price;
						echo '</p>';
					}
					if($this->session->userdata('subactivity')){
						$sub = $this->session->userdata('subactivity');
						$actPeople = $this->session->userdata('peopleAmount');
						foreach ($sub as $key => $actsID) {
							echo "<p>";
							echo '<b> Sub Activities </b>'.MU_Model::getForiegnTableName('activities', array('act_id' => $actsID), 'act_name');
							$price = MU_Model::getForiegnTableName('activities', array('act_id'=>$actsID), 'act_saleprice');
							$price = $price * $actPeople[$key];
							echo ' $'.$price;
							echo '</p>';
						}
					}
					/* calculate extra products of activity*/
					if($this->session->userdata('extraactivity')){
						$extraactivity = $this->session->userdata('extraactivity');
						$amountextra = $this->session->userdata('amountextras');
						foreach ($extraactivity as $key => $extPro) {
							echo '<b> Extra products </b>'.MU_Model::getForiegnTableName('extraproduct', array('ep_id' => $extPro), 'ep_name');
							$epPrice = 	MU_Model::getForiegnTableName('extraproduct', array('ep_id'=>$actsID), 'ep_saleprice');
							$epPrice = $epPrice * $amountextra[$key];
							echo ' $'.$epPrice;
						}
					}
				}
				
				if($this->session->userdata('mainAccommodation')){
					$accs = $this->session->userdata('mainAccommodation');
					$accPeople = $this->session->userdata('accAmountpeople');
					foreach ($accs as $key => $accsID) {
						echo '<b>Accommodation : </b>'.MU_Model::getForiegnTableName('accommodation', array('acc_id'=>$accsID), 'acc_name');
						$accPrice = MU_Model::getForiegnTableName('accommodation', array('acc_id'=>$accsID), 'acc_saleprice');
						$accPrice = $accPrice * $accPeople[$key];
						echo '  $'.$accPrice;
					}
					if($this->session->userdata('subAccommodation')){
					$sub = $this->session->userdata('subAccommodation');
					$accPeople = $this->session->userdata('accAmountpeople');
					foreach ($sub as $key => $accsID) {
						echo '<b>Sub Accommodation : </b>'.MU_Model::getForiegnTableName('accommodation', array('acc_id'=>$accsID), 'acc_name');
						$accPrice = MU_Model::getForiegnTableName('accommodation', array('acc_id'=>$accsID), 'acc_saleprice');
						$accPrice = $accPrice * $accPeople[$key];
						echo '  $'.$accPrice;
					}
				}
				}

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

