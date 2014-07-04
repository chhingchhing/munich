jQuery(document).ready(function(){
	//  jquery for feedback

	//  display form
	jQuery(".fb_form").hide();
	jQuery(".btn_fb").bind("click",function(){
		jQuery(".fb_form").slideToggle("slow");
	});

	jQuery(".btnsubmitfb").bind("click",function(e){
		e.preventDefault();
		var fb_dt = jQuery(".form_feedback").serialize();
		var uri = jQuery(".form_feedback").attr("action");
		jQuery.ajax({
			url: uri,
			type: "POST",
			datatype: "text",
			data: fb_dt,
			success:function(response){
				if(response == "t"){
					window.location.reload(true);
				}else{
					alert(response);
					return false;	
				}
			}
		});	
	});
	//  end of jquery for feedback
	
	// general
	jQuery(".error-tf").hide();
	jQuery(".success-tf").hide();
	jQuery(".error-s").hide();
	jQuery(".success-s").hide();
	jQuery(".error-c").hide();
	jQuery(".success-c").hide();
	// end of general

	// script for tellafriend
	jQuery("#tf_submit").bind("click",function(e){
		e.preventDefault();
		var tf_dt = jQuery(".form_tellafriend").serialize();
		var uri_tf = jQuery(".form_tellafriend").attr("action");
		jQuery(".hiddenSTH").show();
		var request = jQuery.ajax({
			url: uri_tf,
			type: "POST",
			datatype: "text",
			data: tf_dt,
			success:function(response){
				if(response == "t"){
					// display message success.
					clearTellaFriendForm();
					jQuery(".hiddenSTH").hide();
					jQuery(".error-tf").hide();
					jQuery(".success-tf").show();
				}else{
					// display message error.
					jQuery(".hiddenSTH").hide();
					jQuery(".error-tf").show();
					jQuery(".success-tf").hide();
				}
			}
		});	
		request.fail(function( jqXHR, textStatus ) { // fail connect to a function in controller AjaxController.php		
			jQuery(".hiddenSTH").hide();
			alert( textStatus+" : request failed." );
		});
		return false;
	});
	// function to clear form of tell a friend
	function clearTellaFriendForm(){
		jQuery("#tff_name").val("");
		jQuery("#tfl_name").val("");
		jQuery("#tfe_name").val("");
		jQuery("#tfef_name").val("");
	}
	// end of script for tellafriend

	// script for subscribe
	jQuery("#s_submit").bind("click",function(e){
		e.preventDefault();
		var sub_dt = jQuery(".form_subscribe").serialize();
		var uri_sub = jQuery(".form_subscribe").attr("action");
		jQuery(".hiddenSTH").show();
		var request = jQuery.ajax({
			url: uri_sub,
			type: "POST",
			datatype: "text",
			data: sub_dt,
			success:function(response){
				if(response == "t"){
					// display message success.
					clearSubscribeForm();
					jQuery(".hiddenSTH").hide();
					jQuery(".error-s").hide();
					jQuery(".success-s").show();
				}else{
					// display message error.
					jQuery(".hiddenSTH").hide();
					jQuery(".error-s").show();
					jQuery(".success-s").hide();
				}
			}
		});	
		request.fail(function( jqXHR, textStatus ) {			
			jQuery(".hiddenSTH").hide();
			alert( textStatus+" : request failed." );
		});
		return false;
	});
	// end of script for subscribe

	// function to clear form of subscribe
	function clearSubscribeForm(){
		jQuery("#fs_name").val("");
		jQuery("#ls_name").val("");
		jQuery("#es_name").val("");
	}
	// end of script for subscribe

	// script for contact
	jQuery("#c_submit").bind("click",function(e){
		e.preventDefault();
		var con_dt = jQuery(".form_contact").serialize();
		var uri_con = jQuery(".form_contact").attr("action");
		jQuery(".hiddenSTH").show();
		var request = jQuery.ajax({
			url: uri_con,
			type: "POST",
			datatype: "text",
			data: con_dt,
			success:function(response){
				if(response == "t"){
					// display message success.
					clearContactForm();
					jQuery(".hiddenSTH").hide();
					jQuery(".error-c").hide();
					jQuery(".success-c").show();
				}else{
					// display message error.
					jQuery(".hiddenSTH").hide();
					jQuery(".error-c").show();
					jQuery(".success-c").hide();
				}
			}
		});
		request.fail(function( jqXHR, textStatus ) {			
			jQuery(".hiddenSTH").hide();
			alert( textStatus+" : request failed." );
		});	
		return false;
	});
	// end of script for contact

	// function to clear form of contact
	function clearContactForm(){
		jQuery("#cf_name").val("");
		jQuery("#ce_name").val("");
		jQuery("#csj_name").val("");
		jQuery("#ctxt_name").val("");
	}
	// end of script for contact
        
        jQuery('.frm_profile').bind('submit', function(e){
            e.preventDefault();
		var url_dt = jQuery(this).serialize();
		var url_pro = jQuery(this).attr("data-url");
//		jQuery(".hiddenSTH").show();
		var request = jQuery.ajax({
			url: url_pro,
			type: "POST",
			datatype: "text",
			data: url_dt,
			success:function(response){
				if(response == "true"){
					return true;
				}else{
				   alert("Pleae fill the require feilds...");
				}
			}
		});
		request.fail(function( jqXHR, textStatus ) {
			alert( textStatus+" : request failed." );
		});	
		return false;
        });
        
    // calculate price when insert people 
    jQuery('.numPassenger').bind('blur', function(){
    	var exs = jQuery('#exservice').attr('data-price');
    	var pkp = jQuery('#pricepk').attr('data-price');
    	var ppl = jQuery('.numPassenger').val();
    	var bkfee = 0;
    	if (jQuery('.bookingfee').is(":checked")){
    		bkfee = jQuery('.bookingfee').val();
    	}
    	pricedisplay(exs, pkp, ppl, bkfee);    	
    });
    // calculate price when checked booking fee
    jQuery('.bookingfee').bind('click',function(){
    	var exs = jQuery('#exservice').attr('data-price');
    	var pkp = jQuery('#pricepk').attr('data-price');
    	var ppl = jQuery('.numPassenger').val();
    	var bkfee = 0;
    	if (jQuery('.bookingfee').is(":checked")){
    		bkfee = jQuery('.bookingfee').val();
    	}
    	pricedisplay(exs, pkp, ppl, bkfee); 
    });
    // function to display the price
    function pricedisplay(exs, pkp, ppl, bkfee){
    	if(! exs) exs = 0;
    	if(! pkp) pkp = 0;
    	if(! ppl) ppl = 1;
    	if(bkfee != 0){ jQuery('.moreprice').html('<p style="padding:5px;">Booking Fee: $'+bkfee+'</p>'); }else{jQuery('.moreprice').html(''); }
    	var totalsprice = (parseInt(exs)+parseInt(pkp)+parseInt(bkfee))*parseInt(ppl);
		jQuery('#ppl').text(ppl);
    	jQuery('#totals').text(totalsprice);
    }
        
    jQuery(".termcondition").bind("click", function(){
        jQuery(".termcondition_content").slideToggle( "slow" );
    });
});


