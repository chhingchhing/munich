<?php
class General_lib
{
	var $CI;

  	function __construct()
	{
		$this->CI =& get_instance();
	}

	// Activity session
	function get_main_activities()
	{
		if(!$this->CI->session->userdata('mainactivity'))
			$this->set_main_activities('');
		return $this->CI->session->userdata('mainactivity');
	}
	function set_main_activities($mainactivity)
	{
		$this->CI->session->set_userdata('mainactivity',$mainactivity);
	}
	function empty_main_activities() {
		$this->CI->session->unset_userdata('mainactivity');
	}

	function get_sub_activities()
	{
		if(!$this->CI->session->userdata('subactivity'))
			$this->set_sub_activities('');
		return $this->CI->session->userdata('subactivity');
	}
	function set_sub_activities($subactivity)
	{
		$this->CI->session->set_userdata('subactivity',$subactivity);
	}
	function empty_sub_activities() {
		$this->CI->session->unset_userdata('subactivity');
	}

	function get_extra_activities()
	{
		if(!$this->CI->session->userdata('extraactivity'))
			$this->set_extra_activities('');
		return $this->CI->session->userdata('extraactivity');
	}
	function set_extra_activities($extraactivity)
	{
		$this->CI->session->set_userdata('extraactivity',$extraactivity);
	}
	function empty_extra_activities() {
		$this->CI->session->unset_userdata('extraactivity');
	}

	function get_amount_extra()
	{
		if(!$this->CI->session->userdata('amountextras'))
			$this->set_amount_extra('');
		return $this->CI->session->userdata('amountextras');
	}
	function set_amount_extra($amountextras)
	{
		$this->CI->session->set_userdata('amountextras',$amountextras);
	}
	function empty_amount_extra() {
		$this->CI->session->unset_userdata('amountextras');
	}

	function get_people_sub_activity()
	{
		if(!$this->CI->session->userdata('amount_people_sub_activity'))
			$this->set_people_sub_activity('');
		return $this->CI->session->userdata('amount_people_sub_activity');
	}
	function set_people_sub_activity($amount_people_sub_activity)
	{
		$this->CI->session->set_userdata('amount_people_sub_activity',$amount_people_sub_activity);
	}
	function empty_people_sub_activity() {
		$this->CI->session->unset_userdata('amount_people_sub_activity');
	}

	function get_people_main_activity()
	{
		if(!$this->CI->session->userdata('amount_people_main_activity'))
			$this->set_people_main_activity('');
		return $this->CI->session->userdata('amount_people_main_activity');
	}
	function set_people_main_activity($amount_people_main_activity)
	{
		$this->CI->session->set_userdata('amount_people_main_activity',$amount_people_main_activity);
	}
	function empty_people_main_activity() {
		$this->CI->session->unset_userdata('amount_people_main_activity');
	}

	function get_start_date_activity()
	{
		if(!$this->CI->session->userdata('start_date_activity'))
			$this->set_start_date_activity('');
		return $this->CI->session->userdata('start_date_activity');
	}
	function set_start_date_activity($start_date_activity)
	{
		$this->CI->session->set_userdata('start_date_activity',$start_date_activity);
	}
	function empty_start_date_activity() {
		$this->CI->session->unset_userdata('start_date_activity');
	}

	function get_end_date_activity()
	{
		if(!$this->CI->session->userdata('end_date_activity'))
			$this->set_end_date_activity('');
		return $this->CI->session->userdata('end_date_activity');
	}
	function set_end_date_activity($end_date_activity)
	{
		$this->CI->session->set_userdata('end_date_activity',$end_date_activity);
	}
	function empty_end_date_activity() {
		$this->CI->session->unset_userdata('end_date_activity');
	}

	// Accommodations session
	function get_accommodation()
	{
		if(!$this->CI->session->userdata('accommodation'))
			$this->set_accommodation('');
		return $this->CI->session->userdata('accommodation');
	}
	function set_accommodation($accommodation)
	{
		$this->CI->session->set_userdata('accommodation',$accommodation);
	}
	function empty_accommodation() {
		$this->CI->session->unset_userdata('accommodation');
	}

	function get_sub_acc_extr_product()
	{
		if(!$this->CI->session->userdata('sub_acc_extra_pro'))
			$this->set_sub_acc_extr_product('');
		return $this->CI->session->userdata('sub_acc_extra_pro');
	}
	function set_sub_acc_extr_product($sub_acc_extra_pro)
	{
		$this->CI->session->set_userdata('sub_acc_extra_pro',$sub_acc_extra_pro);
	}
	function empty_sub_acc_extr_product() {
		$this->CI->session->unset_userdata('sub_acc_extra_pro');
	}

