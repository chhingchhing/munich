<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends MU_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_booking','mod_index','mod_package'));
    }
	// // show of fettival
	//  public function booking(){
	//  	$fe_data['title'] = "festival";
	// 	$fe_data['booking'] = "Default Font End";
	// 	$fe_data['show_festival'] = $this->mod_booking->getFestival();
	// 	$this->load->view('index', $fe_data);
	// }
	
	// // edit booking
	// public function detail(){
	// 	$fe_data['menu_fe'] = $this->mod_index->getAllMenu();
	// 	$fe_data['title'] = "detail";
	// 	$fe_data['booking'] = "Default Font End";
	// 	$fe_data['detail'] = $this->
	// 	$this->load->view('index', $fe_data);
	// }	

	public function list_record(){
		$data['title'] = "Booking Management";
		$data['dashboard'] = "management";
		$controller = $this->uri->segment(1);
        $function = $this->uri->segment(2);
        $data['option_ftvstatus'] = array('0' => 'Unpublished','1' => 'Published');
        if($this->uri->segment(3) != "" AND !is_numeric($this->uri->segment(3))){
            $uri3 = $this->uri->segment(3);
            $uri4 = $this->uri->segment(4);
            $config['base_url'] = site_url($controller . "/" . $function."/".$uri3."/".$uri4);
            $config['uri_segment'] = 5;
            $sortby = $uri3;
            if($uri4 == 'ASC'){
                $data['sort'] = "DESC";
            }elseif($uri4 == "DESC"){
                $data['sort'] = "ASC";
            }

        }else{
            $sortby = "ID";
            $data['sort'] = "DESC";
            $config['base_url'] = site_url($controller . "/" . $function);
            $config['uri_segment'] = 3;
        }

        $config['total_rows'] = MU_Model::count_all_data('booking', array('bk_deleted' => 0));
        $config['per_page'] = 10;

        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;&gt;';
        $config['prev_link'] = '&lt;&lt;';
        $this->pagination->initialize($config); //function to show all pages
        $page = ($this->uri->segment($config['uri_segment']) && $this->uri->segment($config['uri_segment']) > 0) ? $this->uri->segment($config['uri_segment']) : 0;

		$data['getbooking'] = $this->mod_booking->getAllsalePackage($config['per_page'], $page, $sortby, $data['sort']);
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('munich_admin', $data);
	}
    
    // search booking ID
    public function search_booking(){
        $data['title'] = "Booking Management";
        $data['dashboard'] = "management";
        $controller = $this->uri->segment(1);
        $function = $this->uri->segment(2);
        if($this->input->post('search_bookingID')) $this->session->set_userdata('searchBooking', $this->input->post('search_bookingID'));
        $data['option_ftvstatus'] = array('0' => 'Unpublished','1' => 'Published');
        if($this->uri->segment(3) != "" AND !is_numeric($this->uri->segment(3))){
            $uri3 = $this->uri->segment(3);
            $uri4 = $this->uri->segment(4);
            $config['base_url'] = site_url($controller . "/" . $function."/".$uri3."/".$uri4);
            $config['uri_segment'] = 5;
            $sortby = $uri3;
            if($uri4 == 'ASC'){
                $data['sort'] = "DESC";
            }elseif($uri4 == "DESC"){
                $data['sort'] = "ASC";
            }

        }else{
            $sortby = "ID";
            $data['sort'] = "DESC";
            $config['base_url'] = site_url($controller . "/" . $function);
            $config['uri_segment'] = 3;
        }

        $config['total_rows'] = MU_Model::count_all_data('booking', array('bk_deleted' => 0), array('bk_id'=> $this->session->userdata('searchBooking')));
        $config['per_page'] = 10;

        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;&gt;';
        $config['prev_link'] = '&lt;&lt;';
        $this->pagination->initialize($config); //function to show all pages
        $page = ($this->uri->segment($config['uri_segment']) && $this->uri->segment($config['uri_segment']) > 0) ? $this->uri->segment($config['uri_segment']) : 0;

        $data['getbooking'] = $this->mod_booking->getAllSearchsalePackage($this->session->userdata('searchBooking'),$config['per_page'], $page, $sortby, $data['sort']);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('munich_admin', $data);
    }


    /*
    * pulic function add_booking
    * @noparam  
    * return boolean
    * redirect to the view page
    */
    public function add_booking(){
        $data['title'] = "Booking Management";
        $data['dashboard'] = "management";
        $data['passenger'] = $this->mod_booking->getPassenger();        
        $data['getpk'] = $this->mod_booking->getAllPackage();
        $data['getcus'] = $this->mod_booking->getAllCustomize();
        if($this->input->post('btnbookingsubmit')){
            $insertbooking['bk_type'] = $this->input->post('bkType');
            $insertbooking['bk_date'] = $this->input->post('bkDate');
            $insertbooking['bk_arrival_date'] = $this->input->post('bkArrivalDate');
            // $insertbooking['bk_return_date'] = $this->input->post('bkReturnDate');
            $insertbooking['bk_total_people'] = $this->input->post('bkTotalPeople');
            $insertbooking['bk_pay_date'] = $this->input->post('bkPayDate');
            $insertbooking['bk_pay_price'] = $this->input->post('bkPrice');
            $insertbooking['bk_balance'] = $this->input->post('bkbalance');
            $insertbooking['bk_deposit'] = $this->input->post('bkdeposit');
            $insertbooking['bk_pay_status'] = $this->input->post('bkPaystatus');
            // $insertbooking['bk_status'] = $this->input->post('bkstatus');            
            $insertpassenger['passID'] = $this->input->post('bkpass');
            $bookingpackage = $this->input->post('pkORcus');

            $config = $this->booking_config();
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('create', show_message('<p class="error">'.'Please complete the field required...'.'</p>', 'error'));
            }else{
                if($this->is_money($insertbooking['bk_pay_price'])){
                    $result_booking = $this->mod_booking->insertBooking($insertbooking);
                    if($result_booking){
                        $this->mod_booking->insertpassbooking($insertpassenger['passID'], $result_booking);
                        if($insertbooking['bk_type'] == 'package'){
                            $this->mod_booking->insertsalepackage($bookingpackage, $result_booking);
                            $pkStock = MU_Model::getForiegnTableName('package_conjection',array('pkcon_id'=> $bookingpackage), 'pkcon_actualstock');
                            if($pkStock > 0){
                                $pkStock = $pkStock - 1;
                                MU_Model::updateStockAll('package_conjection',array('pkcon_id'=> $bookingpackage),array('pkcon_actualstock'=> $pkStock));
                            }
                        }else{
                            $this->mod_booking->insertsalecustomize($bookingpackage, $result_booking);
                        }
                        $this->session->set_userdata('create', show_message('<p>'.'Booking was added successfully ...'.'</p>', 'success'));
                        redirect('booking/view_booking_'.$insertbooking['bk_type'].'/'.$result_booking.'/'.$insertbooking['bk_type']);
                        break;
                    }                    
                }
            }
        }
        $this->load->view('munich_admin', $data);
    }

    /*
    * pulic function view_booking
    * @param   
    * noreturn
    * redirect to the view page
    */
