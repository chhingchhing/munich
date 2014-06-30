<!DOCTYPE html>
<html lang="en">
    <head>
    	<title>munich-europe.com</title
    	><meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php 
//		echo link_tag("assets/css/External/bootstrap.css");
		echo link_tag("assets/css/External/bootstrap.min.css");
		echo link_tag("assets/css/External/bootstrap-theme.css");
		echo link_tag("assets/css/External/bootstrap-theme.min.css");
		echo link_tag("assets/css/External/bootstrap-responsive.min.css");
		echo link_tag("assets/css/FE/layout.css");
		echo link_tag("assets/css/FE/overwritebootstrap.css");
		// for slideshow
		echo link_tag("assets/css/External/style_slideshow.css");
		echo link_tag("assets/css/External/icons.css");
		//end slideshow
        echo link_tag("assets/datepicker/css/datepicker.css");
	?>
	<base href=<?php echo base_url().$this->uri->segment('1').'/'; ?>>
    </head>
    
<body>
	<?php //echo form_hidden('base_url', base_url().'nl/'); ?>