<?php 
  if(! $this->session->userdata('ftvID') && ! $this->session->userdata('lcID') && ! $this->session->userdata('dpd') && ! $this->session->userdata('nop')){
  	redirect('site/booking');
  }
?>
<div class="row clearfix wrap_customize">
<div class="col-sm-12 titleBooking">
	<h1>Booking Tours</h1>
	<h2>Add Extra Services</h2>
</div>
<div class="col-sm-12">
<div class="col-lg-10" style="padding-left: 0px;">
		<div class="mainmadia">
		<?php 
			echo form_open("site/packages/showservice", 'class="frmService"');
			if(isset($packageExtraservice)){
				if($packageExtraservice->num_rows() > 0){
					foreach($packageExtraservice->result() as $service){
		?>
				<div class="media col-lg-12">
				  <div class="col-lg-2 pk_img">
				  	<?php 
					    $imgname = $service->pho_source;
					    echo img(array('src'=>'user_uploads/thumbnail/original/'.$imgname ,'alt'=>'Extra service','class'=>'img-responsive img-thumbnail')); 
					?>
				  </div>
				  <div class="media-body">
				  	<?php 
				  		$checked = false;
				  	    if($this->session->userdata('extraservice')){
				  	    	$epselected = $this->session->userdata('extraservice');
				  	    	if(isset($epselected[$service->ep_id]) && $epselected[$service->ep_id] == $service->ep_id) $checked = true;
				  		}
				  	?>
				    <h4 class="media-heading"><?php echo form_checkbox(array('name' => 'epchecked['.$service->ep_id.']','value'=>set_value('epchecked',$service->ep_id), 'class'=>'checkIt', 'checked' => $checked, 'data-in'=>$service->ep_id)).nbs(3); echo $service->ep_name.nbs(3);  echo '$'.$service->ep_saleprice;?></h4>
				    <p><?php echo $service->ep_bookingtext; ?></p>
				    <p class="col-md-3" style="padding-left:0px;">
				    <?php
				    	// $classamount = 'input'.$service->ep_id;
				    	// echo form_input(array('name'=>'useramount['.$service->ep_id.'][]', 'value'=>set_value('useramount'), 'class' => 'form-control hsamount '.$classamount,'placeholder'=>'0'));
				    	
				    	for($i = 1; $i <= $service->ep_actualstock; $i++){
				    		$selectAmount[$i] = $i;
				    	}

				    	$classamount = 'input'.$service->ep_id;
				    	echo form_dropdown('useramount['.$service->ep_id.']', $selectAmount, '', 'class="form-control hsamount '.$classamount.'"');
				    ?>
				  </div>
				</div>
		<?php
					}

				}else{
					echo "No Extra Services available...";
				}
			}else{
				echo "No Extra Services available...";
			}
		?>
		</div>
		<br />
		<?php 
			$key = "90408752631";
            $pk_id = base64url_encode($key.$this->session->userdata('pkID'));
			echo form_submit(array('name'=>'submitService','value'=>'Continue','class'=>"btn btn-primary btnepscountinue")).nbs(5);
			echo anchor('site/packages/details/'.$pk_id,'Back', 'class="btn btn-default"');
		echo form_close();
		?>
	</div>
	<div class="col-lg-2" style="padding: 0px; border:1px solid #ccc; background:#F5F5F5;border-radius:5px;">
		<h4 class="infoheader" style="padding:5px;border-bottom: 1px dotted #cccccc;">Price</h4>
		<p style="padding:5px;"><b>Package Price: </b>&nbsp;&nbsp; $<?php echo $this->session->userdata('pkprice'); ?> / person</p>
		<p style="padding:5px;"><b>People: </b>&nbsp;&nbsp; <?php echo $this->session->userdata('nop'); ?></p>
		<p style="padding:5px;"><b>Totals Price: </b>&nbsp;&nbsp; $<?php echo $this->session->userdata('pkprice') * $this->session->userdata('nop'); ?> </p>
	</div>
</div>
</div>