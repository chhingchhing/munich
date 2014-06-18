<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mod_FeCustomize extends MU_model {
    
    // select join with table photo, location, festival, by session and where lcID and ftvID
    public function trip_information($ftvID, $lcId){   
        $query = $this->db->select('*')
         ->join('acti_calendar','activities.act_id = acti_calendar.activities_id', 'left')
         ->join('calendar_available','calendar_available.ca_id = acti_calendar.calendar_available_id', 'left')   
         ->join('photo','photo.photo_id = activities.photo_id') 
         ->where("activities.act_deleted", 0)
         ->where('activities.act_ftv_id', $ftvID)
         ->where('activities.location_id', $lcId)
         ->where('activities.act_subof',0)
         ->get('activities');
        return $query;
    }
    /*
    * public function select sub activity
    * @param parameter $ftvID, $lcId, $subAct
    */
    public function selectSubActivity($ftvID, $lcId, $subAct){
        $sub_activity = $this->db->select('*')
             ->join('acti_calendar','activities.act_id = acti_calendar.activities_id')
             ->join('calendar_available','calendar_available.ca_id = acti_calendar.calendar_available_id') 
             ->join('photo','photo.photo_id = activities.photo_id')     
             ->where("activities.act_deleted", 0)
             ->where('activities.act_ftv_id', $ftvID)
             ->where('activities.location_id', $lcId)
             ->where('activities.act_subof', $subAct)
             ->get('activities');
            return $sub_activity;
    }
    /* public function select extra products
    * @param parameter  
    */
    public function selectExtraProductActivity($ftvID, $lcId, $ActID){
        $select_extraProductsActivity = $this->db->select('*')
        ->join('extraproduct_calendar','extraproduct.ep_id = extraproduct_calendar.extraproduct_id')
        ->join('calendar_available','calendar_available.ca_id = extraproduct_calendar.calendar_available_id')
        ->join('extra_acti','extraproduct.ep_id = extra_acti.extraproduct_id')
        ->join('activities','activities.act_id = extra_acti.activities_id')
        ->join('photo','photo.photo_id = extraproduct.photo_id')
        ->where('extra_acti.activities_id',$ActID)
        ->where('activities.location_id', $lcId)
        ->where('activities.act_ftv_id', $ftvID)
        ->where('ep_deleted',0)
        ->get('extraproduct');
        return $select_extraProductsActivity;
    }

    /*
    * public function select accommodation
    * @param parameter $ftvID, $lcId
    */
    public function accommodation($ftvID, $lcId){
        $accommodation = $this->db->select('*')
            ->join('acc_calendar','accommodation.acc_id = acc_calendar.accomodations_id')
            ->join('calendar_available', 'calendar_available.ca_id = acc_calendar.calendar_available_id')
            ->join('photo','photo.photo_id = accommodation.photo_id')
            ->join('room_types','room_types.rt_id = accommodation.acc_rt_id')
            ->join('classification','classification.clf_id = accommodation.classification_id')
            ->join('hotel_detail','hotel_detail.dhrt_id = room_types.rt_id')
            ->where('accommodation.acc_deleted',0)
            ->where('accommodation.acc_subof', 0)
            ->where('accommodation.acc_ftv_id', $ftvID)
            ->where('accommodation.location_id', $lcId)
            ->get('accommodation');
            return $accommodation;
    }
    /*public function accommodation($ftvID, $lcId){
        $accommodation = $this->db->select('*')
            ->join('acc_calendar','accommodation.acc_id = acc_calendar.accomodations_id')
            ->join('calendar_available', 'calendar_available.ca_id = acc_calendar.calendar_available_id')
            ->join('photo','photo.photo_id = accommodation.photo_id')
            ->join('room_types','room_types.rt_id = accommodation.acc_rt_id')
            ->join('classification','classification.clf_id = accommodation.classification_id')
            ->where('accommodation.acc_deleted',0)
            ->where('accommodation.acc_subof', 0)
            ->where('accommodation.acc_ftv_id', $ftvID)
            ->where('accommodation.location_id', $lcId)
            ->get('accommodation');
            return $accommodation;
    }*/

    /* * public function select sub accommodation
    * @param parameter $ftvID, $lcId
    */
    public function selectSubAccommodation($ftvID, $lcId, $subAcc){
        $subAccommodation = $this->db->select('*')
            ->join('acc_calendar','accommodation.acc_id = acc_calendar.accomodations_id')
            ->join('calendar_available', 'calendar_available.ca_id = acc_calendar.calendar_available_id')
            ->join('photo','photo.photo_id = accommodation.photo_id')
            ->where('accommodation.acc_deleted',0)
            ->where('accommodation.acc_subof', $subAcc)
            ->where('accommodation.acc_ftv_id', $ftvID)
            ->where('accommodation.location_id', $lcId)
            ->get('accommodation');
            return $subAccommodation;
    }
    public function selectRoomType(){
        $roomType = $this->db->select('*')
            ->from('room_types')
            ->where('rt_status',1)
            ->where('rt_deleted',0)
            ->get();
        return $roomType;
    }
    /*
    * select extra products of Accommodation
    * @param parameter $ftvID, $lcID, $accID
    */
    public function selectExtraProductAccommodation($ftvID, $lID, $accID){
        $extra_acc = $this->db->select('*')
        ->join('extraproduct_calendar','extraproduct.ep_id = extraproduct_calendar.extraproduct_id')
        ->join('calendar_available','calendar_available.ca_id = extraproduct_calendar.calendar_available_id')
        ->join('extra_acc','extraproduct.ep_id = extra_acc.extraproduct_ep_id')
        ->join('accommodation','accommodation.acc_id = extra_acc.accomodations_ad_id')
        ->join('photo','photo.photo_id = extraproduct.photo_id')
        ->where('extra_acc.accomodations_ad_id',$accID)
        ->where('accommodation.location_id', $lID)
        ->where('accommodation.acc_ftv_id', $ftvID)     
        ->where('ep_deleted',0)
        ->get('extraproduct');
        return $extra_acc;
    }
    /* * public function select transportation
    * @param parameter $ftvID, $lcId, $subAct
    */
    public function transportation($ftvID, $lcId){
        $transportation = $this->db->select('*')
            ->join('tp_calendar','transportation.tp_id = tp_calendar.transport_id')
            ->join('calendar_available','calendar_available.ca_id = tp_calendar.calendar_available_id')
            ->join('photo','photo.photo_id = transportation.photo_id')
            ->join('supplier','supplier.sup_id = transportation.tp_supplier_id')
            ->where('transportation.tp_deleted',0)
            ->where('transportation.tp_ftv_id', $ftvID)
            ->where('transportation.tp_subof',0)
            ->get('transportation');
            return $transportation;
    }
    /*
    * public function select sub transportation
    * @param parameter $ftvID, $lcId, $subAct
    */
    public function selectSubTransportation($ftvID, $lcId, $subAct){
            $subtransportation = $this->db->select('*')
            ->join('tp_calendar','transportation.tp_id = tp_calendar.transport_id')
            ->join('calendar_available','calendar_available.ca_id = tp_calendar.calendar_available_id')
            ->join('photo','photo.photo_id = transportation.photo_id')
            ->join('supplier','supplier.sup_id = transportation.tp_supplier_id')
            ->where('transportation.tp_deleted',0)
            ->where('transportation.tp_ftv_id', $ftvID)
            ->where('transportation.tp_subof', $subAct)
            ->get('transportation');
            return $subtransportation;
    }
    /*
    * public function select extra product of Transportation
    * @param parameter $ftvID, $tpID
    */
    public function selectExtraProductTransportation($ftvID, $tpID){
        $tp_extra = $this->db->select('*')
                    ->join('extraproduct_calendar', 'extraproduct.ep_id = extraproduct_calendar.extraproduct_id')
                    ->join('calendar_available','calendar_available.ca_id = extraproduct_calendar.calendar_available_id')
                    ->join('extra_transport','extraproduct.ep_id = extra_transport.extraproduct_id')
                    ->join('transportation','transportation.tp_id = extra_transport.transport_id')
                    ->join('photo','photo.photo_id = extraproduct.photo_id')
                    ->where('extra_transport.transport_id', $tpID)
                    ->where('transportation.tp_ftv_id', $ftvID)
                    ->where('tp_deleted',0)
                    ->where('ep_deleted',0)
                    ->get('extraproduct');
        return $tp_extra;
    }

    /* 
    * select all extra products
    * @param paremeter 
    */
    public function selectExtraProdcuts(){
        $extraProducts = $this->db->select('*')
            ->join('extraproduct_calendar','extraproduct.ep_id = extraproduct_calendar.extraproduct_id')
            ->join('calendar_available','calendar_available.ca_id = extraproduct_calendar.calendar_available_id')
            ->join('photo','photo.photo_id = extraproduct.photo_id')
            ->where('extraproduct.ep_deleted',0)
            ->get('extraproduct');
        return $extraProducts;
    }  
    /*
    * public function add information of passenger to table passenger
    * @param parameter $pfname, $plname, $pgender, $pdob, $pmobile, $phphone, $paddress, $pcode, $pcity, $pcountry, $pnumber
    */
    public function personal_information($passengerInfo, $pass_id=false){
        if (!$pass_id or !$this->exist_passenger_by_id($pass_id)) {
            // Plus 1 more is trip leader
            $amount_people = $this->get_all_member_by_pass_addby($passengerInfo['pass_addby'])->num_rows() + 1;
            if ($amount_people < $this->session->userdata("people")) {
                if ($this->exist_passenger_by_email($passengerInfo['pass_email'])) {
                    return false;
                } else {
                    if($this->db->insert('passenger', $passengerInfo))
                    {
                        return $passengerInfo['pass_id'] = $this->db->insert_id();
                    } 
                    return false;
                }
            } else {
                return "over_number";
            }
        } else {
            $this->db->where('pass_id', $pass_id);
            return $this->db->update('passenger',$passengerInfo);
        }
        return false;
    }
    /*public function personal_information($passengerInfo){
        // Plus 1 more is trip leader
        $amount_people = $this->get_all_member_by_pass_addby($passengerInfo['pass_addby'])->num_rows() + 1;
        if ($amount_people < $this->session->userdata("people")) {
            if ($this->exist_passenger_by_email($passengerInfo['pass_email'])) {
                return false;
            } else {
                if($this->db->insert('passenger', $passengerInfo))
                {
                    return $passengerInfo['pass_id'] = $this->db->insert_id();
                } 
                return false;
            }
        } else {
            return "over_number";
        }
    }*/

    /*
    * Count all passengers who added by a trip leader
    */
    function get_all_member_by_pass_addby($pass_addby) {
        $query = $this->db->where("pass_addby", $pass_addby)->get("passenger");
        return $query;
    }

    /*
    * Check existing passenger by email
    */
    function exist_passenger_by_email($email) {
        $query = $this->db
            ->where("pass_email", $email)
            ->get("passenger");
        return ($query->num_rows() == 1);
    }

    /*
    * Check existing passenger by id
    */
    function exist_passenger_by_id($id) {
        $query = $this->db
            ->where("pass_id", $id)
            ->get("passenger");
        return ($query->num_rows() == 1);
    }

    /*
    * Get passenger information when passenger has been loged in
    */
    public function customizePersonal_info($passenger_id) {
        $query = $this->db
            ->where("pass_id", $passenger_id)
            ->get("passenger");
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $pass_obj=new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('passenger');

            foreach ($fields as $field)
            {
                $pass_obj->$field='';
            }

            return $pass_obj;
        }
    }

    /*
    Returns all the room types
    */
    function getAllRoomType($ht_id, $classification_id)
    {
        $data = $this->db
            ->join('hotel_detail', 'hotel.ht_id = hotel_detail.dhht_id')
            ->join('room_types', 'room_types.rt_id = hotel_detail.dhrt_id')
            ->where('dhcl_id', $classification_id)
            ->where('dhht_id', $ht_id)
            ->get("hotel");
        return $data;
    }

    // Get all room type when each passenger
    function getAllRoomTypeEachPassenger($rt_id)
    {
        $data = $this->db
            ->join('hotel', 'hotel.ht_id = hotel_detail.dhht_id')
            ->join('room_types', 'room_types.rt_id = hotel_detail.dhrt_id')
            ->where('dhrt_id', $rt_id)
            ->get("hotel_detail");
        return $data;
    }

    //Get all hotels
    function getAllHotels($classification_id) {
        $data = $this->db
            ->where('dhcl_id', $classification_id)
            ->group_by('dhht_id')
            ->get("hotel_detail");
        return $data;
    }

    // Get information of item
    function get_info_of_main_obj($table, $col, $id, $field_select) {
        $query = $this->db
            ->select($field_select)
            ->where($col, $id)
            ->get($table);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $object = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields($table);

            foreach ($fields as $field)
            {
                $object->$field='';
            }
            return $object;
        }
    }

    function get_info_hotel($rt_id) {
        $query = $this->db
            ->join('hotel_detail', 'hotel.ht_id = hotel_detail.dhht_id')
            ->join('room_types', 'room_types.rt_id = hotel_detail.dhrt_id')
            ->where('dhrt_id', $rt_id)
            ->get("hotel");
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return false;
    }

    /*
    * Inserting data into table booking
    */
    function insertBookingInfo(&$bk_info) {
        if ($this->db->insert('booking', $bk_info)) {
            $bk_info['bk_id'] = $this->db->insert_id();
            return true;
        }
        return false;
    }

    /*
    * Inserting data into table Passenger booking
    */
    function insertPassengerBookingInfo(&$pass_bk_info) {
        if ($this->db->insert('passenger_booking', $pass_bk_info)) {
            $pass_bk_info['pbk_id'] = $this->db->insert_id();
            return true;
        }
        return false;
    }
    
}

