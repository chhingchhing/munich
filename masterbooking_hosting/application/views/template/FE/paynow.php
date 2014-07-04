<?php $this->load->view(INCLUDE_FE.'before_content'); ?> 
<div class="row clearfix">
	<h4 class="infoheader">IDEAL PAYMENT SYSTEM</h4>
	<p>I have to waiting for scripting from dutch to implement this functionality, and I don't know about yet.</p>
	<p>How does it works? What is the process of Ideal system?</p>
	<?php 
		echo anchor('site/pagesucceed/'.$this->uri->segment(4), 'Finished it');
	?>
</div>
<?php $this->load->view(INCLUDE_FE.'after_content'); ?>