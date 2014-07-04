<?php $this->load->view(INCLUDE_FE.'before_content'); ?> 
<?php  echo form_open('site/pagesucceed/'.$this->uri->segment(4), 'class="frmaddpassinfo"'); ?>

<div class="row clearfix">
	<div class="col-lg-12">
		<?php 
			if(isset($getbooking)){
				if($getbooking->num_rows()){
					foreach($getbooking->result() as $bookingValue){
		?>
	<h4 class="infoheader">Your Booking</h4>
				<table class="tb">
					<tr>
						<td class="firstTD"><strong>Booking Date :</strong> </td>
						<td><?php echo $bookingValue->bk_date; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Type :</strong> </td>
						<td><?php echo $bookingValue->bk_type; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Departure :</strong> </td>
						<td><?php echo $bookingValue->bk_arrival_date; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Return :</strong> </td>
						<td><?php echo $bookingValue->bk_return_date; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>People :</strong> </td>
						<td><?php echo $bookingValue->bk_total_people; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Price :</strong> </td>
						<td><?php echo $bookingValue->bk_pay_price; ?> $</td>
					</tr>
				</table>
		<?php
					}
				}
			}
		?>

		<?php 
			if(isset($passDetail)){
				if($passDetail->num_rows()){
					foreach($passDetail->result() as $passval){
		?>
				<h4 class="infoheader">Your information</h4>
				<table class="tb">
					<tr>
						<td class="firstTD"><strong>Your name :</strong> </td>
						<td><?php echo $passval->pass_fname.' '.$passval->pass_lname; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Email :</strong> </td>
						<td><?php echo $passval->pass_email; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Phone :</strong> </td>
						<td><?php echo $passval->pass_phone; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Gender :</strong> </td>
						<td><?php echo $passval->pass_gender; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Country :</strong> </td>
						<td><?php echo $passval->pass_country; ?></td>
					</tr>
					<tr>
						<td class="firstTD"><strong>City :</strong> </td>
						<td><?php echo $passval->pass_city; ?> $</td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Address :</strong> </td>
						<td><?php echo $passval->pass_address; ?> $</td>
					</tr>
					<tr>
						<td class="firstTD"><strong>Special Request :</strong> </td>
						<td><?php echo $passval->pass_about; ?> $</td>
					</tr>
				</table>
		<?php
					}
				}
			}
		?>
	</div>
</div>
<?php $this->load->view(INCLUDE_FE.'after_content'); ?>