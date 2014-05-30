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
            ->where('accommodation.acc_deleted',0)
            ->where('accommodation.acc_subof', 0)
            ->where('accommodation.acc_ftv_id', $ftvID)
            ->where('accommodation.location_id', $lcId)
            ->get('accommodation');
            return $accommodation;
    }

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
    public function personal_information($passengerInfo){
        if ($this->exist_passenger_by_email($passengerInfo['pass_email'])) {
            return false;
        } else {
            if($this->db->insert('passenger', $passengerInfo))
            {
                return $passengerInfo['pass_id'] = $this->db->insert_id();
                // return true;
            } 
            return false;
            // return $this->db->insert('passenger', $passengerInfo);
        }
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
    
}