	function get_sub_acc_amount_extra()
	{
		if(!$this->CI->session->userdata('amount_acc_extra'))
			$this->set_sub_acc_amount_extra('');
		return $this->CI->session->userdata('amount_acc_extra');
	}
	function set_sub_acc_amount_extra($amount_acc_extra)
	{
		$this->CI->session->set_userdata('amount_acc_extra',$amount_acc_extra);
	}
	function empty_sub_acc_amount_extra() {
		$this->CI->session->unset_userdata('amount_acc_extra');
	}

	function get_people_accommodation()
	{
		if(!$this->CI->session->userdata('amount_people_accommodation'))
			$this->set_people_accommodation('');
		return $this->CI->session->userdata('amount_people_accommodation');
	}
	function set_people_accommodation($amount_people_accommodation)
	{
		$this->CI->session->set_userdata('amount_people_accommodation',$amount_people_accommodation);
	}
	function empty_people_accommodation() {
		$this->CI->session->unset_userdata('amount_people_accommodation');
	}

	function get_checkin_date_accommodation()
	{
		if(!$this->CI->session->userdata('checkin_accommodation'))
			$this->set_checkin_date_accommodation('');
		return $this->CI->session->userdata('checkin_accommodation');
	}
	function set_checkin_date_accommodation($checkin_accommodation)
	{
		$this->CI->session->set_userdata('checkin_accommodation',$checkin_accommodation);
	}
	function empty_checkin_date_accommodation() {
		$this->CI->session->unset_userdata('checkin_accommodation');
	}

	function get_checkout_date_accommodation(){
		if(!$this->CI->session->userdata('checkout_accommodation'))
			$this->set_checkout_date_accommodation('');
		return $this->CI->session->userdata('checkout_accommodation');
	}
	function set_checkout_date_accommodation($checkout_accommodation)
	{
		$this->CI->session->set_userdata('checkout_accommodation',$checkout_accommodation);
	}
	function empty_checkout_date_accommodation() {
		$this->CI->session->unset_userdata('checkout_accommodation');
	}

	function get_room_type_accommodation()
	{
		if(!$this->CI->session->userdata('room_types_acc'))
			$this->set_room_type_accommodation('');
		return $this->CI->session->userdata('room_types_acc');
	}
	function set_room_type_accommodation($room_types_acc)
	{
		$this->CI->session->set_userdata('room_types_acc',$room_types_acc);
	}
	function empty_room_type_accommodation() {
		$this->CI->session->unset_userdata('room_types_acc');
	}

	function get_amount_book_room()
	{
		if(!$this->CI->session->userdata('amount_book_room'))
			$this->set_amount_book_room('');
		return $this->CI->session->userdata('amount_book_room');
	}
	function set_amount_book_room($amount_book_room)
	{
		$this->CI->session->set_userdata('amount_book_room',$amount_book_room);
	}
	function empty_amount_book_room() {
		$this->CI->session->unset_userdata('amount_book_room');
	}

	// Transportation session
	function get_transportation()
	{
		if(!$this->CI->session->userdata('transportation'))
			$this->set_transportation('');
		return $this->CI->session->userdata('transportation');
	}
	function set_transportation($transportation)
	{
		$this->CI->session->set_userdata('transportation',$transportation);
	}
	function empty_transportation() {
		$this->CI->session->unset_userdata('transportation');
	}

	function get_sub_transportation()
	{
		if(!$this->CI->session->userdata('sub_transportation'))
			$this->set_sub_transportation('');
		return $this->CI->session->userdata('sub_transportation');
	}
	function set_sub_transportation($sub_transportation)
	{
		$this->CI->session->set_userdata('sub_transportation',$sub_transportation);
	}
	function empty_sub_transportation() {
		$this->CI->session->unset_userdata('sub_transportation');
	}

	function get_departure_transportation()
	{
		if(!$this->CI->session->userdata('departure_transportation'))
			$this->set_departure_transportation('');
		return $this->CI->session->userdata('departure_transportation');
	}
	function set_departure_transportation($departure_transportation)
	{
		$this->CI->session->set_userdata('departure_transportation',$departure_transportation);
	}
	function empty_departure_transportation() {
		$this->CI->session->unset_userdata('departure_transportation');
	}

	function get_return_date_transportation()
	{
		if(!$this->CI->session->userdata('return_date_transportation'))
			$this->set_return_date_transportation('');
		return $this->CI->session->userdata('return_date_transportation');
	}
	function set_return_date_transportation($return_date_transportation)
	{
		$this->CI->session->set_userdata('return_date_transportation',$return_date_transportation);
	}
	function empty_return_date_transportation() {
		$this->CI->session->unset_userdata('return_date_transportation');
	}

