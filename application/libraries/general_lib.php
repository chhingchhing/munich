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
        
}
?>