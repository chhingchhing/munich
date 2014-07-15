<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Site extends MU_Controller {

 		 public function __construct() {
        		parent::__construct();
  			$this->load->library('general_lib');
  
        		$this->load->model(array('mod_index','mod_booking','mod_profilefe','mod_fepackage','mod_fecustomize'));
   		 }

	    /*function
	    * index function is a function for load the default page
	    * @noparam
	    * Load index.php in folder view
	    */
	
	  public function index($menu_id = false){
	  
	    $fe_data['menu_fe'] = $this->mod_index->getAllMenu();
	    $fe_data['site_setting'] = "default";
	    $this->load->view('index',$fe_data);
	  }

	  /*
	  * function redirect from route.php in folder config
	  * public function pagef
	  * display the page by id
	  * used table content and menu
	  * load view index.php
	  */
	public function sendtoadmin(){
                if ($this->input->post('btn_sending')) {
                  echo "success";
                                           // $this->email->set_mailtype("html");
                    $this->email->clear();
                    $this->email->to('saorinphan@gmail.com');
                    $this->email->from('phansaorin@gmail.com');
                    $this->email->subject('Test');
                    $this->email->message('Hello sreynak');
                    $this->email->send();
               }else{
                echo "error";
               }
        }
        
	  public function page(){
	    if($this->uri->segment(4)){ $menu_id = $this->uri->segment(4); }elseif($this->uri->segment(3)){ $menu_id = $this->uri->segment(3); }else{ $menu_id = $this->uri->segment(2); }
	    $fe_data['menu_fe'] = $this->mod_index->getAllMenu();
	    $fe_data['content_fe'] = $this->mod_index->getContentById($menu_id);
	    $fe_data['site_setting'] = $this->getTemplate($menu_id);
	    $this->load->view('index',$fe_data);
	  }
      // add more passenger
   	  private $price = 0;
	  public function morepassenger(){
	    $passID = $this->session->userdata('passengerid');
	    $bkID = $this->input->post('txtBooking');
	    $fe_data['old_gender'] = array('' => '-- Select --', 'F' => 'Female', 'M' => 'Male');
	    if ($this->input->post('addmore_profile')) {
	      $config = array(
	          array('field' => 'fname', 'label' => 'First Name','rules' => 'trim|required'),
	                    array('field' => 'lname','label' => 'Last Name','rules' => 'trim|required'),
	                    array('field' => 'email','label' => 'Email','rules' => 'trim|required'),
	                    array('field' => 'phone', 'label' => 'Phone Number','rules' => 'trim|required'),
	                    array('field' => 'address','label' => 'Address','rules' => 'trim|required'),
	                    array('field' => 'company','label' => 'Company','rules' => 'trim|required'),
	                    array('field' => 'gender','label' => 'Gender','rules' => 'trim|required'),
	                    // add new
	                    array('field' => 'country','label' => 'Country','rules' => 'trim|required'),
	                    array('field' => 'city','label' => 'City','rules' => 'trim|required'),
	                    
	      );
	      $this->form_validation->set_rules($config);
	      if($this->form_validation->run() == FALSE){
	      $this->session->set_userdata('create', show_message('Please check your completed form!', 'error'));
	      }else{
	        $insert['pass_fname'] =   $this->input->post('fname');
	        $insert['pass_lname']   =   $this->input->post('lname');
	        $insert['pass_addby']   =   $passID;
	        $insert['pass_email'] =   $this->input->post('email');
	        $insert['pass_phone'] =   $this->input->post('phone');
	        $insert['pass_mobile'] =   $this->input->post('telephone');
	        $insert['pass_address'] =   $this->input->post('address');
	        $insert['pass_company'] =   $this->input->post('company');
	        $insert['pass_gender'] =   $this->input->post('gender');
	        $insert['pass_password'] = 123456789;
	        // add new
	        $insert['pass_country'] =   $this->input->post('country');
	        $insert['pass_city'] =   $this->input->post('city');
	        $insert['pass_about'] = $this->input->post('aboutyou');
	        $insert['pass_deleted'] = 0;
	        $insert['pass_status'] = 1;
	        $result = $this->mod_booking->getMorePassenger($insert);
	        if($result){
	        $aopID = $this->input->post('txtBooking'); 
	        $aop = MU_Model::getForiegnTableName('booking', array('bk_id'=> $aopID), 'bk_total_people');
	          $accompany = MU_Model::getForiegnTableName("passenger_booking", array('pbk_bk_id' => $bkID, 'pbk_pass_id' => $passID), 'pbk_pass_come_with');
	          $accompany = unserialize($accompany);
	          $newaccompany = $accompany;
	          $newaccompany[$result] = $result;               
	          $countaccompany = count($newaccompany);         
	          $newaccompany = serialize($newaccompany);
	          if($countaccompany < $aop){
	            $updatepassengerbooking = $this->mod_booking->updateaccompany($newaccompany, $bkID, $passID);
	            $this->session->set_userdata('create', show_message('<p>'.'Booking was updated successfully ...'.'</p>', 'success'));
	                           redirect('site/profile');
	          }elseif($countaccompany == $aop){
	            // echo "warning message"; die();
	            $this->session->set_userdata('warning', show_message('This booking is full ,if you want to add more people please contact to our sale!', 'warning'));
	            $this->session->set_userdata('hiddens', show_message('', 'hiddens'));
	            redirect('site/profile');
	          }
	          }
	       }
	      }else{
	        $this->session->set_userdata('create', show_message('Please check your completed form!', 'error'));
	      }
	      redirect('site/profile');
	  }
	  
	  
	 public function package_eticket() {
	        $bkID = $this->uri->segment(4);
	        $fe_data['eticket_collection'] = $this->mod_index->exportAllEtichet($bkID);
	        $fe_data['site_setting'] = "package_eticket";
	        $this->load->view('index', $fe_data);
	}
	
	public function customize_eticket(){
	      $cusID = $this->uri->segment(4);
	      $fe_data['eticket_customize'] = $this->mod_index->exportCustomizet($cusID);
	      $fe_data['site_setting'] = "customize_eticket";
	      $this->load->view('index', $fe_data);

	}
	
	/*
	  *public function upgrade_booking()
	  * update add more server that passengger need more
	  */ 
	  public function upgrade_booking(){
	    $bkID = $this->input->post('txtBooking');
	    $fe_data['extraService'] = $this->mod_booking->getAllExtraService(); 
	    $fe_data['totalPeople'] = $this->mod_booking->gettotalPeople();
	    $extraID  = $this->input->post('upgradextraservice');
	    $bookingPrice = MU_Model::getForiegnTableName('booking', array('bk_id'=> $bkID), 'bk_pay_price');
	    $aopID = $this->input->post('txtBooking');
	    $aop = MU_Model::getForiegnTableName('booking', array('bk_id'=> $aopID), 'bk_total_people');
	    $balance = MU_Model::getForiegnTableName('booking', array('bk_id'=> $bkID), 'bk_balance');
	    $deposit = MU_Model::getForiegnTableName('booking', array('bk_id'=> $bkID), 'bk_deposit');
	    if($this->input->post('addmore_service')){
	      $config = array(
	              array('field' => 'txtBooking', 'label' => 'Booking ID','rules' => 'trim|required'),
	                          array('field' => 'upgradextraservice','label' => 'Extra Service','rules' => 'trim|required')
	                          );
	        $this->form_validation->set_rules($config);
	        if ($this->form_validation->run() == FALSE) {
	                  $this->session->set_userdata('error', show_message('<p class="error">'.'Please complete the field required...'.'</p>', 'error'));
	              }else{
	          $extraPrice = $this->saveExtraProduct();
	          $balanceTotal = $balance + $extraPrice;
	          // var_dump($balanceTotal); die();
	          $updatebooking['bk_pay_price'] = ($bookingPrice + $extraPrice) * $aop;
	          $updatebooking['bk_balance'] = $balanceTotal;
	                  if(isset($updatebooking['bk_pay_price']) && $this->is_money($updatebooking['bk_pay_price'])){
	                      $result_booking = $this->mod_booking->updateBooking($updatebooking,$bkID);
	                      if($result_booking){
	                          $this->session->set_userdata('create', show_message('<p>'.'Booking was updated successfully ...'.'</p>', 'success'));
	                           redirect('site/profile');
	                          break;
	                      }
	                  }
	
	        }         
	    }
	  }
	  
	 public function is_money($price) {
	     return preg_match('/^[0-9]+(\.[0-9]{0,2})?$/', $price);
	 }
	 
	    public function saveExtraProduct(){     
	          $bkID = $this->input->post('txtBooking');
	          $extraservices = MU_Model::getForiegnTableName("booking",array('bk_id' => $bkID), 'bk_addmoreservice');
	          $extraservices = unserialize($extraservices);
	          $esID = $this->input->post('upgradextraservice');
	      	  $objRecord = $this->mod_booking->getExtraProductById($esID);
	      	  $extraproductactbooking = $objRecord->result();
	          $extraproductactbooking = json_decode(json_encode($extraproductactbooking), true);
	          $extraservices[$esID] = $extraproductactbooking[0];
	      	  $extraservices = serialize($extraservices); 
	       	  $result = $this->mod_booking->updateExtraservice($extraservices, $bkID);
	      	  $prices = $extraproductactbooking[0]['ep_saleprice'];
	      	  if($result != NULL){
	              return $prices;
	          }else{
	              return 0;
	          }
	    }
	    
	     /*
	    sending mail to admin 
	    after we want to add more passenger
	    */
	           public function contact_admin(){
	      		if($_FILES['userfile']['name']) {	    
			 $config['upload_path']      = 'user_uploads/files/'; 
			          $config['allowed_types']    = 'doc|docx|pdf|txt|xlm|zip|rar';
			          $config['max_size']     = '4000';
			          $this->load->library('upload', $config);
	            if ($this->upload->do_upload('userfile')) {
	                  $adminMail = MU_Model::getAdminEmail();
	                        $ret = $this->upload->data();
	                        $uploadedFile = $ret['full_path'];
	
	                        $sendFrom = $this->input->post('email');
	                        $subject = $this->input->post('subject');
	                        $text = $this->input->post('text');
	                        $bookingID = $this->input->post('txtBooking');
	                        $message = "Text".$text.'/n'."Booking ID".$bookingID;
	                        $this->email->clear();      
	                            $this->email->to($adminMail);
	                            $this->email->from($sendFrom);
	                            $this->email->subject($subject);
	                            $this->email->message($message);
	                            $this->email->attach($uploadedFile);
	                            $send = $this->email->send();
	                            $this->session->set_userdata('success', show_message('<p>'.'Your email successfuly sent!...'.'</p>', 'success'));
	                              redirect('site/profile');
	                              
	                }
	        }else{
	       
	         $this->session->set_userdata('error', show_message('Please check your completed form!', 'error'));
	         redirect('site/profile');
	       }
	
	  } 
	    
	/*
	@ change staus
	after and
	before booking
	*/
	public function status_booking($bk_status, $bk_id){
	        $total_rows = MU_Model::count_all_data('booking', array('bk_deleted' => 0));
	        $bk_status = ($bk_status == 1) ? 0 : 1;
	        $statuschaged = MU_Model::updateStatusById('booking', array("bk_status" => $bk_status), array('bk_id' => $bk_id));	        
	        $bk_msg = ($bk_statuss == 1) ? "Published" : "Unpublished";	
	        if($statuschaged){
	            $this->session->set_userdata('create', show_message('The booking have been '.$bk_msg.' successfully.', 'success'));
	            redirect($redirect);
	        }else{
	            $this->session->set_userdata('create', show_message('Cannot '.$bk_msg.' record on table name booking.', 'error'));
	            redirect($redirect);
	        }
	    }
	    
	/*
	@ the end of 
	change booking
	*/
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
	  
    public function profile(){
	    $fe_data['title'] = "profile user";
	    $fe_data['extraService'] = $this->mod_booking->getAllExtraService();
	    $fe_data['txtPhotos'] = $this->mod_booking->getPhotos();
	    $fe_data['menu_fe'] = $this->mod_index->getAllMenu();
	    $fe_data['site_setting'] = "profile";
	    $passegnger_id = $this->session->userdata('passengerid');
	   // $passegnger_id = $this->mod_fecustomize->getCurrentPassengerId();
	    $fe_data['old_gender'] = array('' => '-- Select --', 'F' => 'Female', 'M' => 'Male');
	    $fe_data['old_txtStatus'] = array('0' => 'Unpublished','1' => 'Published');
	    $fe_data['profile'] = $this->mod_profilefe->pass_profilefe($passegnger_id);
	    $fe_data['passengerbooking_info'] = $this->mod_profilefe->passenger_bookedform($passegnger_id);
	    
	    if ($this->input->post('frm_profile')){      
	      $fname      =   $this->input->post('firstname');
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
	
	    if ($this->uri->segment('4') == 'view_detail_bk') {
	      $fe_data['booking_info'] = $this->view_detail_bk($this->uri->segment('5'));
	    }
	
	    $this->load->view('index',$fe_data);
  }

	  /*
	  * public function view_detail_bk
	  * @param $bk_id (int)
	  * 
	  */
	   function view_detail_bk($bk_id) {
	    $pass_id = $this->getCurrentPassengerId();
	    $bkInfo = $this->mod_fecustomize->bookingInfoByPassengerIDAndBookingID($bk_id, $pass_id);
	
	    return $bkInfo;
	  }

	  /*public function customizePersonal_info($passenger_id){ 
	    return $this->mod_fecustomize->customizePersonal_info($passenger_id);
	  }*/
	
	  /*
	  * Get current user id
	  */
	  function getCurrentPassengerId() {
	    $login_sess_passenger = $this->session->userdata('passenger');
	    $new_sess_passenger = $this->session->userdata('new_passenger_id');
	    $pass_id = -1;
	    if ($new_sess_passenger OR $login_sess_passenger) {
	
	        if ($new_sess_passenger != '') {
	            $pass_id = $new_sess_passenger['pass_id'];
	        }
	        if ($login_sess_passenger != '') {
	            $pass_id = $login_sess_passenger['pass_id'];
	        }
	    }
	    return $pass_id;
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
	        if($this->input->post('select_value')){ 
	          $decrypted_id = $this->input->post('select_value'); 
	          if(is_numeric($decrypted_id)){
	            $fe_data['getFtvByLcID'] = $this->mod_booking->getFtvByLcID($decrypted_id);
	          }else{
	            $fe_data['param2error'] = "error";
	          }
	        }else{
	          $this->session->set_userdata('ftvID', $this->input->post('ftv_id'));
	          $this->session->set_userdata('lcID', $this->input->post('location_id'));          
	        }
	      }else{
	        $salt = "90408752631";
	          $decrypted_id = base64url_decode($param2);
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

		////////////////////    START CUSTOMIZE BOOKING SECTION        //////////////////////


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
		$this->general_lib->empty_room_booking();
		$this->general_lib->empty_hotel_ids();
	}
        
        
    	/*
	* public function customize
	* @param $display_page default (false)
	* load template customizes and include customize
	*/
        public function customizes($display_page = false, $pass_id = false){
 
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
		$fe_data['recordAccommodation'] = $this->customizeAccommodation();

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
				//$this->general_lib->empty_personalInfo_message();

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

					$passengerInfo = array(
						'has_passenger'		=> true,
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
//var_dump($this->input->post('actPeopleMainActivity')); 
		$this->general_lib->set_main_activities($this->input->post('checkbox_activity'));
		$this->general_lib->set_start_date_activity($this->input->post('txtFrom'));
		$this->general_lib->set_end_date_activity($this->input->post('txtTo'));
		$this->general_lib->set_sub_activities($this->input->post('checkbox_subactivity'));
		$this->general_lib->set_extra_activities($this->input->post('checkbox_extra'));
		$this->general_lib->set_amount_extra($this->input->post('amountextras'));
		$this->general_lib->set_people_sub_activity($this->input->post('actPeopleSubActivity'));
		$this->general_lib->set_people_main_activity($this->input->post('actPeopleMainActivity'));

//var_dump($this->general_lib->get_people_main_activity()); die();
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
		$this->general_lib->set_hotel_ids($this->input->post('hotelIDs'));

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
			$password = $this->generatePassword();
			$this->session->set_userdata('pass_password',$password);
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
	            'pass_password'	=> $password,
	            'pass_gender'       => $this->session->userdata('pass_gender'),
	            'pass_status'       => $this->session->userdata('pass_status'),
	            'pass_deleted'      => $this->session->userdata('pass_deleted'),
			);
			$result  = $this->mod_fecustomize->personal_information($passengerInfo, $pass_id);
			if ($pass_id != -1) {
				$pass_id = $pass_id;
			} else {
				$pass_id = $result;
			}
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
							// $this->emailTOadmin($subsc);
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
			if ($bk_info['bk_id']) {
				$pass_bk_info = array(
	                'pbk_pass_id' => $pass_id,
	                'pbk_bk_id' => $bk_info['bk_id']
	            );

	            $pbk_inserted = $this->mod_fecustomize->insertPassengerBookingInfo($pass_bk_info, $pass_id, $bk_info['bk_id']);
			}

			if ($bk_info['bk_id']) {
				foreach($dataAccommodation as $dataAcc) {
					foreach($dataAcc as $dataAccomm) {
						foreach ($dataAccomm['room_booked_info'] as $room_book_infos) {
							// Add new index to array $room_book_infos of booking_id
							$room_book_infos['booking_id'] = $bk_info['bk_id'];
							$this->mod_fecustomize->insertRoomBookInfo($room_book_infos);
						}
					}
				}
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
				// $field_select = 'tp_id, tp_name, tp_purchaseprice, tp_saleprice, tp_actualstock, tp_texteticket';
				$object = $this->mod_fecustomize->get_info_of_transportation($id);
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
						// $field_select = 'ep_id, ep_name, ep_perperson, ep_perbooking, ep_etickettext, ep_purchaseprice, ep_saleprice, ep_actualstock';
						$product = $this->mod_fecustomize->get_info_of_extra_service($product_id);
						$product->amount = $amount_extra_pro[$id][$product_id];
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
		$hotel_ids = $this->general_lib->get_hotel_ids();

		$arraAccommodations = array();
		if ($this->general_lib->get_accommodation() != "") {
			foreach ($this->general_lib->get_accommodation() as $id) {
				$object = $this->mod_fecustomize->get_info_of_accommodation($id);
				$num_people = array();
				$products = array();
				$arr_rooms = array();
				$amount_rm_bked = array();
				$room_booked = array();
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
						$product = $this->mod_fecustomize->get_info_of_extra_service($product_id);
						$product->amount = $amount_extra_pro[$id][$product_id]; //chhing
						array_push($products, $product);
					}
				}
				if (isset($room_type[$id])) {
					foreach ($room_type[$id] as $key_hotel => $items) {
						foreach ($items as $rt_id) {
							$room = $this->mod_fecustomize->get_info_hotel($rt_id);
							if (isset($amount_room_book[$id])) {
								foreach ($amount_room_book[$id] as $arra_room_nums) {
									foreach ($arra_room_nums as $num) {
										if ($num[$rt_id] != '') {
											// Set data or room_booked
											$room_booked_info = array(
												'rbht_id' 		=> $key_hotel,
												'rbrt_id' 		=> $rt_id,
												'rbclass_id' 	=> $object->classification_id,
												'amount_book' => $num[$rt_id],
												'check_in' 		=> $departure[$id],
												'check_out'		=> $return_date[$id]
											);
											array_push($room_booked, $room_booked_info);

											// Assign amount number of booking room type
											$room->amount = $num[$rt_id];
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
						'accom' => $arr_rooms,
						'room_booked_info' => $room_booked,
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
				$object = $this->mod_fecustomize->get_info_of_activity($id);
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
					foreach ($sub_activities[$id] as $key => $sub_act_id) {
						$sub_act = $this->mod_fecustomize->get_info_of_activity($sub_act_id);
						/*if ($key == $id) {
							if (!empty($sub_act_people[$id][$sub_act_id])) {
								$sub_act->amount = $sub_act_people[$id][$sub_act_id];
							}
						} else {
							continue;
						}*/
						$sub_act->amount = $sub_act_people[$id][$sub_act_id];
						/*if ($key == $id) {
							if (isset($sub_act_people[$id])) {
								if (isset($sub_act_people[$id][$sub_act_id])) {
									$sub_act->amount = $sub_act_people[$id][$sub_act_id];
								}
							}
						} else {
							$sub_act->amount = '0';
						}*/
						array_push($sub_acts, $sub_act);
					}

				}
				// die();

				if (isset($extra_pro[$id])) {
					foreach ($extra_pro[$id] as $product_id) {
						$product = $this->mod_fecustomize->get_info_of_extra_service($product_id);
						$product->amount = $amount_extra_pro[$id][$product_id];
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
				$object = $this->mod_fecustomize->get_info_of_extra_service($id);
				$object->amount = $amount_extra_pro[$id][0]; //chhing
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
	        if($send){
	        	$this->emailToPassenger();
	        }
	}
	
	public function emailToPassenger(){
		$adminMail = MU_Model::getAdminEmail();
		$email = $this->session->userdata('pass_email');
		$password = $this->session->userdata('pass_password');
		$username = $this->session->userdata('pass_fname');
		if($adminMail == ""){
			$adminMail = "mysoftware77@gmail.com";
		}
		$message = "You have been Booking your trip and you have created an account in the Munich Site". "\n" ." So these are the Username and Password of your account"."\n";
		$message .= "Username : ".$email."\n";
		$message .= "Password : ".$password."\n";
		$this->email->clear();	    
	        $this->email->to($email);
	        $this->email->from($adminMail);
	        $this->email->subject("Welcome to Munich Booking !");
	        $this->email->message($message);
	        $send = $this->email->send();

	}

        
        // Response when using ajax call to show room booking available
	function getAmountRoomBooking() {
		$checked_in = $this->input->post('checked_in');
		$checked_out = $this->input->post('checked_out');
		$acc_id = $this->input->post('acc_id');
		$classification_id = $this->input->post('classification_id');
		$hotel_id = $this->input->post('hotel_id');

		$hotels = $this->mod_fecustomize->getAllHotels($classification_id);
		$htOrder = 0;
		$panel = '<div id="room_offering_'.$acc_id.'">';
		foreach ($hotels->result() as $hotel) {
			$detail_hotels =  $this->mod_fecustomize->getHotelDetailByHotelIDAndClassification($classification_id, $hotel->dhht_id)->result();
			$htOrder++;
			$panel .= '<div class="form-group room_types col-sm-12">';
			$panel .= '<div class="col-sm-12">';
			$panel .= '<div class="panel-group" id="accordion">';
			$panel .= '<div class="panel panel-success">';

			$panel.= '<div class="panel-heading">';
			$panel .= '<h4 class="panel-title">';
			$panel .= '<a data-toggle="collapse" data-parent="#accordion" href="#roomType_'.$htOrder.'">';
			$panel .= '<span class="icon icon-home"></span> Offer '.$htOrder.'<span class="caret"></span>';
			$panel .= '</a>';
			$panel .= '</h4>'; // End class="panel-title"
			$panel .= '</div>'; // End class="panel-heading"

			$panel .= '<div id="roomType_'.$htOrder.'" class="panel-collapse collapse in">';
			$panel .= '<div class="panel-body">';
			foreach ($detail_hotels as $item) {
				$panel .= '<div class="row">';

				$panel .= '<div class="col-xs-9">';
				$panel .= '<span>';
				$rooms = $this->general_lib->get_room_type_accommodation();
				$checked = false;
				if ($rooms != '') {
					if (isset($rooms[$acc_id])) {
						foreach ($rooms[$acc_id] as $rm_hotel) {
							foreach ($rm_hotel as $each_item) {
								if ($each_item == $item->rt_id) {
									$checked = true;
								}
							}
						}
					}
				}
				$amount_available = 0;
				$amount_rm_booked = $this->mod_fecustomize->getAmountRoomBooking($checked_in, $checked_out,$item->dhcl_id,$item->dhht_id,$item->dhrt_id);
				foreach ($amount_rm_booked->result() as $rm_book_obj) {
					$amount_booked = $rm_book_obj;
				}

				$actual_stock = $item->dhrm_originalstock;
				$num_booked = $amount_booked->amount_book;
				$amount_availabled = $actual_stock - $num_booked;

				$room_date_available = $this->mod_fecustomize->getRoomDateAvailable($checked_in, $checked_out, $item->dhrt_id, $item->dhht_id, $item->dhcl_id);
				if ($amount_availabled <= 0) {
					$panel .= "<span class='require'>* </span>It will available from <span class='amount-room'>".$room_date_available."</span>, Amount room: <span class='amount-room'>".$item->dhrm_originalstock."</span><br/>";
				} else {
					$panel .= "<span class='require'>* </span>It available <span class='amount-room'>today</span>, Amount room: <span class='amount-room'>".$amount_availabled."</span><br/>";
				}

				$room_type_checked = array(
					'value' => $item->rt_id, 
					'checked' => $checked, 
					'class' => 'check_main_element', 
					'name' => 'room_type_checked['.$acc_id.']['.$item->dhht_id.']['.$item->rt_id.']', 
					'id' => "room_type_checked"
				);
				$panel .= form_checkbox($room_type_checked);
				$panel .= form_hidden('hotelIDs['.$classification_id.']['.$item->dhht_id.']', $item->dhht_id);
				$panel .= nbs();
				$panel .= $item->rt_name;
				$panel .= nbs();
				$panel .= '(Amount people per room: <spa class="amount-room">'.$item->rt_people_per_room.'</span>)';

				$panel .= '</span>';
				$panel .= '</div>'; // End class="col-xs-9"

				$panel .= '<div class="col-xs-3">';
				$amount_rooms_booked = $this->general_lib->get_amount_book_room();
				$value = '';
				if (isset($amount_rooms_booked[$acc_id])) {
					foreach ($amount_rooms_booked[$acc_id] as $item_arra) {
						if (isset($item_arra[$classification_id][$item->rt_id])) {
							$value = $item_arra[$classification_id][$item->rt_id];
						}
					}
				}

				$input = array(
					'name' => 'amount_book_room['.$acc_id.']['.$hotel_id.']['.$classification_id.']['.$item->rt_id.']',
					'class' => 'form-control input-sm theTooltip',
					'placeholder' => 'Amount Room',
					'value' => $value,
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'title' => 'Amount Room'
				);
				$panel .= form_input($input);

				$panel .= '</div>'; // End class="col-xs-3"

				$panel .= '</div>'; // End class="row"
			}
			$panel .= '</div>'; // End of class="panel-body"
			$panel .= '</div>'; // End of class="roomType_".$htOrder
			$panel .= '</div>'; // End of class="panel panel-success"
			$panel .= '</div>'; // End of class="panel-group" id="accordion"
			$panel .= '</div>'; // End of class="col-sm-12"
			$panel .= '</div>'; // End of class="form-group room_types col-sm-12"
		}
		$panel .= '</div>';

		echo $panel;
	}
	
/////////////////////////   END CUSTOMIZE SECTION    ///////////////////////////////////
  
  
  
/////////////////////////////////// PACKAGE SECTION ///////////////////////////////////////

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
		}elseif($display_page == "showservice"){
			$fe_data["packageExtraservice"] = $this->ChooseExtraService();
			// if($this->session->userdata('nop')){
			// 	$amount = $this->session->userdata('nop');
			// 	for($i = 1; $i <= $amount; $i++){
			// 		$selamount[$i] = $i;
			// 	}

			// 	$fe_data["selectAmount"] = $selamount;
			// }
		}elseif($display_page == "infostep"){
			$fe_data["packagefinalStep"] = $this->showFinalStep();
		}elseif($display_page == "tripinfo"){
			if($this->input->post('tripinfoSubmit')){
				$config = array(
					 array('field' => 'numPassenger','label' => 'amount of passenger','rules' => 'trim|required|integer'),
					 array('field' => 'dpDate','label' => 'departure date','rules' => 'trim|required'),
					 // array('field' => 'rtDate','label' => 'return date','rules' => 'trim|required'),
				);
				$this->form_validation->set_rules($config);
	           		if ($this->form_validation->run() != FALSE) {
	
	           			$dpdate = $this->input->post('dpDate');
	           			// $rtdate = $this->input->post('rtDate');
	           			$numOfPass = $this->input->post('numPassenger');
	
	           			// if ((strtotime($dpdate)) <= (strtotime($rtdate))){
	           				$this->session->set_userdata('dpd', $dpdate);
	           				// $this->session->set_userdata('rtd', $rtdate);
	           				$this->session->set_userdata('nop', $numOfPass);
	           				redirect('site/packages/');
	           			// }else{
	           			// 	$fe_data['dpdrtderror'] = "The return date cannot bigger than departure date.";
	           			// }
	           		}
			}
		}
		$this->load->view('index', $fe_data);
	}

	/*
	* public function allpackage
	* @noparam
	* @access by packages()
	* return all available packages.
	*/
	public function allpackages(){
		$ftv = $this->session->userdata('ftvID');
		$lc = $this->session->userdata('lcID');
		$dpdate = $this->session->userdata('dpd');
		$ppl = $this->session->userdata('nop');
		// $rtdate = $this->session->userdata('rtd');
		$allpackages = $this->mod_fepackage->getallpackages($ppl, $ftv, $lc, $dpdate);
		return $allpackages;
	}

	/*
	* public function packagesDetail
	* @noparam
	* @access by packages()
	* return detail of each package
	*/
	public function packagesDetail(){
		$key = "90408752631";
        	$pk_id = base64url_decode($this->uri->segment(5), $key);
        	$this->session->set_userdata('pkID', $pk_id);
		$detailpackages = $this->mod_fepackage->getdetailpackages($pk_id);
		return $detailpackages;
	}

	/*
	* public function ChooseExtraService
	* @noparam
	* @access by 
	* return detail of extraproduct
	*/

	public function ChooseExtraService(){
		$servcies = $this->mod_fepackage->getExtraService();
		if($this->input->post('submitService')){
			$epschecked = $this->input->post('epchecked');
			$epscheckedamount = $this->input->post('useramount');
			if($epschecked == false){				
				$this->session->unset_userdata('extraservice');
				redirect('site/packages/infostep/');
			} else {
				$this->session->set_userdata('extraservice', $epschecked);
				$this->session->set_userdata('extraserviceamount', $epscheckedamount);
				redirect('site/packages/infostep/');
			}	
		}
		return $servcies;
	}

	/*******/
	public function showFinalStep(){

		$error['mobilephoneinput'] = '';
		$error['aboutYouInput'] = '';

		if($this->input->post('btnFinalstep')){
			$config = array(
				// array('field' => 'numPassenger','label' => 'number of passenger','rules' => 'trim|required|integer|max_length[2]'),
				// array('field' => 'dpDate','label' => 'departure date','rules' => 'trim|required'),
				// array('field' => 'rtDate','label' => 'return date','rules' => 'trim|required'),
				array('field' => 'fname','label' => 'first name','rules' => 'trim|required|max_length[50]'),
				array('field' => 'lname','label' => 'last name','rules' => 'trim|required|max_length[50]'),
				array('field' => 'uemail','label' => 'email','rules' => 'trim|required|valid_email'),
				array('field' => 'phone','label' => 'phone','rules' => 'trim|required'),
				array('field' => 'country','label' => 'country','rules' => 'trim|required'),
				array('field' => 'city','label' => 'city','rules' => 'trim|required'),
				array('field' => 'address','label' => 'address','rules' => 'trim|required'),
			);

			// booking data
			$insertBooking['bk_total_people'] = $this->session->userdata('nop');
			$insertBooking['bk_arrival_date'] = $this->session->userdata('dpd');
			// $insertBooking['bk_return_date'] = $this->session->userdata('rtd');			
    			$today = date("Y-m-d");
			$insertBooking['bk_date'] = $today;
			$insertBooking['bk_type'] = 'package';
			$bkfee = $this->input->post('bookingfee');
			$pkprice = $this->input->post('pkPrice');
			// passenger data
			$insertPassenger['pass_fname'] = $this->input->post('fname');
			$insertPassenger['pass_lname'] = $this->input->post('lname');
			$insertPassenger['pass_gender'] = $this->input->post('gender');
			$insertPassenger['pass_email'] = $this->input->post('uemail');
			$insertPassenger['pass_phone'] = $this->input->post('phone');
			$insertPassenger['pass_mobilephone'] = $this->input->post('mobilephone');
			$insertPassenger['pass_country'] = $this->input->post('country');
			$insertPassenger['pass_city'] = $this->input->post('city');
			$insertPassenger['pass_address'] = $this->input->post('address');
			$insertPassenger['pass_about'] = $this->input->post('aboutYou');
			$insertPassenger['pass_status'] = 1;
			$insertPassenger['pass_deleted'] = 0;
			// $insertPassenger[''] = $this->input->post('');
			// other
			$payby = $this->input->post('payby');

			$this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
            	if($this->inputvalidation()) $error = $this->inputvalidation();
            	if($this->input->post('term')) $error['termcheck'] = TRUE; else $error['termcheck'] = FALSE;
            	if($this->input->post('bookingfee')) $error['bookingfeecheck'] = TRUE; else $error['bookingfeecheck'] = FALSE;
            	if($this->input->post('payby')) $error['paycheck'] = $this->input->post('payby'); else $error['paycheck'] = FALSE;
            	if($this->input->post('gender')) $error['gendercheck'] = $this->input->post('gender'); else $error['gendercheck'] = FALSE;
            	if($this->input->post('mobilephone')) $error['mobilephoneinput'] = $this->input->post('mobilephone'); else $error['mobilephoneinput'] = "";
            	if($this->input->post('aboutYou')) $error['aboutYouInput'] = $this->input->post('aboutYou'); else $error['aboutYouInput'] = "";
            	return $error;
            }else{
            	if(! $this->inputvalidation() && $this->input->post('term') && $this->input->post('bookingfee') && $this->input->post('term') && $this->input->post('gender') && $this->input->post('payby')){
            		$insertBooking['bk_pay_price'] = $bkfee + $pkprice;
            		$insertBooking['bk_addmoreservice'] = NULL;
            		if($this->session->userdata('extraservice')){
            			$addservice = $this->session->userdata('extraservice');
            			$addserviceamount = $this->session->userdata('extraserviceamount');
            			foreach($addservice as $services){
            				$extrapro = $this->mod_fepackage->getExtraProductById($services);
            				$extrapro = json_decode(json_encode($extrapro->result()), true);
            				$insertBooking['bk_pay_price'] += ($extrapro[0]['ep_saleprice']*$addserviceamount[$services]);
            				$insertBooking['bk_addmoreservice'][$services] = $extrapro[0];
            				$insertBooking['bk_addmoreservice'][$services]['amount'] = $addserviceamount[$services];
            			}
            		}
            		if($insertBooking['bk_addmoreservice'] != NULL) $insertBooking['bk_addmoreservice'] = serialize($insertBooking['bk_addmoreservice']);
            		$insertBooking['bk_pay_price'] = $insertBooking['bk_pay_price'] * $insertBooking['bk_total_people'];
            		$insertBooking['bk_balance'] = $insertBooking['bk_pay_price']; // balance will update a deposit with pay now process
            		
            		$bookingId = $this->mod_fepackage->insertDataBooking($insertBooking);
            		if($bookingId){

            			$this->session->set_userdata('bookingid', $bookingId);
            			$insertPassenger['pass_password'] = $this->generatePassword();
            			$passId = $this->mod_fepackage->insertDataPassenger($insertPassenger);
            			if($passId){
            				$this->session->set_userdata('passengerid', $passId);
            				$pbID = $this->mod_fepackage->insertPassengerBooking($passId, $bookingId);
            				if($pbID){

            					// need to insert booking ID and package ID into table sale package and update package stock
		            			$pkID = $this->session->userdata('pkID');
		            			$this->mod_booking->insertsalepackage($pkID, $bookingId);
		            			// $pkStock = MU_Model::getForiegnTableName('package_conjection',array('pkcon_id'=> $pkID), 'pkcon_actualstock');
		                        // if($pkStock > 0){
		                        //    $pkStock = $pkStock - 1;
		                        //    MU_Model::updateStockAll('package_conjection',array('pkcon_id'=> $pkID),array('pkcon_actualstock'=> $pkStock));
		                        //}

            					$this->sendemail($insertBooking, $insertPassenger);
            					$key = "NLOPSYSMB";
        						$key = $key.$bookingId;
        						$bkID = base64url_encode($key);
            					if($payby == 'paylater'){ 
            						$this->session->set_userdata('successbooking', 'true');
            						$this->clearSessionPackage(array('extraservice','extraserviceamount','pkID','nop','dpd','ftvID', 'lcID'));        						
            						redirect("site/pagesucceed/".$bkID, "location");
            						// $this->paypal($insertBooking, $insertPassenger, $bookingId);
            					}elseif($payby == 'paynow'){
            						redirect("site/paynow/".$bkID, "location");
            						// $this->ideal($insertBooking, $insertPassenger);
            					}
            				}
            			}else{
            				$this->session->unset_userdata('bookingid');
            			}
            		}else{
            			$this->session->unset_userdata('bookingid');
            		}
            	}else{
            		$error = $this->inputvalidation();
            		if($this->input->post('term')) $error['termcheck'] = TRUE; else $error['termcheck'] = FALSE;
	            	if($this->input->post('bookingfee')) $error['bookingfeecheck'] = TRUE; else $error['bookingfeecheck'] = FALSE;
	            	if($this->input->post('payby')) $error['paycheck'] = $this->input->post('payby'); else $error['paycheck'] = FALSE;
	            	if($this->input->post('gender')) $error['gendercheck'] = $this->input->post('gender'); else $error['gendercheck'] = FALSE;
	            	if($this->input->post('mobilephone')) $error['mobilephoneinput'] = $this->input->post('mobilephone'); else $error['mobilephoneinput'] = "";
	            	if($this->input->post('aboutYou')) $error['aboutYouInput'] = $this->input->post('aboutYou'); else $error['aboutYouInput'] = "";
	            	return $error;
            	}
            }
          }
		return $error;
	}

	function inputvalidation(){
		$a = array();
		if($this->input->post('uemail')){
			if($this->emailExistCheck($this->input->post('uemail'))){
				$a['emailerror'] = "The email already used...";
			}
		}

		if($this->input->post('fname')){
			if(! $this->alpha_dash_space($this->input->post('fname'))){
				$a['fnameError'] = "The first name was not allowed specail charactor...";
			}
		}

		if($this->input->post('lname')){
			if(! $this->alpha_dash_space($this->input->post('lname'))){
				$a['lnameError'] = "The last name was not allowed specail charactor...";
			}			
		}

		if($this->input->post('phone')){
			if(! $this->formatPhone($this->input->post('phone'))){
				$a['phoneError'] = "Invalid format of phone number...";
			}
		}
		
		if($this->input->post('mobilephone')){
			if(! $this->formatPhone($this->input->post('mobilephone'))){
				$a['mobilePhoneError'] = "Invalid format of mobile phone number...";
			}
		}

		if($a == false){
			return false;
		}else{
			return $a;
		}
	}

	// Allow the string input only the alphabet, dash, and space
	function alpha_dash_space($name)
	{
	    return ( ! preg_match("/^([-a-z_ ])+$/i", $name)) ? FALSE : TRUE;
	}

	// Check the email user existing.
	function emailExistCheck($email){
		$emailRecord = MU_Model::getRecordById('passenger', array('pass_email' => $email));
		if($emailRecord->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	// check phone format
	public function formatPhone($phone){
		$phone_pattern_one = "/^\d(?:[-\s]?\d){5,14}$/";
		$phone_pattern_two = "/^\+?\d(?:[-\s]?\d){6,15}$/";
		if(preg_match($phone_pattern_one, $phone)){;
			return true;
		}elseif(preg_match($phone_pattern_two, $phone)){
			return true;
		}else{
			return false;
		}
	}

	/*
	*	Function generate password
	*/
	function generatePassword(){
	 	// generate password
		$alph = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789@#$";
		$pasword = array(); // remember to declare $pass as an array
		$alphLength = strlen($alph) - 1; // put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphLength);
			$pasword[] = $alph[$n];
		}
		$PasswordGenerate = implode($pasword); //turn the array into a string
		return $PasswordGenerate;
	}
	
	/////////////// function send email to admin and access to paypal ///////////////////////

	public function sendemail($booking, $passenger){
		$adminEmail = MU_Model::getAdminEmail();
		$this->email->set_mailtype("html"); 
	    $this->email->clear();
        $msgTo = $this->email->to($passenger['pass_email']);
        $msgFrom = $this->email->from($adminEmail); // get admin email from table passenger.
        $msgBcc = $this->email->bcc($adminEmail); // get admin email from table passenger.
        $msgSubject = $this->email->subject("Confirmation and Login Information");  
        $messages = '<p>Dear '.$passenger['pass_fname'].' '.$passenger['pass_lname'].',</p>
<p>Thank for using our service and product which you have booking tour by the following information below: </p>
<span><b>Booking Information</b></span><br />
<span>Booking date: </span><span>'.$booking['bk_date'].'</span><br />
<span>Departure date: </span><span>'.$booking['bk_arrival_date'].'</span><br />
<span>Return date: </span><span>'.$booking['bk_return_date'].'</span><br />
<span>Booking type: </span><span>'.$booking['bk_type'].'</span><br />
<span>Total people: </span><span>'.$booking['bk_total_people'].'</span><br />
<span>Booking price: </span><span>'.$booking['bk_pay_price'].'$</span><br /><br />
<span><b>Your Information</b></span><br />
<span>Name: </span><span>'.$passenger['pass_fname'].' '.$passenger['pass_lname'].'</span><br />
<span>Email: </span><span>'.$passenger['pass_email'].'</span><br />
<span>Phone: </span><span>'.$passenger['pass_phone'].'</span><br />
<span>Country: </span><span>'.$passenger['pass_country'].'</span><br />
<span>City: </span><span>'.$passenger['pass_city'].'</span><br />
<span>Address: </span><span>'.$passenger['pass_address'].'</span><br />
<span>About you: </span><span>'.$passenger['pass_about'].'</span><br /><br />
<span><b>Login Information</b></span><br />
<span>Email: </spaln><span>'.$passenger['pass_email'].'</span><br />
<span>Password: </spaln><span>'.$passenger['pass_password'].'</span><br />
<p>Click <a href="'.base_url().'fe_login/loginuser">login</a> to detail about booking or download e-ticket.</p>
<span>NOTE: you must be easily accessible throughout the procedure.</span><br />
<span>Team: </span><br />
<span>Email </span><br />
';
		$this->email->message($messages);
        $resultemail = $this->email->send();

        if(! $resultemail){
        	die('Error...');
        }
	}

	// public function paypal($booking, $passenger, $bookingId){
	// 	$key = 'NLOPSYSMB'.$bookingId;
	// 	$bk_id = base64url_encode($key);
	// 	$parameters = array(
	// 		'cmd' => '_xclick',
	// 		'business' => 'john@nl.nl',
	// 		'amount' => $booking['bk_pay_price'],
	// 		'item_name' => 'MB'.$bookingId,
	// 		'currency_code' => 'USD',
	// 		'return' => 'http://masterbooking.codingate.com/nl/site/ipn_listener',
	// 		'cancel_return' => 'http://masterbooking.codingate.com/nl/site/payCancel/'.$bk_id,
	// 		'notify_url' => 'http://masterbooking.codingate.com/nl/site/ipn_listener'
	// 	);
	// 	$url = $this->urlparameter($parameters);		
	// 	header("Location: ". $url);
	// }
	
	// public function urlparameter($parameters){
	// 	parse_str($_SERVER['QUERY_STRING'], $old_parameters_as_array);
	//     return "https://www.sandbox.paypal.com/cgi-bin/webscr".'?'.http_build_query(array_merge($old_parameters_as_array, $parameters));
	// }

	// // identify the pay IPN
	// function ipn_listener(){
	
	// // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
	// 	// Instead, read raw POST data from the input stream. 
	// 	$raw_post_data = file_get_contents('php://input');
	// 	$raw_post_array = explode('&', $raw_post_data);
	// 	$myPost = array();
	// 	foreach ($raw_post_array as $keyval) {
	// 	  $keyval = explode ('=', $keyval);
	// 	  if (count($keyval) == 2)
	// 	     $myPost[$keyval[0]] = urldecode($keyval[1]);
	// 	}
	// 	// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
	// 	$req = 'cmd=_notify-validate';
	// 	if(function_exists('get_magic_quotes_gpc')) {
	// 	   $get_magic_quotes_exists = true;
	// 	} 
	// 	foreach ($myPost as $key => $value) {        
	// 	   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
	// 	        $value = urlencode(stripslashes($value)); 
	// 	   } else {
	// 	        $value = urlencode($value);
	// 	   }
	// 	   $req .= "&$key=$value";
	// 	}
		 
	// 	// POST IPN data back to PayPal to validate
		
	// 	$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
	// 	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	// 	curl_setopt($ch, CURLOPT_POST, 1);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	// 	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		
	// 	// In wamp-like environments that do not come bundled with root authority certificates,
	// 	// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
	// 	// the directory path of the certificate as shown below:
	// 	// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
		
	// 	if( !($res = curl_exec($ch)) ) {
	// 	    // error_log("Got " . curl_error($ch) . " when processing IPN data");
	// 	    echo "exist Here curl_curl_exec";
	// 	    curl_close($ch);
	// 	    exit;
	// 	}
	// 	curl_close($ch);
		 
	// 	// Inspect IPN validation result and act accordingly
		
	// 	if (strcmp ($res, "VERIFIED") == 0) {
	// 	    // The IPN is verified, process it:
	// 	    // check whether the payment_status is Completed
	// 	    // check that txn_id has not been previously processed
	// 	    // check that receiver_email is your Primary PayPal email
	// 	    // check that payment_amount/payment_currency are correct
	// 	    // process the notification
			
	// 	    // assign posted variables to local variables
	// 	    $item_name = $_POST['item_name'];
	// 	    $item_number = $_POST['item_number'];
	// 	    $payment_status = $_POST['payment_status'];
	// 	    $payment_amount = $_POST['mc_gross'];
	// 	    $payment_currency = $_POST['mc_currency'];
	// 	    $txn_id = $_POST['txn_id'];
	// 	    $receiver_email = $_POST['receiver_email'];
	// 	    $payer_email = $_POST['payer_email'];
	// 	    $pay_date = $_POST['payment_date'];
		    
	// 	    // IPN message values depend upon the type of notification sent.
	// 	    // Update table booking about payment_status(1 == "Completed", 2 = "Panding", 3 = "Failed", 4 = "Unclaimed") and pay_id (txn_id)
		    
	// 	    if($item_name){
	// 		   	$idBooking = explode("B", $item_name);
	// 		   	if(count($idBooking) > 0){
	// 		   		$this->mod_fepackage->updateBookingPackage($idBooking[1], $payment_status,$txn_id, $pay_date);
	// 		   		$this->mod_fepackage->updatePackage($idBooking[1]);
	// 		   	}
	// 	    }

	// 	    $key = 'NLOPSYS'.$item_name;
	// 	    $bk_id = base64url_encode($key);
	// 	    redirect("site/paysucceed/".$bk_id, "location");
	// 	} else if (strcmp ($res, "INVALID") == 0) {
	// 	    // IPN invalid, log for manual investigation
	// 	    echo "The response from IPN was: <b>" .$res ."</b>";
	// 	}
	
	// }
	
	public function clearSessionPackage($ssion = array()){
		if($ssion != false){
			foreach($ssion as $ss){
				if($this->session->userdata($ss)){
					$this->session->unset_userdata($ss);
				}
			}
		}
	}
	
	public function pagesucceed($bkID = false){
		$key = "NLOPSYSMB";
		$bookingID = $bkID;
		$bkID = base64url_decode($bkID, $key);
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['getbooking'] = MU_Model::getRecordById('booking',array('bk_id'=>$bkID));
		$mainpassID = MU_Model::getForiegnTableName('passenger_booking', array('pbk_bk_id'=>$bkID), 'pbk_pass_id');
		$passbooking = MU_Model::getForiegnTableName('passenger_booking', array('pbk_bk_id'=>$bkID), 'pbk_pass_come_with');
		if($passbooking){			
			$fe_data['passengerbooking'] = unserialize($passbooking);
			$fe_data['passengerbookingrecord'] = $this->mod_fepackage->getPassengerBooking($fe_data['passengerbooking']);
			// getRecordById
		}else{
			$fe_data['passengerbooking'] = array();
		}
		
		$fe_data['passengerbooking_info'] = $this->mod_profilefe->passenger_bookedform($mainpassID);
		$fe_data['passDetail'] = MU_Model::getRecordById('passenger', array('pass_id' => $mainpassID));
		$np = MU_Model::getForiegnTableName('booking', array('bk_id'=>$bkID), 'bk_total_people');
		$fe_data['packagefinalStep'] = array();
		$fe_data['packagefinalStep']['mobilephoneinput'] = '';
		$fe_data['packagefinalStep']['aboutYouInput'] = '';
		if(($fe_data['passengerbooking'] != false) && ((count($fe_data['passengerbooking'])+1) == $np)){
			$fe_data['errornp'] = 'You have booking for '.($np - 1).' passengers including you. For add more amount of passenger, please make a <a href="#" data-toggle="modal" data-target=".pkcontactadmin">request to admininistor</a>.';
		}
		if($this->input->post('submitmorepassenger')){
			// passenger data
			$insertPassenger['pass_fname'] = $this->input->post('fname');
			$insertPassenger['pass_lname'] = $this->input->post('lname');
			$insertPassenger['pass_gender'] = $this->input->post('gender');
			$insertPassenger['pass_email'] = $this->input->post('uemail');
			$insertPassenger['pass_phone'] = $this->input->post('phone');
			$insertPassenger['pass_mobilephone'] = $this->input->post('mobilephone');
			$insertPassenger['pass_country'] = $this->input->post('country');
			$insertPassenger['pass_city'] = $this->input->post('city');
			$insertPassenger['pass_address'] = $this->input->post('address');
			$insertPassenger['pass_about'] = $this->input->post('aboutYou');
			$insertPassenger['pass_addby'] = $mainpassID;
			$insertPassenger['pass_status'] = 1;
			$insertPassenger['pass_deleted'] = 0;
			$insertPassenger['pass_password'] = $this->generatePassword();

			$config = array(
				array('field' => 'fname','label' => 'first name','rules' => 'trim|required|max_length[50]'),
				array('field' => 'lname','label' => 'last name','rules' => 'trim|required|max_length[50]'),
				array('field' => 'uemail','label' => 'email','rules' => 'trim|required|valid_email'),
				array('field' => 'phone','label' => 'phone','rules' => 'trim|required'),
				array('field' => 'country','label' => 'country','rules' => 'trim|required'),
				array('field' => 'city','label' => 'city','rules' => 'trim|required'),
				array('field' => 'address','label' => 'address','rules' => 'trim|required'),
			);

			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {
				$error = $this->inputvalidation();
             	if($this->input->post('gender')) $error['gendercheck'] = $this->input->post('gender'); else $error['gendercheck'] = FALSE;
   				if($this->input->post('mobilephone')) $error['mobilephoneinput'] = $this->input->post('mobilephone'); else $error['mobilephoneinput'] = "";
   				if($this->input->post('aboutYou')) $error['aboutYouInput'] = $this->input->post('aboutYou'); else $error['aboutYouInput'] = "";
				$fe_data['packagefinalStep'] = $error;
			}else{
				if(! $this->inputvalidation() && $this->input->post('gender')){
					if(count($fe_data['passengerbooking']) < ($np - 1)){
						$passId = $this->mod_fepackage->insertDataPassenger($insertPassenger);
						$fe_data['passengerbooking'][$passId] = $passId;
						$updatepassengerbooking['pbk_pass_come_with'] = serialize($fe_data['passengerbooking']);
						$sadd = $this->mod_fepackage->updatePassengerBooking($bkID, $mainpassID, $updatepassengerbooking);
						if($sadd){
							redirect('site/redirectBack/pagesucceed/'.$bookingID);
						}
					}else{
						$fe_data['errornp'] = 'You have booking for '.($np - 1).' passengers including you. For add more amount of passenger, please make a <a href="#" data-toggle="modal" data-target=".pkcontactadmin">request to admininistor</a>.';
					}
				}else{
					$error = $this->inputvalidation();
	            	if($this->input->post('gender')) $error['gendercheck'] = $this->input->post('gender'); else $error['gendercheck'] = FALSE;
	            	if($this->input->post('mobilephone')) $error['mobilephoneinput'] = $this->input->post('mobilephone'); else $error['mobilephoneinput'] = "";
	            	if($this->input->post('aboutYou')) $error['aboutYouInput'] = $this->input->post('aboutYou'); else $error['aboutYouInput'] = "";
					$fe_data['packagefinalStep'] = $error;
				}
			} // validation running
		}
		$fe_data['site_setting'] = "pagesucceed";
		$this->load->view('index', $fe_data);
	}

	public function redirectBack($uri1 = false, $uri2 = false){
		redirect('site/'.$uri1.'/'.$uri2);
	}

	public function paynow($bookingID = false){
		$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
		$fe_data['site_setting'] = "paynow";
		$this->load->view('index', $fe_data);
	}
	
	public function pkcontactadmin(){	    	
	    $uri3 = $this->uri->segment(4);
	    if($this->input->post('btnSend')){		
			
		// $adminEmail = MU_Model::getAdminEmail();
		$adminEmail = "lannsolak@gmail.com";
		$this->email->set_mailtype("html"); 
	        $sendFrom = $this->input->post('txtemail');
	        $subject = $this->input->post('txtsubject');
	        $text = $this->input->post('txtmessage');
	        $bkID = $this->input->post('txtbkID');
	        $message = "<p>Booking id: ".$bkID."</p>
	        <p>".$text."</p>";

	        $this->email->clear();
	        $this->email->to($adminEmail);
	        $this->email->from($sendFrom);
	        $this->email->subject($subject);
	        $this->email->message($message);
	        $send = $this->email->send();
	        if($send){
	        	$this->session->set_userdata('sendsuccess', 'true');
	        }else{
	        	$this->session->set_userdata('sendfail', 'false');	        	
	        }
	    }else{
	        	$this->session->set_userdata('nosend', 'false');
	    }
        	redirect('site/pagesucceed/'.$uri3);
	  }
	  
	// Ideal system from Dutch

	// $passenger['pass_fname']
	// $passenger['pass_lname']
	// $passenger['pass_gender']
	// $passenger['pass_email']
	// $passenger['pass_phone']
	// $passenger['pass_mobilephone']
	// $passenger['pass_country']
	// $passenger['pass_city']
	// $passenger['pass_address']
	// $passenger['pass_about']
	// $passenger['pass_password']

	// $booking['bk_total_people']
	// $booking['bk_arrival_date']
	// $booking['bk_return_date']
	// $booking['bk_date']
	// $booking['bk_type']
	// $booking['bk_pay_price']
	// $booking['bk_addmoreservice']

	// public function ideal($booking, $passenger){
	// 	return true;
	// }
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */