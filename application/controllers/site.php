<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MU_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('general_lib');

        $this->load->model(array('mod_index','mod_booking','mod_profilefe','mod_fepackage','mod_fecustomize'));
    }

    /*
    * index function is a function for load the default page
    * @noparam
    * Load index.php in folder view
    */

	public function index($menu_id = false)
	{
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['site_setting'] = "default";
		$this->load->view('index',$fe_data);
	}
	/*
	* function redirect from route.php in folder config
	* public function page
	* display the page by id
	* used table content and menu
	* load view index.php
	*/
	public function page(){
		if($this->uri->segment(4)){ $menu_id = $this->uri->segment(4); }elseif($this->uri->segment(3)){ $menu_id = $this->uri->segment(3); }else{ $menu_id = $this->uri->segment(2); }
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['content_fe'] = $this->mod_index->getContentById($menu_id);
		$fe_data['site_setting'] = $this->getTemplate($menu_id);
		$this->load->view('index',$fe_data);
	}
     // add more passenger
	public function morepassenger(){
		$passID = $this->session->userdata('passengerid');
		$bkID = $this->input->post('txtBooking');
		if ($this->input->post('addmore_profile')) {
			// var_dump($this->input->post()); die();
			$config = array(
			  array(
			  	'field' => 'fname',
			  	'label' => 'First Name',
			  	'rules' => 'trim|required'
			  ),
              array(
              	'field' => 'lname',
              	'label' => 'Last Name',
              	'rules' => 'trim|required'
              ),
              array(
              	'field' => 'password',
              	'label' => 'Password',
              	'rules' => 'trim|required'
              ),
              array(
              	'field' => 'email',
              	'label' => 'Email',
              	'rules' => 'trim|required'
              ),
              array(
              	'field' => 'phone', 
              	'label' => 'Phone Number',
              	'rules' => 'trim|required'
              ),
              array(
              	'field' => 'address',
              	'label' => 'Address',
              	'rules' => 'trim|required'
              ),
              array(
              	'field' => 'company',
              	'label' => 'Company',
              	'rules' => 'trim|required'
              ),
              array(
              	'field' => 'gender',
              	'label' => 'Gener',
              	'rules' => 'trim|required'
              ),
              array(
              	'field' => 'txtStatus',
              	'label' => 'Status',
              	'rules' => 'trim|required'
              ),
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() == FALSE){
			$this->session->set_userdata('create', show_message('Please check your completed form!', 'error'));
			}else{
				$insert['pass_fname'] =   $this->input->post('fname');
				$insert['pass_lname'] 	=   $this->input->post('lname');
				$insert['pass_password'] =   $this->input->post('password');
				$insert['pass_email'] =   $this->input->post('email');
				$insert['pass_phone'] =   $this->input->post('phone');
				$insert['pass_address'] =   $this->input->post('address');
				$insert['pass_company'] =   $this->input->post('company');
				$insert['pass_gender'] =   $this->input->post('gener');
				$insert['pass_status'] = $this->input->post('txtStatus');
				$insert['pass_deleted'] = 0;
			  	$resulf = $this->mod_booking->getMorePassenger($insert);
			    if($resulf){
			    	$accompany = MU_Model::getForiegnTableName("passenger_booking", array('pbk_bk_id' => $bkID, 'pbk_pass_id' => $passID), 'pbk_pass_come_with');
			        $accompany = unserialize($accompany);
			        $newaccompany = $accompany;
			        $newaccompany[$resulf] = $resulf;			        
			        $newaccompany = serialize($newaccompany);
			        $updatepassengerbooking = $this->mod_booking->updateaccompany($newaccompany, $bkID, $passID);
					if($updatepassengerbooking){
					   $this->session->set_userdata('create', show_message('Your data input was successfully.', 'success'));
			        }else{
			           $this->session->set_userdata('create', show_message('Cannot insert or update you passenger!', 'error'));	
			        }
			    }
	        }
	    }else{
	    	$this->session->set_userdata('create', show_message('Please check your completed form!', 'error'));
	    }
	    redirect('site/profile');
	}
	public function export_eticket() {
        $fe_data['users'] = $this->mod_index->exportAllEtichet('user');
        $fe_data['site_setting'] = "export_eticket";
        $this->load->view('index', $fe_data);
    }

	/*
	* public function getTemplate()
	* @param menu_id (int)
	* used table content
	* return $tmpl
	*/
	public function getTemplate($menu_id){
		$tmpl = "";
		$template = $this->mod_index->getContentTemplate($menu_id);
		if($template->num_rows() > 0){
			foreach($template->result() as $value){
				$tmpl = $value->con_template;
			}
			return $tmpl;
		}
		return $tmpl;
	}

	/*
	* public function feedback()
	* @noparam
	* used table feedback
	* return object
	*/
	public function feedback($view_feedback = false){
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		if($view_feedback != false){
			if( ! file_exists('application/views/include/FE/'.$view_feedback.'.php') ){
				show_404();
			}
			$fe_data['single_fb'] = $this->view_feedback($view_feedback);
			$fe_data['back_to'] = 'page/'.$view_feedback; // wrong
			$fe_data['site_setting'] = "view_feedback";
		}else{
			$fe_data['site_setting'] = "feedback";
			$fe_data['feedback'] = $this->mod_index->getFeedback();
		}
		$this->load->view('index', $fe_data);
	}
        
        public function  profile(){
            $fe_data['title'] = "profile user";
            $fe_data['menu_fe'] = $this->mod_index->getAllMenu();
            $fe_data['site_setting'] = "profile";
            $passegnger_id = $this->session->userdata('passengerid');
            $fe_data['old_gender'] = array('' => '-- Select --', 'F' => 'Female', 'M' => 'Male');
            $fe_data['old_txtStatus'] = array('0' => 'Unpublished','1' => 'Published');
            $fe_data['profile'] = $this->mod_profilefe->pass_profilefe($passegnger_id);
            $fe_data['passengerbooking_info'] = $this->mod_profilefe->passenger_bookedform($passegnger_id);
            $this->load->view('index',$fe_data);
            if ($this->input->post('frm_profile')){      
                    $fname      =   $this->input->post('old_firstname');
                    $lname      =   $this->input->post('old_lastname');
                    $email      =   $this->input->post('old_email');
                    $phonenum   =   $this->input->post('old_phone');
                    $address    =   $this->input->post('old_address');
                    $company    =   $this->input->post('old_company');
                    $gender     =   $this->input->post('old_gender');
                    $get_txtStatus      = $this->input->post('old_txtStatus');
                    $profileupgrate = $this->mod_profilefe->upgrate_profile($passegnger_id, $fname,$lname,$email,$phonenum,$address,$company,$gender,$get_txtStatus);
                    if($profileupgrate > 0){
                        $this->session->set_userdata('create', show_message('Your data update was successfully.', 'success'));
                        redirect('site/profile');
                     }   
            }
        }
        
        
        /*
	* public function view_feedback
	* @param $fb_id (int)
	* return object of feedback
	* table feedback
	*/
	public function view_feedback($fb_id){
		return $this->mod_index->getFeedbackById($fb_id);
	}

	/*
	* public function contact()
	* @noparam
	* load view object
	*/
	public function contact(){
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['site_setting'] = "contact";
		$fe_data['contact'] = $this->mod_index->getAdminProfile();
		$this->load->view('index', $fe_data);
	}

	/*
	* public function booking
	* @param $include default (false)
	* load view booking
	*/
	public function booking($include = false, $param2 = false){
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['getLocation'] = $this->mod_booking->getLocation();
		$fe_data['site_setting'] = "booking";
		if($include != false){
			if( ! file_exists('application/views/include/FE/booking/'.$include.'.php') ){
				show_404();
			}
			if($param2 == false){
				$this->session->set_userdata('ftvID', $this->input->post('ftv_id'));
				$this->session->set_userdata('lcID', $this->input->post('location_id'));
			}else{
				$salt = "90408752631";
                $decrypted_id = base64_decode($param2);
                $decrypted_id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id);
                if(is_numeric($decrypted_id)){
                	$fe_data['getFtvByLcID'] = $this->mod_booking->getFtvByLcID($decrypted_id);
                }else{
                	$fe_data['param2error'] = "error";
                }				
			}
			$fe_data['include_type'] = $include;
		}else{
			// if($this->session->userdata('ftvID')) $this->session->unset_userdata('ftvID');
			// if($this->session->userdata('lcID')) $this->session->unset_userdata('lcID');
			$fe_data['include_type'] = 'first';
			$fe_data['festival'] = $this->mod_booking->getFestival();
		}
		$this->load->view('index', $fe_data);
	}

	/**
     * @insert a new array member at a given index
     * @param array $array
     * @param mixed $new_element
     * @param int $index
     * @return array
     */
     function insertArrayIndex($array, $new_element, $index) {
        $array[$index] = $new_element;
        return $array;
     }

     /**
	 * Clear all session of storing array
     */
     public function clear_all_for_activity() {
     	$this->general_lib->empty_main_activities();
     	$this->general_lib->empty_sub_activities();
     	$this->general_lib->empty_extra_activities();
     	$this->general_lib->empty_amount_extra();
     	$this->general_lib->empty_people_sub_activity();
     	$this->general_lib->empty_people_main_activity();
     	$this->general_lib->empty_start_date_activity();
     	$this->general_lib->empty_end_date_activity();
     }

     /**
	 * Clear all session of storing array
     */
     public function clear_all_for_accommodation() {
     	$this->general_lib->empty_people_accommodation();
     	$this->general_lib->empty_accommodation();
     	$this->general_lib->empty_checkin_date_accommodation();
     	$this->general_lib->empty_checkout_date_accommodation();
     	$this->general_lib->empty_sub_acc_amount_extra();
     	$this->general_lib->empty_sub_acc_extr_product();
     }

     /**
	* Clear all session for storing array of transportation
     */
	public function clear_all_for_transportation() {
		$this->general_lib->empty_transportation();
		$this->general_lib->empty_sub_transportation();
		$this->general_lib->empty_departure_transportation();
		$this->general_lib->empty_return_date_transportation();
		$this->general_lib->empty_people_transportation();
		$this->general_lib->empty_people_sub_transportation();
		$this->general_lib->empty_sub_trans_extr_product();
		$this->general_lib->empty_sub_trans_amount_extra();
	}

	/**
	* Clear all session for storing array of extra services
     */
	public function clear_all_for_extra_services() {
		$this->general_lib->empty_extra_services();
		$this->general_lib->empty_num_extra_services();
	}
        
    /*
	* public function customize
	* @param $display_page default (false)
	* load template customizes and include customize
	*/
	public function customizes($display_page = false){
		// $this->session->sess_destroy();
		if($display_page == "customizeTrip"){
			$this->customizeTrip();
			redirect('site/customizes/activities');
		}
		if ($display_page == "activities") {
			if($this->input->post('btnActivity')){
				$this->clear_all_for_activity();
				$this->clickCustomizeActivity();

				redirect('site/customizes/accommodation');
			}else{
				$fe_data['recordActivities'] = $this->customizeActivity();
			}
		}
		if ($display_page == "accommodation") {
			if($this->input->post('btnAccommodation')){	
				$this->clear_all_for_accommodation();
				$this->clickCustomizeAccommodation();
 
				redirect('site/customizes/transportation');
			}else{
				$fe_data['opt_room_types'] = array("" => "-- Select --");
		        foreach ($this->mod_fecustomize->getAllRoomType()->result() as $room_type)
		        {
		            // $fe_data['opt_room_types'][$room_type->rt_id] = $room_type->rt_name ." (Amount People: $room_type->rt_people_per_room : $room_type->rt_description) ";
		            $fe_data['opt_room_types'][$room_type->rt_id] = "- ".$room_type->rt_name ." (Amount People: $room_type->rt_people_per_room) ";
		        }

		        $fe_data['room_types'] = $this->mod_fecustomize->getAllRoomType();
				$fe_data['recordAccommodation'] = $this->customizeAccommodation();
			}	
		}
		if($display_page == "transportation"){
			if($this->input->post('btnTransportation')){
				$this->clear_all_for_transportation();
				$this->clickCustomizeTransportation();

				redirect('site/customizes/extra-service');
			}else{
				$fe_data['recordTransportation'] = $this->customizeTransportation();
			}
		}
		if($display_page == "extra-service"){
			if($this->input->post('btnExtraService')){
				$this->clear_all_for_extra_services();
				$this->clickCustomizeExtraService();

				redirect('site/customizes/personal-info');
			}else{
				$fe_data['recordExtraProducts'] = $this->customizeExtra_service();
				foreach ($fe_data['recordExtraProducts'] as $extra) {
					$extra_index[] = $extra['ep_id']; 
				}
				$this->general_lib->set_index_extra_service($extra_index);
			}
		}
		if ($display_page == "personal-info") {
			if ($this->session->userdata('new_passenger_id') OR $this->session->userdata('passenger')) {
				$this->general_lib->empty_personalInfo_message();
			}
			if($this->input->post('btnPersonalInfo')){	
				$this->general_lib->empty_personalInfo_message();
				// $this->clear_all_for_personal_info();

				$addpassenger  = array(
					array(
						'field' => 'pfname',
						'label' => 'Passenger firstname',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'plname',
						'label' => 'Passenger lastname',
						'rules' => 'trim|required'
					), 
					);	
				$this->form_validation->set_rules($addpassenger);
				if($this->form_validation->run() == FALSE){
					$arr_errors = array(
						"success" => false,
						"sms_type" => "warning",
						"sms_title" => "Warming!",
						"sms_value" => "Sorry! Please check the data you have input. There are something wrong."
					);
					$this->general_lib->set_personalInfo_message($arr_errors);

					$fe_data['arr_messages'] = $this->general_lib->get_personalInfo_message();
					$fe_data['passenger_info'] = $this->customizePersonal_info();
				}else{	
					$passengerInfo = array(
						'pass_fname'        => $this->input->post('pfname'),
			            'pass_lname'        => $this->input->post('plname'),
			            'pass_email'        => $this->input->post('pemail'),
			            'pass_phone'        => $this->input->post('phphone'),
			            'pass_mobile'       => $this->input->post('pmobile'),
			            'pass_country'      => $this->input->post('pcountry'),
			            'pass_address'      => $this->input->post('paddress'),
			            'pass_company'      => $this->input->post('pcompany'),
			            'pass_gender'       => $this->input->post('pgender'),
			            'pass_status'       => 1,
			            'pass_deleted'      => 0,
					);
					$result  = $this->mod_fecustomize->personal_information($passengerInfo);
					if (!$result) {
						$arr_errors = array(
							"success" => false,
							"sms_type" => "danger",
							"sms_title" => "Error!",
							"sms_value" => "Sorry! That email is already registered. Please login before you booking"
						);
						$this->general_lib->set_personalInfo_message($arr_errors);
						redirect('site/customizes/personal-info');
					} else {
						$newPass = array(
							'pass_id' => $result
						);
						$this->session->set_userdata("new_passenger_id", $newPass);
						redirect('site/customizes/payments');	
					}			
				}

			}else{
				$fe_data['arr_messages'] = $this->general_lib->get_personalInfo_message();
				$fe_data['passenger_info'] = $this->customizePersonal_info(); 
			}
		}
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['site_setting'] = "customizes";

		$this->load->view('index', $fe_data);
	}

	/*
	* public function customize trip information
	* @param 
	* load template customize booking and include all step of customize booking
	*/
	public function customizeTrip(){
		if($this->input->post('btnTripInfo')){
			if($this->input->post('people')){
				$this->session->set_userdata('people', $this->input->post('people'));
			}else{
				$this->session->set_userdata('people', "");
			}
			if($this->input->post('txtFrom')){
				$this->session->set_userdata('txtFrom', $this->input->post('txtFrom'));
			}else{
				$this->session->set_userdata('txtFrom', "");
			}
			if($this->input->post('txtTo')){
				$this->session->set_userdata('txtTo', $this->input->post('txtTo'));
			}else{
				$this->session->set_userdata('txtTo', "");
			}	
		}
		return true;	
	} 
	// function convertDateToRange for customize on the front end
    function convertDateToRange($findDate, $from_date, $end_date, $step = '+1 day', $format = 'Y-m-d' ) {
        $dates = array();
        $current = strtotime($from_date);
        $last = strtotime($end_date);
        while( $current <= $last ) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        $std = in_array($findDate[0], $dates, true);
        $ed = in_array($findDate[1], $dates, true);
        if($std OR $ed){
            return true;
        }
        return false;
    } 
	// function convertDateToRangeSub for customize on the front end
    function convertDateToRangeSub($findDate, $from_date, $end_date, $step = '+1 day', $format = 'Y-m-d' ) {
        $dates = array();
        $current = strtotime($from_date);
        $last = strtotime($end_date);
        while( $current <= $last ) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        $std = in_array($findDate[0], $dates, true);
        $ed = in_array($findDate[1], $dates, true);
        if($std OR $ed){
            return true;
        }
        return false;
    } 
	// function convertDateToRangeFromFE for customize on the front end
    function convertDateToRangeFromFE($avalableday, $from_date, $end_date, $step = '+1 day', $format = 'Y-m-d' ) {
        $dates = array();
        $current = strtotime($from_date);
        $last = strtotime($end_date);
        $avalableOption = array();
        $avalableOption[''] = '--- select ---';
        while( $current <= $last ) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
  		foreach($dates as $day){
  			$currentday = strtotime(date("Y-m-d"));
  			$theday = strtotime($day);
  			if($currentday <= $theday){
  				$getday = getdate(strtotime($day));
  				if($getday['weekday'] == 'Monday'){
  					if($avalableday['monday'] == 1){
  						$avalableOption[$day] = $day. ' / ' . $getday['weekday'];
  					}
  				}
  				if($getday['weekday'] == 'Tuesday'){
  					if($avalableday['tuesday'] == 1){
  						$avalableOption[$day] = $day. ' / ' . $getday['weekday'];
  					}
  				}
  				if($getday['weekday'] == 'Wednesday'){
  					if($avalableday['wednesday'] == 1){
  						$avalableOption[$day] = $day. ' / ' . $getday['weekday'];
  					}
  				}
  				if($getday['weekday'] == 'Thursday'){
  					if($avalableday['thursday'] == 1){
  						$avalableOption[$day] = $day. ' / ' . $getday['weekday'];
  					}
  				}
  				if($getday['weekday'] == 'Friday'){
  					if($avalableday['friday'] == 1){
  						$avalableOption[$day] = $day. ' / ' . $getday['weekday'];
  					}
  				}
  				if($getday['weekday'] == 'Saturday'){
  					if($avalableday['saturday'] == 1){
  						$avalableOption[$day] = $day. ' / ' . $getday['weekday'];
  					}
  				}
  				if($getday['weekday'] == 'Sunday'){
  					if($avalableday['sunday'] == 1){
  						$avalableOption[$day] = $day. ' / ' . $getday['weekday'];
  					}
  				}
  			}
        }
  		return $avalableOption;
    }
	public function customizeActivity(){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$activites = $this->mod_fecustomize->trip_information($this->session->userdata('ftvID'), $this->session->userdata('lcID'));
		$records = array();
		if($activites->num_rows() > 0){
			foreach($activites->result() as $act){
				$recodeavaliable = $this->convertDateToRange($findate, $act->start_date, $act->end_date);				
				if($recodeavaliable){
					$avRecord = json_decode(json_encode($act), true); 
					array_push($records, $avRecord);
				}
			}
		}
		
		return $records;
	}
	public function clickCustomizeActivity() {
		if ($this->input->post('checkbox_activity')) {
			foreach ($this->input->post('checkbox_activity') as $element) {
				$arr_mainactivity = $this->general_lib->get_main_activities();
		        $new_arr_mainactivity = $this->insertArrayIndex($arr_mainactivity, $element, $element);
		        $this->general_lib->set_main_activities($new_arr_mainactivity);
			}
		}

		$this->general_lib->set_start_date_activity($this->input->post('txtFrom'));
		$this->general_lib->set_end_date_activity($this->input->post('txtTo'));
		
		if ($this->input->post('checkbox_subactivity')) {
			foreach ($this->input->post('checkbox_subactivity') as $element) {
				$arr_subactivity = $this->general_lib->get_sub_activities();
		        $new_arr_subactivity = $this->insertArrayIndex($arr_subactivity, $element, $element);
		        $this->general_lib->set_sub_activities($new_arr_subactivity);
			}
		}

		if ($this->input->post('checkbox_extra')) {
			foreach ($this->input->post('checkbox_extra') as $element) {
				$arr_extra_activity = $this->general_lib->get_extra_activities();
		        $new_arr_extra_activity = $this->insertArrayIndex($arr_extra_activity, $element, $element);
		        $this->general_lib->set_extra_activities($new_arr_extra_activity);
			}
		}
		$this->general_lib->set_amount_extra($this->input->post('amountextras'));
		$this->general_lib->set_people_sub_activity($this->input->post('actPeopleSubActivity'));
		$this->general_lib->set_people_main_activity($this->input->post('actPeopleMainActivity'));
	}

	public function selectSubActivity($sub_act){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$subActivity = $this->mod_fecustomize->selectSubActivity($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $sub_act);
		$subactivity = array();
		if($subActivity->num_rows() > 0){
			foreach($subActivity->result() as $subact){
				$recodeavaliable = $this->convertDateToRangeSub($findate, $subact->start_date, $subact->end_date);				
				if($recodeavaliable){
					$avRecord = json_decode(json_encode($subact), true); 
					array_push($subactivity, $avRecord);
				}
			}
		}
		return $subactivity;
	}
	public function customizeAccommodation(){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$accommodation = $this->mod_fecustomize->accommodation($this->session->userdata('ftvID'), $this->session->userdata('lcID'));
		$data = array();
		if($accommodation->num_rows() > 0){
			foreach($accommodation->result() as $acc){
				$recodeavaliable = $this->convertDateToRange($findate, $acc->start_date, $acc->end_date);				
				if($recodeavaliable){
					$avRecord = json_decode(json_encode($acc), true); 
					array_push($data, $avRecord);
				}
			}
		}
		return $data;
	}

	public function clickCustomizeAccommodation() {
		if ($this->input->post('checkbox_accommodation')) {
			foreach ($this->input->post('checkbox_accommodation') as $element) {
				$arr_accommodation = $this->general_lib->get_accommodation();
		        $new_arr_accommodation = $this->insertArrayIndex($arr_accommodation, $element, $element);
		        $this->general_lib->set_accommodation($new_arr_accommodation);
			}
		}
		if ($this->input->post('sub_acc_extra_product')) {
			foreach ($this->input->post('sub_acc_extra_product') as $element) {
				$arr_extra_acc = $this->general_lib->get_sub_acc_extr_product();
		        $new_arr_extra_acc = $this->insertArrayIndex($arr_extra_acc, $element, $element);
		        $this->general_lib->set_sub_acc_extr_product($new_arr_extra_acc);
			}
		}


		$this->general_lib->set_sub_acc_amount_extra($this->input->post('amountAccExtras'));
		$this->general_lib->set_checkin_date_accommodation($this->input->post('checkIn'));
		$this->general_lib->set_checkout_date_accommodation($this->input->post('checkOut'));
		$this->general_lib->set_people_accommodation($this->input->post('peopleAccommodation'));
		$this->general_lib->set_room_type_accommodation($this->input->post('multi_select_rooms'));
	}
	
	/*select sub accommodation */
	public function selectSubAccommodation($sub_acc){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$subAccommodation = mod_fecustomize::selectSubAccommodation($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $acc_record['acc_id']);
		$subAccommodation = array();
		if($subAccommodation->num_rows() > 0) {
			foreach ($subAccommodation->result() as $subacc) {
				$recodeavaliable = site::convertDateToRangeSub($findate, $subacc->start_date, $subacc->end_date);	
				if ($recodeavaliable) {
					$avRecord = json_decode(json_encode($subacc), true);
					array_push($subAccommodation, $avRecord);
				}
			}
		}
		return $subAccommodation;
	}
	
	
	public function selectSubTransportation($sub_act){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$subTransportation = mod_fecustomize::selectSubTransportation($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $tp_record['tp_id']);
		$subtransportation = array();
		if($subTransportation->num_rows() > 0){
			foreach($subTransportation->result() as $subtp){
				$recodeavaliable = site::convertDateToRangeSub($findate, $subtp->start_date, $subtp->end_date);				
				if($recodeavaliable){
					$avRecord = json_decode(json_encode($subtp), true); 
					array_push($subtransportation, $avRecord);
				}
			}
		}
		return $subtransportation;
	}
	public function customizeTransportation(){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$transportation = $this->mod_fecustomize->transportation($this->session->userdata('ftvID'), $this->session->userdata('lcID'));
		$tp_data = array();
		if($transportation->num_rows() > 0){
			foreach($transportation->result() as $tp){
				$recodeavaliable = $this->convertDateToRange($findate, $tp->start_date, $tp->end_date);				
				if($recodeavaliable){
					$avRecord = json_decode(json_encode($tp), true); 
					array_push($tp_data, $avRecord);
				}
			}
		}
		return $tp_data;
	}

	public function clickCustomizeTransportation() {
		if ($this->input->post('checkbox_transportation')) {
			foreach ($this->input->post('checkbox_transportation') as $element) {
				$arr_transportation = $this->general_lib->get_transportation();
		        $new_arr_transportation = $this->insertArrayIndex($arr_transportation, $element, $element);
		        $this->general_lib->set_transportation($new_arr_transportation);
			}
		}
		if ($this->input->post('sub_trans_extra_product')) {
			foreach ($this->input->post('sub_trans_extra_product') as $element) {
				$arr_extra_trans = $this->general_lib->get_sub_trans_extr_product();
		        $new_arr_extra_trans = $this->insertArrayIndex($arr_extra_trans, $element, $element);
		        $this->general_lib->set_sub_trans_extr_product($new_arr_extra_trans);
			}
		}
		if ($this->input->post('checkbox_subTrans')) {
			foreach ($this->input->post('checkbox_subTrans') as $element) {
				$arr_extra_sub_trans = $this->general_lib->get_sub_transportation();
		        $new_arr_extra_sub_trans = $this->insertArrayIndex($arr_extra_sub_trans, $element, $element);
		        $this->general_lib->set_sub_transportation($new_arr_extra_sub_trans);
			}
		}
		$this->general_lib->set_departure_transportation($this->input->post('trans_departure'));	
		$this->general_lib->set_return_date_transportation($this->input->post('trans_return'));
		$this->general_lib->set_people_transportation($this->input->post('peopleTransportation'));	
		$this->general_lib->set_people_sub_transportation($this->input->post('peopleSubTransportation'));
		$this->general_lib->set_sub_trans_amount_extra($this->input->post('amountTransExtras'));
	}

	public function customizeExtra_service(){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$ext_records = $this->mod_fecustomize->selectExtraProdcuts();
		$extra_data = array();
		if ($ext_records->num_rows() > 0) {
			foreach ($ext_records->result() as $exp) {
				$recodeavaliable = $this->convertDateToRange($findate, $exp->start_date, $exp->end_date);
				if ($recodeavaliable) {
					$avRecord = json_decode(json_encode($exp), true);
					array_push($extra_data, $avRecord);
				}
			}
		}
		return $extra_data;
	}
	public function clickCustomizeExtraService() {
		$this->general_lib->set_extra_services($this->input->post('checkbox_extra_service'));
		$this->general_lib->set_num_extra_services($this->input->post('amountExpAmount'));
	}
	public function customizePersonal_info(){ 
		$new_sess_passenger = $this->session->userdata('new_passenger_id');
		$sess_passenger = $this->session->userdata("passenger");
		if ($new_sess_passenger) {
			$passenger_id = $new_sess_passenger['pass_id'];
		} else if($sess_passenger) {
			$passenger_id = $sess_passenger['pass_id'];
		} else {
			$passenger_id = -1;
		}
		return $this->mod_fecustomize->customizePersonal_info($passenger_id);
	}

	/*
	* public function customize_more_passenger
	* load template fe_more_passenger
	*/
	public function customize_more_passenger() {
		$new_sess_passenger = $this->session->userdata('new_passenger_id');
		$login_sess_passenger = $this->session->userdata("passenger");
		if ($new_sess_passenger) {
			$pass_addby = $new_sess_passenger['pass_id'];
		} else if($login_sess_passenger) {
			$pass_addby = $login_sess_passenger['pass_id'];
		} else {
			$pass_addby = -1;
		}
		$passengerInfo = array(
			'pass_addby' => $pass_addby,
			'pass_fname'        => $this->input->post('pfname'),
            'pass_lname'        => $this->input->post('plname'),
            'pass_email'        => $this->input->post('pemail'),
            'pass_phone'        => $this->input->post('phphone'),
            'pass_mobile'       => $this->input->post('pmobile'),
            'pass_country'      => $this->input->post('pcountry'),
            'pass_address'      => $this->input->post('paddress'),
            'pass_company'      => $this->input->post('pcompany'),
            'pass_gender'       => $this->input->post('pgender'),
            'pass_status'       => 1,
            'pass_deleted'      => 0,
		);
		$result  = $this->mod_fecustomize->personal_information($passengerInfo);
		if (!$result) {
			$arr_errors = array(
				"success" => false,
				"sms_type" => "danger",
				"sms_title" => "Error!",
				"sms_value" => "Sorry! That email is already registered. Please login before you booking."
			);
			echo json_encode($arr_errors);
		} else if($result == 'over_number') {
			$arr_errors = array(
				"success" => true,
				"sms_type" => "warning",
				"sms_title" => "Warning!",
				"sms_value" => "Your member selected only ".$this->session->userdata('people')." member(s), if you would like to add more, please change amount of passenger.."
			);
			echo json_encode($arr_errors);
		} else {
			$arr_errors = array(
				"success" => true,
				"sms_type" => "success",
				"sms_title" => "Congradulation!",
				"sms_value" => "You have been added a passenger with successfully."
			);
			echo json_encode($arr_errors);
		}

	}
	



	/*
	* public function packages
	* @param $display_page default (false)
	* load template packages and include package
	*/
	public function packages($display_page = false){
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['site_setting'] = "packages";
		if($display_page != false){
			if( ! file_exists('application/views/include/FE/package/'.$display_page.'.php') ){
				show_404();
			}
		}
		if($display_page == false){
			$fe_data["allpackages"] = $this->allpackages();		 	
		}elseif($display_page == "details"){
			$fe_data["packagesdetail"] = $this->packagesDetail();
		}
		$this->load->view('index', $fe_data);
	}

	/** public function allpackage
		* @noparam
		* @access by packages()
		* return all available packages.
	*/
	public function allpackages(){
		$ftv = $this->session->userdata('ftvID');
		$lc = $this->session->userdata('lcID');
		$allpackages = $this->mod_fepackage->getallpackages($ftv, $lc);
		return $allpackages;
	}

	/** public function packagesDetail
		* @noparam
		* @access by packages()
		* return detail of each package
	*/
	public function packagesDetail(){
		$key = "90408752631";
        $pk_id = base64_decode($this->uri->segment(5));
        $pk_id = preg_replace(sprintf('/%s/', $key), '', $pk_id);
		$detailpackages = $this->mod_fepackage->getdetailpackages($pk_id);
		return $detailpackages;
	}

}

/* End of file site.php */
/* Location: ./application/controllers/site.php */