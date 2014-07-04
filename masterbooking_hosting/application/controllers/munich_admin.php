<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Munich_admin extends MU_Controller {
    
     public function __construct() {
        parent::__construct();
    } 
    public function index()
    {
        if ($this->check_user_session()) {
        $this->dashboard_mn();
    }
    } 
    public function dashboard_mn(){
    if ($this->check_user_session()) {
        $data['title'] = "Dashboard";
        $data['dashboard'] = "Default Dashboard";
        $this->load->view('munich_admin', $data);
    }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */ 