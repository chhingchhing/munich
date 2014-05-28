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
        } else {
        	objThis.find('input.check_sub_element').prop('disabled', true);
        	objThis.find('input.check_sub_element').prop('checked', false);
        	objThis.find('select.people_sub_activity').prop('disabled', true).val(0);
        	objThis.find("input.checkin").prop('disabled', true);
        	objThis.find("input.checkout").prop('disabled', true);
        	objThis.find('select.people').prop('disabled', true);
        	objThis.find('select.room_types').prop('disabled', true);
        }
	});	

	$("input.check_sub_element").each(function() {
		var objThis = $(this).parent().parent();
	    if ( $(this).is(':checked') ) {
            objThis.parent().next().find('select.people_sub_activity').prop('disabled', false);
            objThis.next().find('input.amount_extras').prop('disabled', false);
        } else {
        	objThis.parent().next().find('select.people_sub_activity').prop('disabled', true).val(0);
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
        } else {
        	objThis.find('input.check_sub_element').prop('disabled', true);
        	objThis.find('input.check_sub_element').prop('checked', false);
        	objThis.find('select.people_sub_activity').prop('disabled', true).val(0);
        	objThis.find('select.people').prop('disabled', true);
        	objThis.find('select.room_types').prop('disabled', true);
            objThis.find("input.checkin").prop('disabled', true);
            objThis.find("input.checkout").prop('disabled', true);
        }
    });

	$('input.check_sub_element').click(function(){
		var objThis = $(this).parent().parent();
        if ( $(this).is(':checked') ) {
            objThis.parent().next().find('select.people_sub_activity').prop('disabled', false);
            objThis.next().find('input.amount_extras').prop('disabled', false);
        } else {
        	objThis.parent().next().find('select.people_sub_activity').prop('disabled', true).val(0);
        	objThis.next().find('input.amount_extras').prop('disabled', true).val("");
        }
    });

   // Set amount of people on accommodation tab
	$("select#get_amount_people_room").change(function(){
    	var selectedAmountPeople = $(this).val();

    	// Single Room
    	var selectSingle = buildSelectSingleRoom(selectedAmountPeople);
    	var selectObjSingle = $(this).parent().parent().siblings().find("div#single");
    	selectObjSingle.find("select#single").remove();
    	selectObjSingle.append(selectSingle);

    	// Double Room and one bed
    	var selectDoubleOneBed = buildSelectDoubleRoomOneOrTwoBed(selectedAmountPeople, "double_room_1bed", "room_types");
    	var selectObjDouble1Bed = $(this).parent().parent().siblings().find("div#double_room_1bed");
    	selectObjDouble1Bed.find("select#double_room_1bed").remove();
    	selectObjDouble1Bed.append(selectDoubleOneBed);

    	// Double Room and two beds
    	var selectDoubleTwoBed = buildSelectDoubleRoomOneOrTwoBed(selectedAmountPeople, "double_room_2beds", "room_types");
    	var selectObjDouble2Bed = $(this).parent().parent().siblings().find("div#double_room_2beds");
    	selectObjDouble2Bed.find("select#double_room_2beds").remove();
    	selectObjDouble2Bed.append(selectDoubleTwoBed);
    });

});

// Build select option for single room
function buildSelectSingleRoom(options) {
    var $select = $('<select class="form-control" id="single" name="room_types"></select>');
    var $option;

    for (var i=0; i <= options; i++) {
    	if (i == '0') {
    		$option = $('<option value="0">-- Select --</option>');
    	} else {
    		$option = $('<option value="' + i + '">' + i+" Room(s), "+i + ' Guest(s)</option>');
    	}
        $select.append($option);
    }
    return $select;
}

// Build select option for double one bed and two beds
function buildSelectDoubleRoomOneOrTwoBed(options, select_id, select_name) {
	// Initialize the first select selector
    var $select = $('<select class="form-control" id='+select_id+' name='+select_name+'></select>');
    var $option;

    for (var i=0; i <= (options/2); i++) {
    	if (i == '0') {
    		$option = $('<option value="0">-- Select --</option>');
    	} else {
    		$option = $('<option value="' + i + '">' + i+" Room(s), "+ (i * 2) + ' Guest(s)</option>');
    	}
        $select.append($option);
    }
    return $select;
}