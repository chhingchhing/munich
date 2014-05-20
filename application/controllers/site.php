<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MU_Controller {

  public function __construct() {
        parent::__construct();

        $this->load->model(array('mod_index','mod_booking','mod_profilefe','mod_fepackage','mod_fecustomize'));
    }

    /*
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
  private $priceBooking = 0;
  public function morepassenger(){
    $passID = $this->session->userdata('passengerid');
    $bkID = $this->input->post('txtBooking');
    $fe_data['old_gender'] = array('' => '-- Select --', 'F' => 'Female', 'M' => 'Male');
    if ($this->input->post('addmore_profile')) {
      // var_dump($this->input->post()); die();
      $config = array(
              array('field' => 'fname', 'label' => 'First Name','rules' => 'trim|required'),
                          array('field' => 'lname','label' => 'Last Name','rules' => 'trim|required'),
                          array('field' => 'password','label' => 'Password','rules' => 'trim|required'),
                          array('field' => 'email','label' => 'Email','rules' => 'trim|required'),
                          array('field' => 'phone', 'label' => 'Phone Number','rules' => 'trim|required'),
                          array('field' => 'address','label' => 'Address','rules' => 'trim|required'),
                          array('field' => 'company','label' => 'Company','rules' => 'trim|required'),
                          array('field' => 'gender','label' => 'Gener','rules' => 'trim|required'),
                          array('field' => 'txtStatus','label' => 'Status','rules' => 'trim|required'),
      );
      $this->form_validation->set_rules($config);
      if($this->form_validation->run() == FALSE){
      $this->session->set_userdata('create', show_message('Please check your completed form!', 'error'));
      }else{
        $insert['pass_fname'] =   $this->input->post('fname');
        $insert['pass_lname']   =   $this->input->post('lname');
        $insert['pass_addby']   =   $passID;
        $insert['pass_password'] =   $this->input->post('password');
        $insert['pass_email'] =   $this->input->post('email');
        $insert['pass_phone'] =   $this->input->post('phone');
        $insert['pass_mobile'] =   $this->input->post('telephone');
        $insert['pass_address'] =   $this->input->post('address');
        $insert['pass_company'] =   $this->input->post('company');
        $insert['pass_gender'] =   $this->input->post('gender');
        $insert['pass_status'] = $this->input->post('txtStatus');
        $insert['pass_deleted'] = 0;        
          $result = $this->mod_booking->getMorePassenger($insert);
          if($result){
            $accompany = MU_Model::getForiegnTableName("passenger_booking", array('pbk_bk_id' => $bkID, 'pbk_pass_id' => $passID), 'pbk_pass_come_with');
              $accompany = unserialize($accompany);
              $newaccompany = $accompany;
              $newaccompany[$result] = $result;               
              $countaccompany = count($newaccompany)+1;           
              $newaccompany = serialize($newaccompany);
              // price
              $updatePrice = MU_Model::getForiegnTableName("booking", array('bk_id' => $bkID),'bk_pay_price');
              $prices = 0;
              $countprice = $updatePrice * $countaccompany;
              //echo $countprice; die();

              $updatepassengerbooking = $this->mod_booking->updateaccompany($newaccompany, $bkID, $passID);
          if($updatepassengerbooking){
            if(count($newaccompany)){
                 $resultUpdate = $this->mod_booking->updateAccompanyInBooking($countaccompany, $bkID);       
                   }
                   if(count($updatePrice)){
                    $resultPrice = $this->mod_booking->updatePriceAfterBooking($countprice,$bkID);
                   }
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
    $bkID = $this->uri->segment(4);
        $fe_data['eticket_collection'] = $this->mod_index->exportAllEtichet($bkID);
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
  /*
  * public function customize
  * @param $display_page default (false)
  * load template customizes and include customize
  */
        
        /*
  * public function customize
  * @param $display_page default (false)
  * load template customizes and include customize
  */
  public function customizes($display_page = false){
    if($display_page == "customizeTrip"){
      $this->customizeTrip();
      redirect('site/customizes/activities');
    }
    if ($display_page == "activities") {
      if($this->input->post('btnActivity')){
        redirect('site/customizes/accommodation');
      }else{
        $fe_data['recordActivities'] = $this->customizeActivity();
      }
    }
    if ($display_page == "accommodation") {
      if($this->input->post('btnAccommodation')){       
        redirect('site/customizes/transportation');
      }else{
        $fe_data['recordAccommodation'] = $this->customizeAccommodation();
      } 
    }
    if($display_page == "transportation"){
      if($this->input->post('btnTransportation')){
        redirect('site/customizes/extra-service');
      }else{
        $fe_data['recordTransportation'] = $this->customizeTransportation();
      }
    }
    if($display_page == "extra-service"){
      if($this->input->post('btnExtraService')){
        redirect('site/customizes/personal-info');
      }else{
        $fe_data['recordAccommodation'] = $this->customizeExtra_service();
      }
    }
    if ($display_page == "personal-info") {
      if($this->input->post('btnExtraService')){  
        $addpassenger  = array(
          array('field' => 'pfname','label' => 'Passenger firstname','rules' => 'trim|required'),
          array('field' => 'plname','label' => 'Passenger lastname','rules' => 'trim|required'), 
          );  
        $this->form_validation->set_rules($addpassenger);
        if($this->form_validation->run() == FALSE){
           echo "sorry you are wrong.";
        }else{  
          $pnumber =  $this->input->post('pnumber');
          $pfname = $this->input->post('pfname');
          $plname = $this->input->post('plname');
          $pemail =  $this->input->post('pemail');
          $phphone =  $this->input->post('phphone');
          $paddress =  $this->input->post('paddress');
          $pcompany =  $this->input->post('pcompany');
          $ppassword =  $this->input->post('ppassword');
          $pgender =  $this->input->post('pgender');
          $this->mod_fecustomize->personal_information($pnumber, $pfname, $plname, $pemail, $phphone, $paddress, $pcompany, $ppassword, $pgender);        
          redirect('site/customizes/payments');         
        }

      }else{
        $fe_data['recordActivities'] = $this->customizePersonal_info();
      }
    }
    $fe_data['menu_fe'] = $this->mod_index->getAllMenu();
    $fe_data['site_setting'] = "customizes";
    // if($display_page != false){
    //  $fe_data['customize_page_show'] = $display_page;
    // }
    $this->load->view('index', $fe_data);
  }
  /*
  * public function customize trip information
  * @param 
  * load template customize booking and include all step of customize booking
  */
  public function customizeTrip(){
    if($this->input->post('btnTripInfo')){
      if($this->input->post('people')){$this->session->set_userdata('people', $this->input->post('people'));}else{$this->session->set_userdata('people', "");}
      if($this->input->post('txtFrom')){$this->session->set_userdata('txtFrom', $this->input->post('txtFrom'));}else{$this->session->set_userdata('txtFrom', "");}
      if($this->input->post('txtTo')){$this->session->set_userdata('txtTo', $this->input->post('txtTo'));}else{$this->session->set_userdata('txtTo', "");}  
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
    // select join with table photo, location, festival, by session and where lcID and ftvID
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
  public function selectSubActivity($sub_act){
    if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
    // select join with table photo, location, festival, by session and where lcID and ftvID
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
    return $data;
  }
  }
  /*select sub accommodation */
  public function selectSubAccommodation($sub_acc){
    if($this->session->userdata('txtFrom') AND $this->session->userdata('txtTo')) $findate = array($this->session->userdata('txtFrom'), $this->session->userdata('txtTo'));
    $subAccommodation = mod_fecustomize::selectSubAccommodation($this->session->userdata('ftvID'), $this->session->userdata('lcID'), $acc_record['acc_id']);
    $subAccommodation = array();
    if ($subAccommodation->num_rows() > 0) {
      foreach ($subAccommodation->result() as $subacc) {
        $recodeavaliable = site::convertDateToRangeSub($findate, $subtp->start_date, $subtp->end_date); 
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
    // select join with table photo, location, festival, by session and where lcID and ftvID
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

  public function customizeExtra_service(){
   }
  public function customizePersonal_info(){ }
  
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
    }elseif($display_page == "infostep"){
      $fe_data["packagefinalStep"] = $this->showFinalStep();
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
    $allpackages = $this->mod_fepackage->getallpackages($ftv, $lc);
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
      if($epschecked == false){
        redirect('site/packages/infostep/');
      } else {
        $this->session->set_userdata('extraservice', $epschecked);
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
        array('field' => 'numPassenger','label' => 'number of passenger','rules' => 'trim|required|integer|max_length[2]'),
        array('field' => 'dpDate','label' => 'departure date','rules' => 'trim|required'),
        array('field' => 'rtDate','label' => 'return date','rules' => 'trim|required'),
        array('field' => 'fname','label' => 'first name','rules' => 'trim|required|max_length[50]'),
        array('field' => 'lname','label' => 'last name','rules' => 'trim|required|max_length[50]'),
        array('field' => 'uemail','label' => 'email','rules' => 'trim|required|valid_email'),
        array('field' => 'phone','label' => 'phone','rules' => 'trim|required'),
        array('field' => 'country','label' => 'country','rules' => 'trim|required'),
        array('field' => 'city','label' => 'city','rules' => 'trim|required'),
        array('field' => 'address','label' => 'address','rules' => 'trim|required'),
      );

      // booking data
      $insertBooking['bk_total_people'] = $this->input->post('numPassenger');
      $insertBooking['bk_arrival_date'] = $this->input->post('dpDate');
      $insertBooking['bk_return_date'] = $this->input->post('rtDate');
      $dateformat = "%Y-%m-%d";
      $insertBooking['bk_date'] = mdate($dateformat,now());
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
                  foreach($addservice as $services){
                    $extrapro = $this->mod_fepackage->getExtraProductById($services);
                    $extrapro = json_decode(json_encode($extrapro->result()), true);
                    $insertBooking['bk_pay_price'] += $extrapro[0]['ep_saleprice'];
                    $insertBooking['bk_addmoreservice'][$services] = $extrapro[0];
                  }
                }
                if($insertBooking['bk_addmoreservice'] != NULL) $insertBooking['bk_addmoreservice'] = serialize($insertBooking['bk_addmoreservice']);
                $insertBooking['bk_pay_price'] = $insertBooking['bk_pay_price']*$insertBooking['bk_total_people'];

                $bookingId = $this->mod_fepackage->insertDataBooking($insertBooking);
                if($bookingId){
                  $this->session->set_userdata('bookingid', $bookingId);
                  $insertPassenger['pass_password'] = $this->generatePassword();
                  $passId = $this->mod_fepackage->insertDataPassenger($insertPassenger);
                  if($passId){
                    $this->session->set_userdata('passengerid', $passId);
                    $pbID = $this->mod_fepackage->insertPassengerBooking($passId, $bookingId);
                    if($pbID){
                      $this->sendemail($insertBooking, $insertPassenger);
                      if($payby == 'paypal'){
                        $this->paypal($insertBooking, $insertPassenger, $bookingId);
                      }elseif($payby == 'ideal'){
                        $this->ideal($insertBooking, $insertPassenger);
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
  * Function generate password
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
  public function paypal($booking, $passenger, $bookingId){
    $key = 'NLOPSYSMB'.$bookingId;
    $bk_id = base64url_encode($key);
    $parameters = array(
      'cmd' => '_xclick',
      'business' => 'john@nl.nl',
      'amount' => $booking['bk_pay_price'],
      'item_name' => 'MB'.$bookingId,
      'currency_code' => 'USD',
      'return' => 'http://masterbooking.codingate.com/nl/site/ipn_listener',
      'cancel_return' => 'http://masterbooking.codingate.com/nl/site/payCancel/'.$bk_id,
      'notify_url' => 'http://masterbooking.codingate.com/nl/site/ipn_listener'
    );
    $url = $this->urlparameter($parameters);    
    header("Location: ". $url);
  }
  public function urlparameter($parameters){
    parse_str($_SERVER['QUERY_STRING'], $old_parameters_as_array);
      return "https://www.sandbox.paypal.com/cgi-bin/webscr".'?'.http_build_query(array_merge($old_parameters_as_array, $parameters));
  }

  // identify the pay IPN
  function ipn_listener(){
  // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
    // Instead, read raw POST data from the input stream. 
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
      $keyval = explode ('=', $keyval);
      if (count($keyval) == 2)
         $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
       $get_magic_quotes_exists = true;
    } 
    foreach ($myPost as $key => $value) {        
       if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
            $value = urlencode(stripslashes($value)); 
       } else {
            $value = urlencode($value);
       }
       $req .= "&$key=$value";
    }
    var_dump($req); die();
     
    // POST IPN data back to PayPal to validate
    
    $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    
    // In wamp-like environments that do not come bundled with root authority certificates,
    // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
    // the directory path of the certificate as shown below:
    // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
    
    if( !($res = curl_exec($ch)) ) {
        // error_log("Got " . curl_error($ch) . " when processing IPN data");
        echo "exist Here curl_curl_exec";
        curl_close($ch);
        exit;
    }
    curl_close($ch);
     
    // Inspect IPN validation result and act accordingly
    
    if (strcmp ($res, "VERIFIED") == 0) {
        // The IPN is verified, process it:
        // check whether the payment_status is Completed
        // check that txn_id has not been previously processed
        // check that receiver_email is your Primary PayPal email
        // check that payment_amount/payment_currency are correct
        // process the notification
      
        // assign posted variables to local variables
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];
        $pay_date = $_POST['payment_date'];
        
        // IPN message values depend upon the type of notification sent.
        // Update table booking about payment_status(1 == "Completed", 2 = "Panding", 3 = "Failed", 4 = "Unclaimed") and pay_id (txn_id)
        
        if($item_name){
          $idBooking = explode("B", $item_name);
          if(count($idBooking) > 0){
            $this->mod_fepackage->updateBookingPackage($idBooking[1], $payment_status,$txn_id, $pay_date);
            $this->mod_fepackage->updatePackage($idBooking[1]);
          }
        }

        $key = 'NLOPSYS'.$item_name;
        $bk_id = base64url_encode($key);
        redirect("site/paysucceed/".$bk_id, "location");
    } else if (strcmp ($res, "INVALID") == 0) {
        // IPN invalid, log for manual investigation
        echo "The response from IPN was: <b>" .$res ."</b>";
    }
  
  }
  public function paysucceed($bkID = false){
    $key = "NLOPSYSMB";
    $bookingID = $bkID;
    $bkID = base64url_decode($bkID, $key);
    $fe_data['menu_fe'] = $this->mod_index->getAllMenu();
    $fe_data['getbooking'] = MU_Model::getRecordById('booking',array('bk_id'=>$bkID));
    $passbooking = MU_Model::getForiegnTableName('passenger_booking', array('pbk_bk_id'=>$bkID), 'pbk_pass_come_with');
    if($passbooking){     
      $fe_data['passengerbooking'] = unserialize($passbooking);
      $fe_data['passengerbookingrecord'] = $this->mod_fepackage->getPassengerBooking($fe_data['passengerbooking']);
    }else{
      $fe_data['passengerbooking'] = array();
    }

    $mainpassID = MU_Model::getForiegnTableName('passenger_booking', array('pbk_bk_id'=>$bkID), 'pbk_pass_id');
    $np = MU_Model::getForiegnTableName('booking', array('bk_id'=>$bkID), 'bk_total_people');
    $fe_data['packagefinalStep'] = array();
    $fe_data['packagefinalStep']['mobilephoneinput'] = '';
    $fe_data['packagefinalStep']['aboutYouInput'] = '';
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
              redirect('site/redirectBack/paysucceed/'.$bookingID);
            }
          }
        }else{
          $error = $this->inputvalidation();
                if($this->input->post('gender')) $error['gendercheck'] = $this->input->post('gender'); else $error['gendercheck'] = FALSE;
                if($this->input->post('mobilephone')) $error['mobilephoneinput'] = $this->input->post('mobilephone'); else $error['mobilephoneinput'] = "";
                if($this->input->post('aboutYou')) $error['aboutYouInput'] = $this->input->post('aboutYou'); else $error['aboutYouInput'] = "";
          $fe_data['packagefinalStep'] = $error;
        }
      }
    }
    $fe_data['site_setting'] = "paysucceed";
    $this->load->view('index', $fe_data);
  }
  public function redirectBack($uri1 = false, $uri2 = false){
    redirect('site/'.$uri1.'/'.$uri2);
  }

  // Ideal system from netderland

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

  public function ideal($booking, $passenger){
    return true;
  }
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */