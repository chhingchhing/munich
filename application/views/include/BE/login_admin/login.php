<?php
            /* remember password */
            $user = '';
            $pass = '';
            $check = '';

            if ($this->input->cookie('remem_user')) {
                $user = $this->input->cookie('remem_user');
                $pass = $this->input->cookie('remem_pass');
                $check = "checked";
            }
            /* end of remember password */
            if ($this->session->userdata('logout')) {
                echo $this->session->userdata('logout');
                $this->session->unset_userdata('logout');
            }
            ?>
<?php
  define("TEMPLATE_BE", "template/BE/");
  define("TEMPLATE_FE", "template/FE/");

  if(isset($admin)){
    $this->load->view(TEMPLATE_BE."login");
  }elseif(isset($fe)){
    $this->load->view(TEMPLATE_FE."login");
  }else{
    echo "Error not found...";
  }
?>