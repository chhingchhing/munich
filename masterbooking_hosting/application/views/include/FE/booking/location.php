<div class="row clearfix">
	<div class="form-group">
        <div class="col-sm-3 col-sm-offset-9">
            <?php 
            echo form_open("site/booking/view_more");
                $locations = array();
                $locations[''] = "--- select country ---";
                    if($getLocation->num_rows > 0){
                        foreach($getLocation->result() as $value){
                            $locations[$value->lt_id] = $value->lt_name;
                        }
                    }
            echo form_dropdown('select_value', $locations, '', 'class="form-control" onchange="this.form.submit()"');  
            echo form_close();
            ?>
        </div>
    </div>
</div>