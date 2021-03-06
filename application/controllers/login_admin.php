<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mod_admin');
    }

    public function index() {
        $this->loginAdmin();
    }

    public function loginAdmin() {
        $data['title'] = "Administrator Login";
        $data['admin'] = "admin";
        // $this->load->view('login', $data);
        $this->load->view("include/BE/login_admin/login", $data);
        
    }
    public function login(){
        echo "know";
        if (isset($_POST['btn_login'])) {
            echo "know button";
           $this->form_validation->set_rules('txtEmail', 'Username', 'required|trim');
            $this->form_validation->set_rules('txtPassword', 'Password', 'required|trim');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('login_erro', show_message('Your username or password is not match!', 'error'));
                redirect('login_admin/');
            }else{
                $username = $this->input->post('txtEmail');
                $password = $this->input->post('txtPassword');
                $this->session->set_userdata('old_pass',$password);
                $data['login'] = $this->mod_admin->signin_admin($username, $password);
                if ($data['login']->num_rows() > 0) {
                        foreach ($data['login']->result() as $rows) {
                            $user = array(
                                    'user_id'=> $rows->user_id,
                                    'user_email'=> $rows->user_mail
                     );
                   $id = $rows->user_id;
                    $this->session->set_userdata('admin', $user);
                    $this->session->set_userdata('success_msg', show_message("Your login was successfully", "success"));
                    redirect('munich_admin/');
                        }

                }else{

                    $this->session->set_userdata('login_error', show_message('Your username or password is not match!', 'error'));
                    redirect('login_admin');
                }

            }
        } else {
          
          $this->load->view('login_admin');
        }
    }
    public function logout(){
        $this->session->set_userdata('logout', show_message('You have been logout!', 'notice'));
        $this->session->sess_destroy();
        redirect('login_admin');
    }

    public function master_page() {
        // $this->load->view('include/BE/master_page');
    }

}

/* End of file mu_admin.php */
/* Location: ./application/controllers/mu_admin.php */