// 24th June 2014
    // private $priceBooking = 0;
    public function view_booking_package($bkID, $bkType){
        $data['title'] = "Booking Management";
        $data['dashboard'] = "management";
        $data['passenger'] = $this->mod_booking->getPassenger();
        $data['bookingedit'] = $this->mod_booking->getBookingEditPackage($bkID);
        $data['getpkORcus'] = $this->mod_booking->getAllPackage();
        // $data['extraService'] = $this->mod_booking->getAllExtraService();
        if($this->input->post('btnviewsubmit')){
            $updatebooking['bk_type'] = $this->input->post('bkType');
            $updatebooking['bk_date'] = $this->input->post('bkDate');
            $updatebooking['bk_arrival_date'] = $this->input->post('bkArrivalDate');
            // $updatebooking['bk_return_date'] = $this->input->post('bkReturnDate');
            $updatebooking['bk_pay_date'] = $this->input->post('bkPayDate');
            $updatebooking['bk_balance'] = $this->input->post('bkbalance');
            $updatebooking['bk_deposit'] = $this->input->post('bkdeposit');
            $updatebooking['bk_pay_status'] = $this->input->post('bkPaystatus');
            // $updatebooking['bk_status'] = $this->input->post('bkstatus');
            $bookingpassid['passID'] = $this->input->post('bkpass');
            $bookingpackage = $this->input->post('pkORcus');
            $pkIdold = $this->input->post('pkold');
            $extraservicecheckbox = $this->input->post('epacc_checkbox');
            $passengercheckbox = $this->input->post('pass_checkbox');

            $config = $this->booking_config();
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('create', show_message('<p class="error">'.'Please complete the field required...'.'</p>', 'error'));
            }else{
                $oldextraservice = $this->input->post('oldextraservice');
                $this->saveChangePassengers($passengercheckbox, $bkID, $bookingpassid['passID']);
                $servicePrice = $this->saveChangeExtraservices($bkID, $extraservicecheckbox, $oldextraservice);
                $cuspkPrice = $this->input->post('pkconprice'); 

                ///// Calculate price /////               
                // $actprice = $this->calculateactivities($bookingpackage);
                // $accprice = $this->calculateaccommodation($bookingpackage, $updatebooking['bk_arrival_date'], $updatebooking['bk_return_date']);
                // $tspprice = $this->calculatetransportation($bookingpackage);
                
                $updatebooking['bk_total_people'] = $this->input->post('bkTotalPeople');
                $aop = count($passengercheckbox) + 1;

                if($updatebooking['bk_total_people'] >= $aop){
                   $updatebooking['bk_pay_price'] = $servicePrice + ($cuspkPrice * $updatebooking['bk_total_people']); 
                }else{
                   $updatebooking['bk_pay_price'] = $servicePrice + ($cuspkPrice * $aop); 
                   $updatebooking['bk_total_people'] = $aop;
                }

                if(isset($updatebooking['bk_pay_price']) && $this->is_money($updatebooking['bk_pay_price'])){
                    $result_booking = $this->mod_booking->updateBooking($updatebooking, $bkID);
                    if($result_booking){
                        $this->session->set_userdata('create', show_message('<p>'.'Booking was updated successfully ...'.'</p>', 'success'));
                        // update stock package
                        // $pkStock = MU_Model::getForiegnTableName('package_conjection',array('pkcon_id'=> $bookingpackage), 'pkcon_actualstock');
                        // $pkOldStock = MU_Model::getForiegnTableName('package_conjection',array('pkcon_id'=> $pkIdold), 'pkcon_actualstock');
                        $laststock = MU_Model::getForiegnTableName('sale_packages',array('salepk_bk_id'=> $bkID), 'last_stockupdate');
                        // if($pkStock > 0){
                            if($pkIdold != $bookingpackage){
                                if($updatebooking['bk_deposit'] != '' and $updatebooking['bk_deposit'] != 0 and $updatebooking['bk_deposit'] != '0'){
                                    $this->updateStockFromBooking($bookingpackage, $pkIdold,  (int) $laststock, $updatebooking['bk_total_people']);
                                }
                                // $pkStock = $pkStock - 1;
                                // $pkOldStock = $pkOldStock + 1;
                                // MU_Model::updateStockAll('package_conjection',array('pkcon_id'=> $bookingpackage),array('pkcon_actualstock'=> $pkStock));
                                // MU_Model::updateStockAll('package_conjection',array('pkcon_id'=> $pkIdold),array('pkcon_actualstock'=> $pkOldStock));
                            }
                        // }

                        $this->mod_booking->updatepassbooking($bookingpassid['passID'], $bkID);
                        $this->mod_booking->updatesalepackage($bookingpackage, $bkID);

                        // redirect('booking/list_record');
                        redirect('booking/view_booking_'.$updatebooking['bk_type'].'/'.$bkID.'/'.$updatebooking['bk_type']);
                        break;
                    }
                }
            }
        }
        $this->load->view('munich_admin', $data);
    }

    // update stock from booking package stock
    public function updateStockFromBooking($pkID, $pkOldID, $laststock, $newstock) {

        $packageold = MU_Model::getRecordById('package_conjection', array('pkcon_id'=> $pkOldID));
        $packagecurrent = MU_Model::getRecordById('package_conjection', array('pkcon_id'=> $pkID));

        foreach($packageold->result() as $oldpk){

            $oldstock = $oldpk->pkcon_actualstock;
            $oldstock = $oldstock + $laststock;
            MU_Model::updateStockAll('package_conjection',array('pkcon_id'=> $pkOldID),array('pkcon_actualstock'=> $oldstock));
            $this->updateStockInsidePackage('old',unserialize($oldpk->pk_activities), unserialize($oldpk->pk_accomodation), unserialize($oldpk->pk_transportation), $laststock);
        }

        foreach($packagecurrent->result() as $currpk){

            $currstock = $currpk->pkcon_actualstock;
            $currstock = $currstock + $laststock;
            MU_Model::updateStockAll('package_conjection',array('pkcon_id'=> $pkID),array('pkcon_actualstock'=> $currstock));
            $this->updateStockInsidePackage('new',unserialize($currpk->pk_activities), unserialize($currpk->pk_accomodation), unserialize($currpk->pk_transportation), $newstock);
        
        }

    }
    // using to udate the stock of activities, transportation, accommodation.
    public function updateStockInsidePackage($currentlyis, $activities = array(), $accommodation = array(), $transportation = array(), $stock){

        // update stock of activities from booking
        if($activities !== false){
            if(isset($activities['main-activities'])){
                foreach($activities['main-activities'] as $val){
                    
                    $mainactstock = MU_Model::getForiegnTableName('activities',array('act_id'=> $val['act_id']), 'act_actualstock');
                    if($currentlyis == 'new'){ $mainactstock = $mainactstock - $stock;
                    }elseif($currentlyis == 'old'){ $mainactstock = $mainactstock + $stock;}
                    MU_Model::updateStockAll('activities',array('act_id'=> $val['act_id']),array('act_actualstock'=> $mainactstock));

                    if(isset($activities['sub-activities'][$val['act_id']])){
                        foreach($activities['sub-activities'][$val['act_id']] as $subval){
                           
                           $subactstock = MU_Model::getForiegnTableName('activities',array('act_id'=> $subval['act_id']), 'act_actualstock');
                           if($currentlyis == 'new'){ $subactstock = $subactstock - $stock;
                           }elseif($currentlyis == 'old'){ $subactstock = $subactstock + $stock;}
                           MU_Model::updateStockAll('activities',array('act_id'=> $subval['act_id']),array('act_actualstock'=> $subactstock));
                        
                        }
                    }

                    if(isset($activities['extraproduct-pk'][$val['act_id']])){
                        foreach($activities['extraproduct-pk'][$val['act_id']] as $epval){
                            
                            $epactstock = MU_Model::getForiegnTableName('extraproduct',array('ep_id'=> $epval['ep_id']), 'ep_actualstock');
                            if($currentlyis == 'new'){ $epactstock = $epactstock - $stock;
                            }elseif($currentlyis == 'old'){ $epactstock = $epactstock + $stock;}
                            MU_Model::updateStockAll('extraproduct',array('ep_id'=> $epval['ep_id']),array('ep_actualstock'=> $epactstock));
                            
                        }
                    }
                }
            }
        }

        // update stock of accommodation from booking
        if($accommodation !== false){
            if(isset($accommodation['main-accommodation'])){
                foreach($accommodation['main-accommodation'] as $val){
                    
                    $mainaccstock = MU_Model::getForiegnTableName('accommodation',array('acc_id'=> $val['acc_id']), 'acc_actualstock');
                    if($currentlyis == 'new'){ $mainaccstock = $mainaccstock - $stock;
                    }elseif($currentlyis == 'old'){ $mainaccstock = $mainaccstock + $stock;}
                    MU_Model::updateStockAll('accommodation',array('acc_id'=> $val['acc_id']),array('acc_actualstock'=> $mainaccstock));

                    if(isset($accommodation['sub-accommodation'][$val['acc_id']])){
                        foreach($accommodation['sub-accommodation'][$val['acc_id']] as $subval){
                           
                           $subaccstock = MU_Model::getForiegnTableName('accommodation',array('acc_id'=> $subval['acc_id']), 'acc_actualstock');
                           if($currentlyis == 'new'){ $subaccstock = $subaccstock - $stock;
                           }elseif($currentlyis == 'old'){ $subaccstock = $subaccstock + $stock;}
                           MU_Model::updateStockAll('accommodation',array('acc_id'=> $subval['acc_id']),array('acc_actualstock'=> $subaccstock));
                        
                        }
                    }

                    if(isset($accommodation['extraproduct-pk'][$val['acc_id']])){
                        foreach($accommodation['extraproduct-pk'][$val['acc_id']] as $epval){
                            
                            $epactstock = MU_Model::getForiegnTableName('extraproduct',array('ep_id'=> $epval['ep_id']), 'ep_actualstock');
                            if($currentlyis == 'new'){ $epactstock = $epactstock - $stock;
                            }elseif($currentlyis == 'old'){ $epactstock = $epactstock + $stock;}
                            MU_Model::updateStockAll('extraproduct',array('ep_id'=> $epval['ep_id']),array('ep_actualstock'=> $epactstock));
                            
                        }
                    }
                }
            }
        }

        // update stock of transportation from booking
        if($transportation !== false){
            if(isset($transportation['main-transport'])){
                foreach($transportation['main-transport'] as $val){
                    
                    $maintpstock = MU_Model::getForiegnTableName('transportation',array('tp_id'=> $val['tp_id']), 'tp_actualstock');
                    if($currentlyis == 'new'){ $maintpstock = $maintpstock - $stock;
                    }elseif($currentlyis == 'old'){ $maintpstock = $maintpstock + $stock;}
                    MU_Model::updateStockAll('transportation',array('tp_id'=> $val['tp_id']),array('tp_actualstock'=> $maintpstock));

                    if(isset($transportation['sub-transport'][$val['tp_id']])){
                        foreach($transportation['sub-transport'][$val['tp_id']] as $subval){
                           
                           $subtpstock = MU_Model::getForiegnTableName('transportation',array('tp_id'=> $subval['tp_id']), 'tp_actualstock');
                           if($currentlyis == 'new'){ $subtpstock = $subtpstock - $stock;
                           }elseif($currentlyis == 'old'){ $subtpstock = $subtpstock + $stock;}
                           MU_Model::updateStockAll('transportation',array('tp_id'=> $subval['tp_id']),array('tp_actualstock'=> $subtpstock));
                        
                        }
                    }

                    if(isset($transportation['extraproduct-pk'][$val['tp_id']])){
                        foreach($transportation['extraproduct-pk'][$val['tp_id']] as $epval){
                            
                            $epactstock = MU_Model::getForiegnTableName('extraproduct',array('ep_id'=> $epval['ep_id']), 'ep_actualstock');
                            if($currentlyis == 'new'){ $epactstock = $epactstock - $stock;
                            }elseif($currentlyis == 'old'){ $epactstock = $epactstock + $stock;}
                            MU_Model::updateStockAll('extraproduct',array('ep_id'=> $epval['ep_id']),array('ep_actualstock'=> $epactstock));
                            
                        }
                    }
                }
            }
        }

    } // end of function update stock in side package

    public function calculateactivities($pkID){

        $selectAct = $this->mod_package->getActivitiesPackage($pkID);     
        $activities = array();
        if($selectAct->num_rows() > 0){
            foreach($selectAct->result() as $sltAct){                
                $activities = unserialize($sltAct->pk_activities);
            }
        }

        $mainpriceact = 0;
        $mainpricesubact = 0;
        $mainpriceexp = 0;
        if($activities !== false){
            if(isset($activities['main-activities'])){
                foreach($activities['main-activities'] as $val){
                    $mainpriceact += $val['act_saleprice'];
                
                    if(isset($activities['sub-activities'][$val['act_id']])){
                        foreach($activities['sub-activities'][$val['act_id']] as $subval){
                           $mainpricesubact += $subval['act_saleprice'];
                        }
                    }

                    if(isset($activities['extraproduct-pk'][$val['act_id']])){
                        foreach($activities['extraproduct-pk'][$val['act_id']] as $epval){
                            $mainpriceexp += $epval['ep_saleprice'];
                        }
                    }
                }
            }
        }

        $finalprice  = $mainpriceact + $mainpricesubact + $mainpriceexp;

        return $finalprice;

    }

    public function calculateaccommodation($pkID, $arrival, $return){

        $selectAcc = $this->mod_package->getAccommodationPackage($pkID);        
        $accommodations = array();
        if($selectAcc->num_rows() > 0){
            foreach($selectAcc->result() as $sltAcc){                
                $accommodations = unserialize($sltAcc->pk_accomodation);
            }
        }

        $mainpriceacc = 0;
        $mainpricesubacc = 0;
        $mainpriceexp = 0;
        if($accommodations !== false){
            if(isset($accommodations['main-accommodation'])){
                foreach($accommodations['main-accommodation'] as $val){
                    $mainpriceacc += $val['acc_saleprice'];
                
                    if(isset($accommodations['sub-accommodation'][$val['acc_id']])){
                        foreach($accommodations['sub-accommodation'][$val['acc_id']] as $subval){
                           $mainpricesubacc += $subval['acc_saleprice'];
                        }
                    }

                    if(isset($accommodations['extraproduct-pk'][$val['acc_id']])){
                        foreach($accommodations['extraproduct-pk'][$val['acc_id']] as $epval){
                            $mainpriceexp += $epval['ep_saleprice'];
                        }
                    }
                }
            }
        }
        $days = date_diff(date_create($arrival), date_create($return));
        $days = $days->format("%a");

        $mainpriceacc  = $mainpriceacc * $days;
        $sub_n_ep = $mainpricesubacc + $mainpriceexp;

        $finalval = array($mainpriceacc, $sub_n_ep);

        return $finalval;

    }

    public function calculatetransportation($pkID){

        $selectTps = $this->mod_package->getTransportPackage($pkID); 
        $transportation = array();
        if($selectTps->num_rows() > 0){
            foreach($selectTps->result() as $sltTps){                
                $transportation = unserialize($sltTps->pk_transportation);
            }
        }

        $mainpricetsp = 0;
        $mainpricesubtsp = 0;
        $mainpriceexp = 0;
        if($transportation !== false){
            if(isset($transportation['main-transport'])){
                foreach($transportation['main-transport'] as $val){
                    $mainpricetsp += $val['tp_saleprice'];
                
                    if(isset($transportation['sub-transport'][$val['tp_id']])){
                        foreach($transportation['sub-transport'][$val['tp_id']] as $subval){
                           $mainpricesubtsp += $subval['tp_saleprice'];
                        }
                    }

                    if(isset($transportation['extraproduct-pk'][$val['tp_id']])){
                        foreach($transportation['extraproduct-pk'][$val['tp_id']] as $epval){
                            $mainpriceexp += $epval['ep_saleprice'];
                        }
                    }
                }
            }
        }

        $finalprice  = $mainpricetsp + $mainpricesubtsp + $mainpriceexp;

        return $finalprice;

    }

    /*
    * public function booking_config
    * @noparam
    * return config (array)
    */
    // 24th June 2014
    public function booking_config(){
        $config = array(
            array('field' => 'bkDate','label' => 'booking date','rules' => 'trim|required'),
            array('field' => 'bkArrivalDate','label' => 'arrival date', 'rules' => 'trim|required'),
            // array('field' => 'bkReturnDate','label' => 'return date', 'rules' => 'trim|required'),
            array('field' => 'bkTotalPeople','label' => 'total people','rules' => 'trim|required|numeric'),
            array('field' => 'bkPrice','label' => 'price', 'rules' => 'trim|required'),
            array('field' => 'bkPayDate','label' => 'pay date','rules' => 'trim|required'),
            array('field' => 'bkType','label' => 'booking type','rules' => 'trim|required'),
            array('field' => 'bkPaystatus','label' => 'pay status','rules' => 'trim|required'),
            array('field' => 'bkpass','label' => 'passenger','rules' => 'trim|required'),
            array('field' => 'pkORcus','label' => 'Package','rules' => 'trim|required'),
            array('field' => 'bkbalance','label' => 'balance','rules' => 'trim|required'),
            array('field' => 'bkdeposit','label' => 'deposit','rules' => 'trim|required'),
        );
        return $config;
    }

	/*
    * pulic function deleteById
    * @param $bk_id (int) 
    * return boolean
    * redirect to the current page
    */
    public function deleteBookingById($bk_id, $pagione = false, $pagitwo = false,$pagithree = false){
        $deleted = MU_Model::deleteRecordById('booking', array("bk_deleted" => 1), array('bk_id' => $bk_id));
        $total_rows = MU_Model::count_all_data('booking', array('bk_deleted' => 0));
        $pagi = "";
        if($this->session->userdata('searchBooking')){ $function = "search_booking"; }else{ $function = "list_record"; }
        if($total_rows > 10){ 
            if($pagione != false) $pagi = $pagione;
            if($pagitwo != false) $pagi .= "/".$pagitwo;
            if($pagithree != false) $pagi .= "/".$pagithree;

           $redirect = "booking/".$function."/".$pagi; 
        }else{ 
            $redirect = "booking/".$function; 
        }

        if($deleted){
            $this->session->set_userdata('create', show_message('The booking have been deleted successfully.', 'success'));
            redirect($redirect);
        }else{
            $this->session->set_userdata('create', show_message('Cannot delete record on table name booking.', 'error'));
            redirect($redirect);
        }
    }

	/*
    * pulic function status_booking
    * @param $bk_status (int)
    * @param $bk_id (int)  
    * @noreturn
    * redirect to the current page
    */
    public function status_booking($bk_status, $bk_id, $pagione = false, $pagitwo = false, $pagithree = false){
        $total_rows = MU_Model::count_all_data('booking', array('bk_deleted' => 0));
        $bk_status = ($bk_status == 1) ? 0 : 1;
        $statuschaged = MU_Model::updateStatusById('booking', array("bk_status" => $bk_status), array('bk_id' => $bk_id));
        $pagi = "";
        if($this->session->userdata('searchBooking')){ $function = "search_booking"; }else{ $function = "list_record"; }
        if($total_rows > 3){ 
            if($pagione != false) $pagi = $pagione;
            if($pagitwo != false) $pagi .= "/".$pagitwo;
            if($pagithree != false) $pagi .= "/".$pagithree;

           $redirect = "booking/".$function."/".$pagi; 
        }else{ 
            $redirect = "booking/".$function; 
        }

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
    * public function is_money
    * @param $price
    * check money for add new activity 
    * return true or false
    */

    public function is_money($price) {
      return preg_match('/^[0-9]+(\.[0-9]{0,2})?$/', $price);
    }

    /************/
    public function add_morepassenger($bkID, $passID, $bkType){
        $accompany = MU_Model::getForiegnTableName("passenger_booking", array('pbk_bk_id' => $bkID, 'pbk_pass_id' => $passID), 'pbk_pass_come_with');
        $accompany = unserialize($accompany);
        $pID = $this->input->post('bkmodalpass');
        $accompany[$pID] = $pID;
        $accompany = serialize($accompany);
        $result = $this->mod_booking->updateaccompany($accompany, $bkID, $passID);
        if($result){
            $this->session->set_userdata('create', show_message('The passenger added successfully.', 'success'));
            redirect('booking/view_booking_'.$bkType.'/'.$bkID.'/'.$bkType);
        }
    }

    /***********/ // 24th June 2014
    public function add_extraservice($bkID, $bkType){
        $extraservices = array();
        $extraservices = MU_Model::getForiegnTableName("booking", array('bk_id' => $bkID), 'bk_addmoreservice');
        $extraservices = unserialize($extraservices);
        $esID = $this->input->post('bkmodalextraservice');
        $esamount = $this->input->post('bkamountproduct');
        $objRecord = $this->mod_booking->getExtraProductById($esID);

        $extraproductactbooking = $objRecord->result();
        $extraproductactbooking = json_decode(json_encode($extraproductactbooking), true);
        $extraservices[$esID] = $extraproductactbooking[0];
        $extraservices[$esID]['amount'] = $esamount;

        // Customize booking
        if ($bkType == 'customize') {
            $temp_old = array();
            $temp_new = array();
            $bookingInfos = $this->mod_booking->getBookingEditCustomize($bkID)->result();
            foreach ($bookingInfos as $bookingInfo) {
                $temp_old = unserialize($bookingInfo->bk_addmoreservice);
            }
            $temp_new = $this->insertArrayIndex($temp_new, $extraservices[$esID], $esID);
            array_push($temp_old, $temp_new);
            $extraservices = $temp_old;
        }
        // End customize booking

        $extraservices = serialize($extraservices);
        $result = $this->mod_booking->updateExtraservice($extraservices, $bkID);
        if($result){
            $epStock = MU_Model::getForiegnTableName('extraproduct',array('ep_id'=> $esID),'ep_actualstock');
            if($epStock >= $esamount){
                $epStock = $epStock - $esamount;
                MU_Model::updateStockAll('extraproduct',array('ep_id'=> $esID),array('ep_actualstock' => $epStock));
                $this->session->set_userdata('create', show_message('The extra service added successfully.', 'success'));
            }else{
               $this->session->set_userdata('error', show_message('The amount is not avaliable in stock...', 'error')); 
            }
            
            redirect('booking/view_booking_'.$bkType.'/'.$bkID.'/'.$bkType);
        }
    }
    
    // delete multiple booking
    public function deleteMultipleBooking(){
      $multiCheck = $this->input->post("check_checkbox");
      $update['bk_deleted'] = 1;
      $result = $this->mod_booking->deleteMultiplebk($update, $multiCheck);
      if($result > 0){
            $this->session->set_userdata('create', show_message('The booking was deleted successfully.', 'success'));
            echo "t";
        } else {
            $this->session->set_userdata('create', show_message('Cannot delete record from table booking.', 'error'));
            echo "f";
        }
    }
    // end of delete multiple booking

    /* delete permenent booking */
    public function deletePermenentBooking() {
        $multiCheck = $this->input->post("check_checkbox");
        $result = $this->mod_booking->deletePermenentbk($multiCheck);
        if ($result > 0) {
            $this->session->set_userdata('create', show_message('The booking was deleted permenent successfully.', 'success'));
            echo "t";
        } else {
            $this->session->set_userdata('create', show_message('Cannot delete record from table booking.', 'error'));
            echo "f";
        }
    }

   ////////////// customize ////////////////

    /*
    * pulic function view_booking
    * @param   
    * noreturn
    * redirect to the view page
    */

    // private $priceBooking = 0;
    public function view_booking_customize($bkID, $bkType){
        $data['title'] = "Booking Management";
        $data['dashboard'] = "management";
        $data['passenger'] = $this->mod_booking->getPassenger();
        $data['bookingedit'] = $this->mod_booking->getBookingEditCustomize($bkID);
        // $data['getpkORcus'] = $this->mod_booking->getAllCustomize();
        $data['extraService'] = $this->mod_booking->getAllExtraService();
        if($this->input->post('btnviewsubmit')){
            $updatebooking['bk_type'] = $this->input->post('bkType');
            $updatebooking['bk_date'] = $this->input->post('bkDate');
            $updatebooking['bk_arrival_date'] = $this->input->post('bkArrivalDate');
            $updatebooking['bk_pay_date'] = $this->input->post('bkPayDate');
            $updatebooking['bk_pay_status'] = $this->input->post('bkPaystatus');
            $updatebooking['bk_status'] = $this->input->post('bkstatus');
            $bookingpassid['passID'] = $this->input->post('bkpass');
            $bookingpackage = $this->input->post('pkORcus');

            $extraservicecheckbox = $this->input->post('epacc_checkbox');
            $passengercheckbox = $this->input->post('pass_checkbox');

            $config = $this->booking_config();
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('create', show_message('<p class="error">'.'Please complete the field required...'.'</p>', 'error'));
            }else{
                $this->saveChangePassengers($passengercheckbox, $bkID, $bookingpassid['passID']);
                $servicePrice = $this->saveChangeExtraservices($bkID, $extraservicecheckbox);
                $cuspkPrice = $this->input->post('pkconprice');
                if($passengercheckbox == NULL){ $aop = 1; }else{ $aop = count($passengercheckbox)+1; }
                $updatebooking['bk_pay_price'] = ($servicePrice + $cuspkPrice) * $aop;
                $updatebooking['bk_total_people'] = $aop;
                if(isset($updatebooking['bk_pay_price']) && $this->is_money($updatebooking['bk_pay_price'])){
                    $result_booking = $this->mod_booking->updateBooking($updatebooking, $bkID);
                    if($result_booking){
                        $this->session->set_userdata('create', show_message('<p>'.'Booking was updated successfully ...'.'</p>', 'success'));
                        $this->mod_booking->updatepassbooking($bookingpassid['passID'], $bkID);
                        $this->mod_booking->updatesalecustomize($bookingpackage, $bkID);
                        // redirect('booking/list_record');
                        redirect('booking/view_booking_'.$updatebooking['bk_type'].'/'.$bkID.'/'.$updatebooking['bk_type']);
                        break;
                    }
                }
            }
        }
        $this->load->view('munich_admin', $data);
    }

    /************/
    public function saveChangePassengers($passengercheckbox, $bkID, $passID){
        $accompany = MU_Model::getForiegnTableName("passenger_booking", array('pbk_bk_id' => $bkID, 'pbk_pass_id' => $passID), 'pbk_pass_come_with');
        $accompany = unserialize($accompany);
        $newaccompany = array();
        if($passengercheckbox != NULL){
            foreach($passengercheckbox as $pssID){
                $newaccompany[$pssID] = $pssID;
            }
        }
        if($newaccompany != NULL){
            $newaccompany = serialize($newaccompany);
            $result = $this->mod_booking->updateaccompany($newaccompany, $bkID, $passID); 
            return $result;
        } else {
            $result = $this->mod_booking->updateaccompany(NULL, $bkID, $passID);
            return 0;
        }      
    }

    /****************/
    public function saveChangeExtraservices($bkID,$extraservicecheckbox, $oldextraservice = false){
        $extraservices = array();
        $extraservices = MU_Model::getForiegnTableName("booking", array('bk_id' => $bkID), 'bk_addmoreservice');
        $extraservices = unserialize($extraservices);
        $newextrservices = array();
        $prices = 0;
        if($extraservicecheckbox != NULL){
            foreach($extraservicecheckbox as $eservice){
                $newextrservices[$eservice] = $extraservices[$eservice];
                if(isset($extraservices[$eservice]['amount'])){
                    $prices += ($extraservices[$eservice]['ep_saleprice']*$extraservices[$eservice]['amount']);
                }else{
                    $prices += $extraservices[$eservice]['ep_saleprice'];
                }
            }
        }
        $arrayresult = array_diff_key($oldextraservice, $extraservicecheckbox);
        foreach($arrayresult as $esupdatestock){ 
            if($esupdatestock[1] != ''){

                $epStock = MU_Model::getForiegnTableName('extraproduct',array('ep_id'=> $esupdatestock[0]),'ep_actualstock');
                $epStock = $epStock + $esupdatestock[1];
                MU_Model::updateStockAll('extraproduct',array('ep_id'=> $esupdatestock[0]),array('ep_actualstock'=> $epStock));
            
            }
        }
        if($newextrservices == NULL){ $newextrservices = NULL; }else{ $newextrservices = serialize($newextrservices); }        
        $result = $this->mod_booking->updateExtraservice($newextrservices, $bkID);
        if($result != NULL){
            return $prices;
        }else{
            return 0;
        }
    }

    /*
    * public function customize_more_passenger
    * load template fe_more_passenger
    */
    public function customize_more_passenger() {
        $bkID = $this->input->post('bk_id');
        $passID = $this->input->post('pass_id');
        $accompany = MU_Model::getForiegnTableName("passenger_booking", array('pbk_bk_id' => $bkID, 'pbk_pass_id' => $passID), 'pbk_pass_come_with');
        $accompany = unserialize($accompany);
        $temp_old = array();
        $temp_new = array();
        if ($accompany) {
            $temp_old = $accompany;
        }

        $passengerInfo = array(
            'pass_addby' => $passID,
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
        $success  = $this->mod_booking->personal_information($passengerInfo);
        $result = false;
        if ($success) {
            $temp_old = $this->insertArrayIndex($temp_old, $passengerInfo['pass_id'], $passengerInfo['pass_id']);
            // array_push($temp_old, $temp_new);
            $accompany = serialize($temp_old);
            $result = $this->mod_booking->updateaccompany($accompany, $bkID, $passID);
        }

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
    }

    // Check existing passenger by email
    function checkExistPassengerByEmail() {
        $email = $this->input->post('email');
        $result = $this->mod_booking->exist_passenger_by_email($email);
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */