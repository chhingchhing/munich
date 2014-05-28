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

	function get_checkout_date_accommodation()
	{
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

	function get_single_room_accommodation()
	{
		if(!$this->CI->session->userdata('single_room_accommodation'))
			$this->set_single_room_accommodation('');
		return $this->CI->session->userdata('single_room_accommodation');
	}
	function set_single_room_accommodation($single_room_accommodation)
	{
		$this->CI->session->set_userdata('single_room_accommodation',$single_room_accommodation);
	}
	function empty_single_room_accommodation() {
		$this->CI->session->unset_userdata('single_room_accommodation');
	}

	function get_double_room_1bed_accommodation()
	{
		if(!$this->CI->session->userdata('double_room_1bed_accommodation'))
			$this->set_double_room_1bed_accommodation('');
		return $this->CI->session->userdata('double_room_1bed_accommodation');
	}
	function set_double_room_1bed_accommodation($double_room_1bed_accommodation)
	{
		$this->CI->session->set_userdata('double_room_1bed_accommodation',$double_room_1bed_accommodation);
	}
	function empty_double_room_1bed_accommodation() {
		$this->CI->session->unset_userdata('double_room_1bed_accommodation');
	}

	function get_double_room_2beds_accommodation()
	{
		if(!$this->CI->session->userdata('double_room_2beds_accommodation'))
			$this->set_double_room_2beds_accommodation('');
		return $this->CI->session->userdata('double_room_2beds_accommodation');
	}
	function set_double_room_2beds_accommodation($double_room_2beds_accommodation)
	{
		$this->CI->session->set_userdata('double_room_2beds_accommodation',$double_room_2beds_accommodation);
	}
	function empty_double_room_2beds_accommodation() {
		$this->CI->session->unset_userdata('double_room_2beds_accommodation');
	}
        
}
?>