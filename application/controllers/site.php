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
			$fe_data['back_to'] = 'page/'.$view_feedback; 
			$fe_data['site_setting'] = "view_feedback";
		}else{
			$fe_data['site_setting'] = "feedback";
			$fe_data['feedback'] = $this->mod_index->getFeedback();
		}
		$this->load->view('index', $fe_data);
	}
        
        public function profile(){
            $fe_data['title'] = "profile user";
            $fe_data['menu_fe'] = $this->mod_index->getAllMenu();
            $fe_data['site_setting'] = "profile";
            // $passegnger_id = $this->session->userdata('passengerid');
            $passegnger_id = $this->mod_fecustomize->getCurrentPassengerId();
            $fe_data['old_gender'] = array('' => '-- Select --', 'F' => 'Female', 'M' => 'Male');
            $fe_data['old_txtStatus'] = array('0' => 'Unpublished','1' => 'Published');
            $fe_data['profile'] = $this->mod_profilefe->pass_profilefe($passegnger_id);
            $fe_data['passengerbooking_info'] = $this->mod_profilefe->passenger_bookedform($passegnger_id);
			// add select more passengers that booking by team leader
			$login_sess_passenger = $this->session->userdata('passenger');
	        $new_sess_passenger = $this->session->userdata('new_passenger_id');
	        $pass_id = -1;
			if ($new_sess_passenger OR $login_sess_passenger) {
				$this->general_lib->empty_personalInfo_message();

				if ($new_sess_passenger != '') {
	        		$pass_id = $new_sess_passenger['pass_id'];
	        	}
	        	if ($login_sess_passenger != '') {
	        		$pass_id = $login_sess_passenger['pass_id'];
	        	}
			}
			// $fe_data['members'] = $this->mod_fecustomize->get_all_member_by_pass_addby($pass_id);
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
     	$this->general_lib->empty_room_type_accommodation();
     	$this->general_lib->empty_amount_book_room();
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
	* Clear all session of a whole customize booking process.
	*/
	protected function clear_all_customize() {
		$this->clear_all_for_activity();
		$this->clear_all_for_accommodation();
		$this->clear_all_for_transportation();
		$this->clear_all_for_extra_services();
		// Unset sessions after booking finished
		$items_sess = array(
			'ftvID' => '',
			'lcID' => '',
			'total' => '',
			'txtFrom' => '',
			'txtTo' => '',
			'each_member_extra_of_trans' => ''
		);
		$this->session->unset_userdata($items_sess);
		$this->general_lib->empty_booking_fee();
	}
        
    /*
	* public function customize
	* @param $display_page default (false)
	* load template customizes and include customize
	*/
	public function customizes($display_page = false, $pass_id = false){
		if ($display_page == "success") {
			$fe_data['success'] = 'hello successfully';
		}

		if($display_page == "customizeTrip"){
			redirect('site/customizes/transportation');
		}
		if($display_page == "transportation"){
			if($this->input->post('btnTransportation')){
				$this->clear_all_for_transportation();
				$this->clickCustomizeTransportation();

				redirect('site/customizes/accommodation');
			}else{
				$fe_data['recordTransportation'] = $this->customizeTransportation();
			}
		}

		if ($display_page == "accommodation") {
			if($this->input->post('btnAccommodation')){	
				$this->clear_all_for_accommodation();
				$this->clickCustomizeAccommodation();
 
				redirect('site/customizes/activities');
			}else{
				$fe_data['recordAccommodation'] = $this->customizeAccommodation();
			}	
		}

		if ($display_page == "activities") {
			if($this->input->post('btnActivity')){
				$this->clear_all_for_activity();
				$this->clickCustomizeActivity();

				redirect('site/customizes/extra-service');
			}else{
				$fe_data['recordActivities'] = $this->customizeActivity();
			}
		}
		
		if($display_page == "extra-service"){
			if($this->input->post('btnExtraService')){
				$this->clear_all_for_extra_services();
				$this->clickCustomizeExtraService();

				redirect('site/customizes/personal-info');
			}else{
				$fe_data['recordExtraProducts'] = $this->customizeExtra_service();
				if (!empty($fe_data['recordExtraProducts'])) {
					foreach ($fe_data['recordExtraProducts'] as $extra) {
						$extra_index[] = $extra['ep_id']; 
					}
					$this->general_lib->set_index_extra_service($extra_index);
				}
			}
		}
		if ($display_page == "personal-info") {
			$pass_id = $this->mod_fecustomize->getCurrentPassengerId();

			if($this->input->post('btnPersonalInfo')){	
				$this->general_lib->empty_personalInfo_message();

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
					array(
						'field' => 'pemail',
						'label' => 'Passenger Email',
						'rules' => 'trim|required|valid_email'
					), 
					array(
						'field' => 'phphone',
						'label' => 'Hand phone',
						'rules' => 'trim|required'
					), 
					array(
						'field' => 'pcountry',
						'label' => 'Country',
						'rules' => 'trim|required'
					),  
					array(
						'field' => 'pbk_fee',
						'label' => 'Booking Fee',
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
					$fe_data['passenger_info'] = $this->customizePersonal_info($pass_id);
				}else{
					$this->general_lib->set_booking_fee($this->input->post('pbk_fee'));	
					if ($pass_id == -1) {
						$passengerInfo = array(
							'pass_addby' 		=> '',
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
						$this->session->set_userdata($passengerInfo);
					} else {
						$fe_data['passenger_info'] = $this->customizePersonal_info($pass_id);
						$passengerInfo = array(
							'pass_addby'		=> '',
							'pass_fname'        => $fe_data['passenger_info']->pass_fname,
				            'pass_lname'        => $fe_data['passenger_info']->pass_lname,
				            'pass_email'        => $fe_data['passenger_info']->pass_email,
				            'pass_phone'        => $fe_data['passenger_info']->pass_phone,
				            'pass_mobile'       => $fe_data['passenger_info']->pass_mobile,
				            'pass_country'      => $fe_data['passenger_info']->pass_country,
				            'pass_address'      => $fe_data['passenger_info']->pass_address,
				            'pass_company'      => $fe_data['passenger_info']->pass_company,
				            'pass_gender'       => $fe_data['passenger_info']->pass_gender,
				            'pass_status'       => $fe_data['passenger_info']->pass_status,
				            'pass_deleted'      => $fe_data['passenger_info']->pass_deleted,
						);
						$this->session->set_userdata($passengerInfo);
					}
					redirect('site/customizes/payments');	
				}

			}else{
				$fe_data['arr_messages'] = $this->general_lib->get_personalInfo_message();
				$fe_data['passenger_info'] = $this->customizePersonal_info($pass_id); 
			}
		}


		/*if ($display_page == 'payments') {
			if ($this->general_lib->get_booking_fee() == '') {
				$this->general_lib->set_booking_fee($this->input->post('pbk_fee'));
			}
		}*/

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
			echo "true";
	} 
	// function convertDateToRange for customize on the front end
    function convertDateToRange($findDate, $from_date, $end_date, $step = '+1 day', $format = 'Y-m-d' ) {
        if (!empty($findDate)) {
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
		$activities = $this->mod_fecustomize->trip_information($this->session->userdata('ftvID'), $this->session->userdata('lcID'));
		$records = array();
		if (!empty($findate)) {
			if($activities->num_rows() > 0){
				foreach($activities->result() as $act){
					$recodeavaliable = $this->convertDateToRange($findate, $act->start_date, $act->end_date);				
					if($recodeavaliable){
						$avRecord = json_decode(json_encode($act), true); 
						array_push($records, $avRecord);
					}
				}
			}
		}
		return $records;
	}

	public function clickCustomizeActivity() {
		$this->general_lib->set_main_activities($this->input->post('checkbox_activity'));
		$this->general_lib->set_start_date_activity($this->input->post('txtFrom'));
		$this->general_lib->set_end_date_activity($this->input->post('txtTo'));
		$this->general_lib->set_sub_activities($this->input->post('checkbox_subactivity'));
		$this->general_lib->set_extra_activities($this->input->post('checkbox_extra'));
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
		if (!empty($findate)) {
			if($accommodation->num_rows() > 0){
				foreach($accommodation->result() as $acc){
					$recodeavaliable = $this->convertDateToRange($findate, $acc->start_date, $acc->end_date);				
					if($recodeavaliable){
						$avRecord = json_decode(json_encode($acc), true); 
						array_push($data, $avRecord);
					}
				}
			}
		}
		return $data;
	}

	public function clickCustomizeAccommodation() {
		$this->general_lib->set_accommodation($this->input->post('checkbox_accommodation'));
		$this->general_lib->set_sub_acc_extr_product($this->input->post('sub_acc_extra_product'));
		$this->general_lib->set_sub_acc_amount_extra($this->input->post('amountAccExtras'));
		$this->general_lib->set_checkin_date_accommodation($this->input->post('checkIn'));
		$this->general_lib->set_checkout_date_accommodation($this->input->post('checkOut'));
		$this->general_lib->set_people_accommodation($this->input->post('peopleAccommodation'));
		$this->general_lib->set_room_type_accommodation($this->input->post('room_type_checked'));
		$this->general_lib->set_amount_book_room($this->input->post('amount_book_room'));
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
		$findate = array();
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) 
		// {
			 $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
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
		// }
	}

	public function clickCustomizeTransportation() {
		$this->general_lib->set_transportation($this->input->post('checkbox_transportation'));
		$this->general_lib->set_sub_transportation($this->input->post('checkbox_subTrans'));
		$this->general_lib->set_departure_transportation($this->input->post('trans_departure'));	
		$this->general_lib->set_return_date_transportation($this->input->post('trans_return'));
		$this->general_lib->set_people_transportation($this->input->post('peopleTransportation'));	
		$this->general_lib->set_people_sub_transportation($this->input->post('peopleSubTransportation'));
		$this->general_lib->set_sub_trans_extr_product($this->input->post('sub_trans_extra_product'));
		$this->general_lib->set_sub_trans_amount_extra($this->input->post('amountTransExtras'));
	}

	public function customizeExtra_service(){
		if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
		$ext_records = $this->mod_fecustomize->selectExtraProdcuts();
		$extra_data = array();
		if (!empty($findate)) {
			if ($ext_records->num_rows() > 0) {
				foreach ($ext_records->result() as $exp) {
					$recodeavaliable = $this->convertDateToRange($findate, $exp->start_date, $exp->end_date);
					if ($recodeavaliable) {
						$avRecord = json_decode(json_encode($exp), true);
						array_push($extra_data, $avRecord);
					}
				}
			}
		}
		return $extra_data;
	}

	public function clickCustomizeExtraService() {
		$this->general_lib->set_extra_services($this->input->post('checkbox_extra_service'));
		$this->general_lib->set_num_extra_services($this->input->post('amountExpAmount'));
	}

	public function customizePersonal_info($passenger_id){ 
		return $this->mod_fecustomize->customizePersonal_info($passenger_id);
	}

	/*
	* public function customize_more_passenger
	* load template fe_more_passenger
	*/
	/*public function customize_more_passenger() {
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
		} else {
			$arr_errors = array(
				"success" => true,
				"sms_type" => "success",
				"sms_title" => "Congradulation!",
				"sms_value" => "You have been added a passenger with successfully."
			);
			echo json_encode($arr_errors);
		}

	}*/

	/*
	* Change session amount of people
	*/
	function update_sess_amount_people() {
		$this->session->set_userdata('people', $this->input->post('term'));
		$arr_errors = array(
			"success" => true,
			"sms_type" => "success",
			"sms_title" => "Congradulation!",
			"sms_value" => "Now you can add your friend(s) more for this booking.",
			"amount_people" =>$this->session->userdata('people')
		);
		echo json_encode($arr_errors);
	}

	/*
	* Save all data of each member for customize booking info
	*/
	function member_personal_info_customize_bk($pass_id) {
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
		$result  = $this->mod_fecustomize->personal_information($passengerInfo, $pass_id);
		if (!$result) {
			$arr_errors = array(
				"success" => false,
				"sms_type" => "danger",
				"sms_title" => "Error!",
				"sms_value" => "Sorry! Cannot update your information."
			);
		} else {
			$arr_errors = array(
				"success" => true,
				"sms_type" => "success",
				"sms_title" => "Congradulation!",
				"sms_value" => "You have updated with successfully."
			);
		}	
		echo json_encode($arr_errors);
	}

	/*
	*	Save extra products for transportation
	*/
	function each_member_transportation($sub_menu) {
		if ($sub_menu == 'extra-pro') {
			$this->general_lib->set_sub_trans_amount_extra($this->input->post('amountTransExtras'));
			$this->session->set_userdata('each_member_extra_of_trans', $this->input->post('own_extra_amount'));
			$arr_errors = array(
				"success" => true,
				"sms_type" => "success",
				"sms_title" => "Congradulation!",
				"sms_value" => "You have updated with successfully."
			);
		}
		echo json_encode($arr_errors);
	}

	function pay_later_customize() {
		if ($this->session->userdata('ftvID') == "") {
			$arr_errors = array(
				"success" => false,
				"sms_type" => "danger",
				"sms_title" => "Sorry!",
				"sms_value" => "Please make a booking before you try to submit."
			);
			echo json_encode($arr_errors);
		} else {
			$dataTransportation = $this->getSessionTransportations();
			$dataAccommodation = $this->getSessionAccommodation();
			$dataActivity = $this->getSessionActivities();
			$dataExtraService = $this->getSessionExtraServices();

			$pass_id = $this->mod_fecustomize->getCurrentPassengerId();
			$passengerInfo = array(
				'pass_addby' 		=> $this->session->userdata('pass_addby'),
				'pass_fname'        => $this->session->userdata('pass_fname'),
	            'pass_lname'        => $this->session->userdata('pass_lname'),
	            'pass_email'        => $this->session->userdata('pass_email'),
	            'pass_phone'        => $this->session->userdata('pass_phone'),
	            'pass_mobile'       => $this->session->userdata('pass_mobile'),
	            'pass_country'      => $this->session->userdata('pass_country'),
	            'pass_address'      => $this->session->userdata('pass_address'),
	            'pass_company'      => $this->session->userdata('pass_company'),
	            'pass_gender'       => $this->session->userdata('pass_gender'),
	            'pass_status'       => $this->session->userdata('pass_status'),
	            'pass_deleted'      => $this->session->userdata('pass_deleted'),
			);
			$result  = $this->mod_fecustomize->personal_information($passengerInfo, $pass_id);
			if (!$result) {
				$arr_errors = array(
					"success" => false,
					"sms_type" => "danger",
					"sms_title" => "Error!",
					"sms_value" => "Sorry! That email is already registered. Please try another one."
				);
				echo json_encode($arr_errors);
			} else {
				// Send mail automatically to passenger
				$subsc['sub_fname'] = $this->session->userdata('pass_fname');
				$subsc['sub_lname'] = $this->session->userdata('pass_lname');
				$subsc['sub_email'] = $this->session->userdata('pass_email');
				$subsc['sub_status'] = 1;
				$subsc['roles_role_id'] 	= 5;
				if($subsc['sub_email'] != ""){
					$existORnot = MU_Model::checkExistEmail('subscriber','sub_email',array("sub_email"=>$subsc['sub_email']));
					if($existORnot != "exist"){
						$result = $this->mod_index->insertSubscriber($subsc);
						if($result > 0){
							//$this->emailTOadmin($subsc);
						}
					}
				}
			}

			$bk_info = array(
				'bk_type' => 'customize',
				'bk_date' => date("Y-m-d"),
				'bk_arrival_date' => $this->session->userdata('txtFrom'),
				'bk_return_date' => $this->session->userdata('txtTo'),
				'bk_total_people' => $this->session->userdata('people'),
				'bk_addmoreservice' => serialize($dataExtraService),
			);
			$bk_inserted = $this->mod_fecustomize->insertBookingInfo($bk_info);
			if (!$bk_inserted) {
				$arr_errors = array(
					"success" => false,
					"sms_type" => "danger",
					"sms_title" => "Sorry!",
					"sms_value" => "Your process has been failed for transection."
				);
				echo json_encode($arr_errors);
			}

			// Add data into passenger_booking
			$passengerID = 0;
			if ($pass_id != -1) {
				$passengerID = $pass_id;
			} else if (is_numeric($result)) {
				$passengerID = $result;
			}
			if ($bk_info['bk_id'] AND $passengerID != 0) {
				$pass_bk_info = array(
	                'pbk_pass_id' => $passengerID,
	                'pbk_bk_id' => $bk_info['bk_id']
	            );

	            $pbk_inserted = $this->mod_fecustomize->insertPassengerBookingInfo($pass_bk_info, $passengerID, $bk_info['bk_id']);
			}
           
           

			$this->session->set_userdata('booking_id', $bk_info['bk_id']);
			$cuscon_info = array(
				'cuscon_start_date' => $this->session->userdata('txtFrom'),
				'cuscon_end_date' => $this->session->userdata('txtTo'),
				'cuscon_totalprice' => $this->session->userdata('total'),
				'cuscon_accomodation' => serialize($dataAccommodation),
				'cuscon_activities' => serialize($dataActivity),
				'cuscon_transportation' => serialize($dataTransportation),
				'cuscon_ftv_id' => $this->session->userdata('ftvID'),
				'cuscon_lt_id' => $this->session->userdata('lcID'),
			);
			$cuscon_inserted = $this->mod_fecustomize->insertCustomizeConjectionInfo($cuscon_info);
			if (!$cuscon_inserted) {
				$arr_errors = array(
					"success" => false,
					"sms_type" => "danger",
					"sms_title" => "Sorry!",
					"sms_value" => "Your process has been failed for transection."
				);
				echo json_encode($arr_errors);
			}

			$salecus_info = array(
				'salecus_bk_id' => $bk_info['bk_id'],
				'salecus_cuscon_id' => $cuscon_info['cuscon_id']
			);
			$salecus_inserted = $this->mod_fecustomize->insertSaleCustomizeInfo($salecus_info);

			if (!$salecus_inserted) {
				$arr_errors = array(
					"success" => false,
					"sms_type" => "danger",
					"sms_title" => "Sorry!",
					"sms_value" => "Your process has been failed for transection."
				);
				echo json_encode($arr_errors);
			} else {
				$this->clear_all_customize();
				$this->finish_customize_booking();
				$this->clear_session_passenger();
				$arr_errors = array(
					"success" => true,
					"sms_type" => "success",
					"sms_title" => "Congradulation!",
					"sms_value" => "Your process has been success for transection to pay later."
				);
				echo json_encode($arr_errors);
			}
		}
	}

	// Clear session passenger
	function clear_session_passenger() {
		$items_sess = array(
			'pass_addby' => '',
			'pass_fname' => '',
			'pass_lname' => '',
			'pass_email' => '',
			'pass_phone' => '',
			'pass_company' => '',
			'pass_country' => '',
			'pass_mobile' => '',
			'pass_address' => '',
			'pass_gender' => '',
			'pass_status' => '',
			'pass_deleted' => '',
		);
		$this->session->unset_userdata($items_sess);
	}

	// when click on finish button of customize booking
	function finish_customize_booking() {
		$items_sess = array(
			'people' => '',
			'pay_later' => false,
			'booking_id' => '',
		);
		$this->session->unset_userdata($items_sess);
	}

	/*
	* Get transportation as array for inserting into database
	*/
	function getSessionTransportations () {
		$arrTransportations = array();
		$departure =  $this->general_lib->get_departure_transportation();
		$return_date = $this->general_lib->get_return_date_transportation();
		$pass_joined = $this->general_lib->get_people_transportation();
		$extra_pro = $this->general_lib->get_sub_trans_extr_product();
		$amount_extra_pro = $this->general_lib->get_sub_trans_amount_extra();

		if ($this->general_lib->get_transportation() != "") {
			foreach ($this->general_lib->get_transportation() as $id) {
				$field_select = 'tp_id, tp_name, tp_purchaseprice, tp_saleprice, tp_actualstock, tp_texteticket';
				$object = $this->mod_fecustomize->get_info_of_main_obj('transportation', 'tp_id', $id, $field_select);
				$products = array();
				$num_people = array();
				if (isset($pass_joined[$id])) {
					foreach ($pass_joined[$id] as $people) {
						$temp = array(
							$id => $people
						);
						array_push($num_people, $temp);
					}
				}
				if (isset($extra_pro[$id])) {
					foreach ($extra_pro[$id] as $product_id) {
						$field_select = 'ep_id, ep_name, ep_perperson, ep_perbooking, ep_etickettext, ep_purchaseprice, ep_saleprice, ep_actualstock';
						$product = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $product_id, $field_select);
						$product->amount_bked = $amount_extra_pro[$id][$product_id];
						array_push($products, $product);
					}
				}

				$arrTransportation = array(
					$id => array(
						'info' => $object,
						'departure' => $departure[$id],
						'return_date' => $return_date[$id],
						'pass_joined' => $num_people,
						'extra_pro' => $products
					)
				);
				array_push($arrTransportations, $arrTransportation);
			}
		}
		return $arrTransportations;
	}
	
	/*
	* Get accommodation as array for inserting into database
	*/
	function getSessionAccommodation () {
		$departure =  $this->general_lib->get_checkin_date_accommodation();
		$return_date = $this->general_lib->get_checkout_date_accommodation();
		$pass_joined = $this->general_lib->get_people_accommodation();
		$room_type = $this->general_lib->get_room_type_accommodation();
		$amount_room_book = $this->general_lib->get_amount_book_room();
		$extra_pro = $this->general_lib->get_sub_acc_extr_product();
		$amount_extra_pro = $this->general_lib->get_sub_acc_amount_extra();

		$arraAccommodations = array();
		if ($this->general_lib->get_accommodation() != "") {
			foreach ($this->general_lib->get_accommodation() as $id) {
				$field_select = 'acc_id, acc_name, acc_texteticket, acc_purchaseprice, acc_saleprice, acc_actualstock, classification_id';
				$object = $this->mod_fecustomize->get_info_of_main_obj('accommodation', 'acc_id', $id, $field_select);
				$num_people = array();
				$products = array();
				$arr_rooms = array();
				$amount_rm_bked = array();
				if (isset($pass_joined[$id])) {
					foreach ($pass_joined[$id] as $people) {
						$temp = array(
							$id => $people
						);
						array_push($num_people, $temp);
					}
				}
				
				if (isset($extra_pro[$id])) {
					foreach ($extra_pro[$id] as $product_id) {
						$field_select = 'ep_id, ep_name, ep_perperson, ep_perbooking, ep_etickettext, ep_purchaseprice, ep_saleprice, ep_actualstock';
						$product = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $product_id, $field_select);
						$product->amount_bked = $amount_extra_pro[$id][$product_id];
						array_push($products, $product);
					}
				}
				if (isset($room_type[$id])) {
					foreach ($room_type[$id] as $items) {
						foreach ($items as $rt_id) {
							$room = $this->mod_fecustomize->get_info_hotel($rt_id);
							if (isset($amount_room_book[$id])) {
								foreach ($amount_room_book[$id] as $arra_room_nums) {
									foreach ($arra_room_nums as $num) {
										if ($num[$rt_id] != '') {
											$room->amount_bked = $num[$rt_id];
											array_push($arr_rooms, $room);
										}
									}
								}
							}
						}
					}
				}

				$arraAccommodation = array(
					$id => array(
						'info' => $object,
						'departure' => $departure[$id],
						'return_date' => $return_date[$id],
						'pass_joined' => $num_people,
						'extra_pro' => $products,
						'accom' => $arr_rooms
					)
				);
				array_push($arraAccommodations, $arraAccommodation);
			}
		}
		return $arraAccommodations;
	}

	/*
	* Get activities as array for inserting into database
	*/
	protected function getSessionActivities() {
		$departure =  $this->general_lib->get_start_date_activity();
		$return_date = $this->general_lib->get_end_date_activity();
		$pass_joined = $this->general_lib->get_people_main_activity();
		$sub_activities = $this->general_lib->get_sub_activities();
		$sub_act_people = $this->general_lib->get_people_sub_activity();
		$extra_pro = $this->general_lib->get_extra_activities();
		$amount_extra_pro = $this->general_lib->get_amount_extra();

		$arraActivities = array();
		if ($this->general_lib->get_main_activities() != "") {
			foreach ($this->general_lib->get_main_activities() as $id) {
				$field_select = 'act_id, act_name, act_texteticket, act_purchaseprice, act_saleprice, act_actualstock';
				$object = $this->mod_fecustomize->get_info_of_main_obj('activities', 'act_id', $id, $field_select);
				$num_people = array();
				$products = array();
				$sub_acts = array();
				$amount_extras = array();
				$arr_rooms = array();
				$amount_rm_bked = array();
				if (isset($pass_joined[$id])) {
					foreach ($pass_joined[$id] as $people) {
						$temp = array(
							$id => $people
						);
						array_push($num_people, $temp);
					}
				}

				if (isset($sub_activities[$id])) {
					foreach ($sub_activities[$id] as $sub_act_id) {
						$field_select = 'act_id, act_name, act_texteticket, act_purchaseprice, act_saleprice, act_actualstock';
						$sub_act = $this->mod_fecustomize->get_info_of_main_obj('activities', 'act_id', $sub_act_id, $field_select);
						$sub_act->amount_bked = $sub_act_people[$id][$sub_act_id];
						array_push($sub_acts, $sub_act);
					}

				}

				if (isset($extra_pro[$id])) {
					foreach ($extra_pro[$id] as $product_id) {
						$field_select = 'ep_id, ep_name, ep_perperson, ep_perbooking, ep_etickettext, ep_purchaseprice, ep_saleprice, ep_actualstock';
						$product = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $product_id, $field_select);
						$product->amount_bked = $amount_extra_pro[$id][$product_id];
						array_push($products, $product);
					}
				}

				$arraActivity = array(
					$id => array(
						'info' => $object,
						'departure' => $departure[$id],
						'return_date' => $return_date[$id],
						'pass_joined' => $num_people,
						'extra_pro' => $products,
						'activity' => $sub_acts
					)
				);
				array_push($arraActivities, $arraActivity);
			}
		}
		return $arraActivities;
	}

	/*
	* Get extra-services as array for inserting into database
	*/
	protected function getSessionExtraServices () {
		$extra_services = $this->general_lib->get_extra_services();
		$amount_extra_pro = $this->general_lib->get_num_extra_services();

		$arraExtServices = array();
		if ($extra_services != "") {
			foreach ($extra_services as $id) {
				$field_select = 'ep_id, ep_name, ep_perperson, ep_perbooking, ep_etickettext, ep_purchaseprice, ep_saleprice, ep_actualstock';
				$object = $this->mod_fecustomize->get_info_of_main_obj('extraproduct', 'ep_id', $id, $field_select);
				$object->amount_bked = $amount_extra_pro[$id][0];
				$arraExtService = array(
					$id => $object
				);
				array_push($arraExtServices, $arraExtService);
			}
		}
		return $arraExtServices;
	}

	// Check existing passenger by email
	function checkExistPassengerByEmail() {
		$email = $this->input->post('email');
		$result = $this->mod_fecustomize->exist_passenger_by_email($email);
		if ($result) {
			$arr_errors = array(
				"success" => false,
				"sms_type" => "danger",
				"sms_title" => "Error!",
				"sms_value" => "Sorry! That email is already registered."
			);
			echo json_encode($arr_errors);
		}
	}

	/*
	* public function emailTOadmin
	* @param $data (array)
	* return success or failed.
	* for subscribe and tellafriend
	*/
	public function emailTOadmin($data){
		$adminMail = MU_Model::getAdminEmail();
		if($adminMail == ""){
			$adminMail = "mysoftware77@gmail.com";
		}
	$message = "Firstname: ".$data['sub_fname'].
	"Lastname: ".$data['sub_lname'].
	"Email: ".$data['sub_email'];
		$this->email->clear();	    
        $this->email->to($adminMail);
        $this->email->from($data['sub_email']);
        $this->email->subject("You got a new subscriber.");
        $this->email->message($message);
        $send = $this->email->send();
	}

	/*
	* Public function subscriber
	* @noparam
	* insert record to table subscribe
	* echo true or false.
	*/
	/*public function subscriber(){
		$subsc['sub_fname'] = $this->input->post("fs_name");
		$subsc['sub_lname'] = $this->input->post("ls_name");
		$subsc['sub_email'] = $this->input->post("es_name");
		$subsc['sub_status'] = 1;
		$subsc['role_id'] 	= 5;
		if($subsc['sub_email'] != ""){
			$existORnot = MU_Model::checkExistEmail('subscriber','sub_email',array("sub_email"=>$subsc['sub_email']));
			if($existORnot != "exist"){
				$result = $this->mod_index->insertSubscriber($subsc);
				if($result > 0){
					$this->emailTOadmin($subsc);
					echo "t";
				}else{
					echo "f";
				}
			}
		}else{
			echo "f";
		}
	}*/

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