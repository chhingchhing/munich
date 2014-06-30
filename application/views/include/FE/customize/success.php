<div class="col-sm-12 form-booking" id="payments">
    <h2>Successfully</h2>
    <hr>
    <div id="pay_feedback"></div>
    
    <div>
        <?php 
        if ($this->session->userdata('passengerid')) { ?>
            <p>Your booking was successfully, thanks you.</p>
            <p>Please help us provide information about more passengers by clicking "Add more passengers"</p>
            <p>Please see detail of booking in your <?php echo anchor(base_url().$this->uri->segment('1').'/site/profile', 'profile'); ?></p>
        <?php
        } else { ?>
            <p>Your booking was successfully, thanks you.</p>
            <p>We will send you the email about detail information for login. This is the url for login into your profile page for adding the more passengers via your amount of people you have entered. </p>
            <p>Please help us provide information about more passengers by clicking "Add more passengers"</p>
            <p>This is the url for <?php echo anchor(base_url().$this->uri->segment('1').'/fe_login/loginuser', 'Login'); ?></p>
        <?php }
        ?>
        
    </div>
    
<p></p>
</div>
    <!-- end div home -->
