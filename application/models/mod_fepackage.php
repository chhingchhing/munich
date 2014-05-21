<?php
	if (!defined('BASEPATH'))
    	exit('No direct script access allowed');
class mod_fepackage extends MU_Model{
	/*
    * getAllpackage is public method
    * @param $ftv as int
    * @param $lc as int
    * RETURN as Object
    */
    public function getallpackages($ftv, $lc){
    	$today = date("Y-m-d");
        $query = $this->db->select('*')         
            ->where('package_conjection.pkcon_lt_id', $lc)
            ->where('package_conjection.pkconl_ftv_id', $ftv)
            ->where('package_conjection.pkcon_start_date >=', date("Y-m-d", strtotime($today)))
            ->or_where('package_conjection.pkcon_end_date >', date("Y-m-d", strtotime($today)))
            ->where('pkcon_deleted', 0)
            ->where('pkcon_status', 1)
            ->get('package_conjection');
        return $query;
    }
    /*
    * getdetailpackages is public method
    * @param $pkID as int
    * RETURN as Object
    */

    public function getdetailpackages($pkID){
        $query = $this->db->select('*')
            ->join('location', 'location.lt_id = package_conjection.pkcon_lt_id')
            ->join('festival', 'festival.ftv_id = package_conjection.pkconl_ftv_id')            
            ->join('photo', 'photo.photo_id = package_conjection.phoid') 
            ->where('pkcon_deleted', 0)
            ->where('pkcon_status', 1)
            ->where('pkcon_id', $pkID)
            ->get('package_conjection');
        return $query;
    }
}

/* End of file mod_fepackage.php */
/* Location: ./application/models/mod_fepackage.php */