// Customize booking on FE with validation of form
$(function() {
	// Checked box for Customize FE
	$("input.check_main_element").each(function() {
	    var order = $(this).parent().attr("order");
	    var objThis = $(this).parent().siblings().nextUntil("#main_act_order_'"+order+"'");
        if ( $(this).is(':checked') ) {
            objThis.find('input.check_sub_element').prop('disabled', false);
            objThis.find("input.checkin").prop('disabled', false);
            objThis.find("input.checkout").prop('disabled', false);
            objThis.find('select.people').prop('disabled', false);
            objThis.find('select.room_types').prop('disabled', false);
            $(this).parent().parent().siblings().find("input#amount_extra_"+order).prop('disabled', false);
        } else {
        	objThis.find('input.check_sub_element').prop('disabled', true);
        	objThis.find('input.check_sub_element').prop('checked', false);
        	objThis.find('select.people_sub_activity').prop('disabled', true).val(0);
        	objThis.find("input.checkin").prop('disabled', true);
        	objThis.find("input.checkout").prop('disabled', true);
        	objThis.find('select.people').prop('disabled', true);
        	objThis.find('select.room_types').prop('disabled', true);
        	$(this).parent().parent().siblings().find("input#amount_extra_"+order).prop('disabled', true);
        }
	});	

	$("input.check_sub_element").each(function() {
		var objThis = $(this).parent().parent();
	    if ( $(this).is(':checked') ) {
            objThis.parent().next().find('select.people_sub_activity').prop('disabled', false);
            objThis.next().find('select.people').prop('disabled', false);
            objThis.next().find('input.amount_extras').prop('disabled', false);
        } else {
        	objThis.parent().next().find('select.people_sub_activity').prop('disabled', true).val(0);
        	objThis.next().find('select.people').prop('disabled', true).val(0);
        	objThis.next().find('input.amount_extras').prop('disabled', true).val("");
        }
	});	

    $('input.check_main_element').click(function(){
    	var order = $(this).parent().attr("order");
    	var objThis = $(this).parent().siblings().nextUntil("#main_act_order_'"+order+"'");
        if ( $(this).is(':checked') ) {
            objThis.find('input.check_sub_element').prop('disabled', false);
            objThis.find('select.people').prop('disabled', false);
            objThis.find('select.room_types').prop('disabled', false);
            objThis.find("input.checkin").prop('disabled', false);
            objThis.find("input.checkout").prop('disabled', false);
            $(this).parent().parent().siblings().find("input#amount_extra_"+order).prop('disabled', false);
        } else {
        	objThis.find('input.check_sub_element').prop('disabled', true);
        	objThis.find('input.check_sub_element').prop('checked', false);
        	objThis.find('select.people_sub_activity').prop('disabled', true).val(0);
        	objThis.find('select.people').prop('disabled', true);
        	objThis.find('select.room_types').prop('disabled', true);
            objThis.find("input.checkin").prop('disabled', true);
            objThis.find("input.checkout").prop('disabled', true);
            $(this).parent().parent().siblings().find("input#amount_extra_"+order).prop('disabled', true);
        }
    });

	$('input.check_sub_element').click(function(){
		var objThis = $(this).parent().parent();
        if ( $(this).is(':checked') ) {
            objThis.parent().next().find('select.people_sub_activity').prop('disabled', false);
            objThis.next().find('select.people').prop('disabled', false);
            objThis.next().find('input.amount_extras').prop('disabled', false);
        } else {
        	objThis.parent().next().find('select.people_sub_activity').prop('disabled', true).val(0);
        	objThis.next().find('select.people').prop('disabled', true).val(0);
        	objThis.next().find('input.amount_extras').prop('disabled', true).val("");
        }
    });

    $('input.add_pass_amount_pass').prop("disabled", true);
    $("body").on("click", "a#edit_amount_pass", function(event) {
    	event.preventDefault();
    	$('input.add_pass_amount_pass').prop("disabled", false);
    });

    $("body").on("change", "input#add_pass_amount_pass", function(event) {
    	event.preventDefault();
    	var url = $('form[name="frm_personal_info_modal"]').attr("action");
    	var amount_changed = $(this).val();
    	url = url.replace('customize_more_passenger', 'update_sess_amount_people');
    	$.ajax({
    		type: "POST",
    		url: url,
    		dataType: "json",
    		data: {"term" : amount_changed},
    		success: function(response){
    			if (response) {
					var div_sms = '<div class="alert alert-'+response.sms_type+' alert-dismissable">';
					div_sms += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					div_sms += '<strong>'+response.sms_title+'</strong> '+response.sms_value;
					div_sms += '</div>';
					$("div#feedback_bar_modal").append(div_sms);
				}
    		}
    	});
    });

	// Check passenger exists in Customize FE
	$("body").on("click", "input[name='btnPersonalInfoModal']", function(event) {
		var url = $('form[name="frm_personal_info_modal"]').attr("action");
		var data = $('form[name="frm_personal_info_modal"]').serialize();
		$.ajax({
			type: "POST",
			url: url,
			dataType: "json",
			data: data,
			success: function(response) {
				if (response) {
					var div_sms = '<div class="alert alert-'+response.sms_type+' alert-dismissable">';
					div_sms += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					div_sms += '<strong>'+response.sms_title+'</strong> '+response.sms_value;
					div_sms += '</div>';
					$("div#feedback_bar_modal").append(div_sms);
				}
			}
		});
		event.preventDefault();
	});

	// Check validation of Email
	$('.input_email').focusout(function(e) {
        $(this).parent().next().children(":first").remove();
        var sEmail = $(this).val();
        if ($.trim(sEmail).length == 0) {
            $(this).parent().next().append("<span class='error'>Cannot be empty.</span>");
            e.preventDefault();
        } else if (validateEmail(sEmail)) {
        	$(this).parent().next().append("<span class='success'>Email look like good.</span>");
        }
        else {
            $(this).parent().next().append("<span class='error'>Invalid Email Address.</span>");
            e.preventDefault();
        }
    });

	$('.input_require').focusout(function(e) {
        $(this).parent().next().children(":first").remove();
        var value = $(this).val();
        if ($.trim(value).length == 0) {
            $(this).parent().next().append("<span class='error'>Cannot be empty.</span>");
            e.preventDefault();
        }
    });

	// Tooltip
	$("body").on("mouseover", ".theTooltip", function(){
		$(this).tooltip('show');
	});
	
	// Check room type and set default value of a room type
	$("body").on("change", "#room_type_checked", function() {
		if ($(this).is(':checked')) {
			$(this).parent().parent().next().find("input").val(1);
		} else {
			$(this).parent().parent().next().find("input").val('');
		}
	});

});

// Validate Email input
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
}