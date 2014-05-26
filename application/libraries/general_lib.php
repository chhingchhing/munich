<?php
class General_lib
{
	var $CI;

  	function __construct()
	{
		$this->CI =& get_instance();
	}

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
        
}
?>