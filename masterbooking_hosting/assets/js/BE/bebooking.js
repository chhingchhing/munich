//package script
jQuery(function(){
	// disable and enable form in package module
	var vwp = 0;
	jQuery('.frm_booking_view select, .frm_booking_view input[type="text"], .frm_booking_view textarea').prop("disabled", true);
	jQuery('.view_enable_booking').bind("click", function(){
		if( vwp == 0 ){ 
			jQuery('.frm_booking_view select, .frm_booking_view input[type="text"], .frm_booking_view textarea').prop("disabled", false);
			jQuery(".view_enable_booking").text("Disable from Editing");
			vwp = 1;
		}else if( vwp == 1 ){ 
			jQuery('.frm_booking_view select, .frm_booking_view input[type="text"], .frm_booking_view textarea').prop("disabled", true);
			jQuery(".view_enable_booking").text("Enable for editing");
			vwp = 0;
		}
	});
	// while submit form...
	jQuery(".frm_booking_view").bind("submit", function(){
		jQuery('.frm_booking_view select, .frm_booking_view input[type="text"], .frm_booking_view textarea').prop("disabled", false);
	});

	jQuery('.msges, .msgaop').hide();
	jQuery('.frm_bk_eps').submit(function(){
		var eps = jQuery('.es').val();
		var amount = jQuery('.bkap').val();
		if(eps != "" && amount != ""){
			if(jQuery.isNumeric( amount )){
				jQuery('.msges, .msgaop').hide();
				return true;
			}else{
				jQuery('.msges').hide();
				jQuery('.msgaop').show();
			}
		}else{
			if(eps == ""){ jQuery('.msges').show();}else{jQuery('.msges').hide();}
			if(amount == "") { jQuery('.msgaop').show();}else{jQuery('.msgaop').hide();}
		}
		return false;
	});
	
}); 	