	function get_people_transportation()
	{
		if(!$this->CI->session->userdata('people_transportation'))
			$this->set_people_transportation('');
		return $this->CI->session->userdata('people_transportation');
	}
	function set_people_transportation($people_transportation)
	{
		$this->CI->session->set_userdata('people_transportation',$people_transportation);
	}
	function empty_people_transportation() {
		$this->CI->session->unset_userdata('people_transportation');
	}

	function get_people_sub_transportation()
	{
		if(!$this->CI->session->userdata('people_sub_transportation'))
			$this->set_people_sub_transportation('');
		return $this->CI->session->userdata('people_sub_transportation');
	}
	function set_people_sub_transportation($people_sub_transportation)
	{
		$this->CI->session->set_userdata('people_sub_transportation',$people_sub_transportation);
	}
	function empty_people_sub_transportation() {
		$this->CI->session->unset_userdata('people_sub_transportation');
	}

	function get_sub_trans_extr_product()
	{
		if(!$this->CI->session->userdata('sub_trans_extra_pro'))
			$this->set_sub_trans_extr_product('');
		return $this->CI->session->userdata('sub_trans_extra_pro');
	}
	function set_sub_trans_extr_product($sub_trans_extra_pro)
	{
		$this->CI->session->set_userdata('sub_trans_extra_pro',$sub_trans_extra_pro);
	}
	function empty_sub_trans_extr_product() {
		$this->CI->session->unset_userdata('sub_trans_extra_pro');
	}

	function get_sub_trans_amount_extra()
	{
		if(!$this->CI->session->userdata('amount_trans_extra'))
			$this->set_sub_trans_amount_extra('');
		return $this->CI->session->userdata('amount_trans_extra');
	}
	function set_sub_trans_amount_extra($amount_trans_extra)
	{
		$this->CI->session->set_userdata('amount_trans_extra',$amount_trans_extra);
	}
	function empty_sub_trans_amount_extra() {
		$this->CI->session->unset_userdata('amount_trans_extra');
	}
	// Extra-service session
	function get_extra_services()
	{
		if(!$this->CI->session->userdata('extra_services'))
			$this->set_extra_services('');
		return $this->CI->session->userdata('extra_services');
	}
	function set_extra_services($extra_services)
	{
		$this->CI->session->set_userdata('extra_services',$extra_services);
	}
	function empty_extra_services() {
		$this->CI->session->unset_userdata('extra_services');
	}

	function get_num_extra_services()
	{
		if(!$this->CI->session->userdata('num_extra_services'))
			$this->set_num_extra_services('');
		return $this->CI->session->userdata('num_extra_services');
	}
	function set_num_extra_services($num_extra_services)
	{
		$this->CI->session->set_userdata('num_extra_services',$num_extra_services);
	}
	function empty_num_extra_services() {
		$this->CI->session->unset_userdata('num_extra_services');
	}

	function get_index_extra_service()
	{
		if(!$this->CI->session->userdata('index_extra_service'))
			$this->set_index_extra_service('');
		return $this->CI->session->userdata('index_extra_service');
	}
	function set_index_extra_service($index_extra_service)
	{
		$this->CI->session->set_userdata('index_extra_service',$index_extra_service);
	}
	function empty_index_extra_service() {
		$this->CI->session->unset_userdata('index_extra_service');
	}

	// Personal Information session
	function get_personalInfo_message()
	{
		if(!$this->CI->session->userdata('personalInfo_sms'))
			$this->set_personalInfo_message('');
		return $this->CI->session->userdata('personalInfo_sms');
	}
	function set_personalInfo_message($personalInfo_sms)
	{
		$this->CI->session->set_userdata('personalInfo_sms',$personalInfo_sms);
	}
	function empty_personalInfo_message() {
		$this->CI->session->unset_userdata('personalInfo_sms');
	}

	// Booking Fee session
	function get_booking_fee()
	{
		if(!$this->CI->session->userdata('booking_fee'))
			$this->set_booking_fee('');
		return $this->CI->session->userdata('booking_fee');
	}
	function set_booking_fee($booking_fee)
	{
		$this->CI->session->set_userdata('booking_fee',$booking_fee);
	}
	function empty_booking_fee() {
		$this->CI->session->unset_userdata('booking_fee');
	}

	// Get amount days of between dates, checkin and checkout
	function getAmountDaysBetweenDates($start, $end) {
		$start_ts = strtotime($start);
		$end_ts = strtotime($end);
		$diff = $end_ts - $start_ts;
		return round($diff / 86400);
	}
        
}
?>