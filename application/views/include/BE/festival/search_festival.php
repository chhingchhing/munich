<div class="col-md-12 column">
    <ol class="breadcrumb">
      <li><?php echo anchor("munich_admin","Dashboard"); ?></li>
      <li>Manage</li>
    </ol>
</div>
<div class="row">
    <div class="col-md-7 column search">
        <?php
         if (isset($festival_search_name))
             $searchfestival = $festival_search_name;
         else
             $searchlocation = "";
        echo form_open("festival/search_festival", 'class="navbar-form navbar-left" role="search"');
        
        echo '<div class="form-group">';
        echo form_input(
                array('name' => 'search_festival_name',
                    'value' => set_value('search_name'),
                    'class' => 'form-control input-sm',
                    'placeholder' => 'Festival Name'));
        echo '</div> &nbsp;';
        echo form_submit(array("name" => "submit_search", "value" => "Search", "class" => "btn btn-primary btn-sm"));
        echo form_close();
        ?>
    </div>
    <div class="col-md-5 column top-action">
                    <?php echo form_button('btnDeleteMulti', 'Delete', 'class="btn btn-primary btn-sm multi_delete"'); 
                           echo anchor("festival/deleteMultipleFestival","",'class="tdelete" style="display:none;"'); 
                    ?>
                    <?php echo form_button('btnDeletePermenent', 'Remove Permenent', 'class="btn btn-primary btn-sm perm_delete"');
                          echo anchor("festival/deletePermenentFestival", "", 'class="pdelete" style="display:none;"');
                    ?>
                    <?php 
                      echo form_button('', 'Add New','class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg"');
                    ?>
    </div>
</div> 
    <table class="table table-striped table-hover table-bordered">
        <tr> 
            <th><input type="checkbox" name="checkbox_all" id="checkbox_all"></th>
            <th><?php echo anchor("festival/list_record/ID/" . $sort, "No"); ?></th>
            <th><?php echo anchor("festival/list_record/Name/" . $sort, "Festival"); ?></th>
            <th>Detail</th>
            <th>Action</th>
        </tr>
        <?php if ($search_festival->num_rows > 0) { ?>
        <?php foreach ($search_festival->result() as $data) { ?>
        <tr>
            <td>
                <?php echo form_checkbox(
                    array('class' => 'check_checkbox',
                          'id' => 'check_checkbox', 
                          'name' => 'check_checkbox[]'
                        ), 
                          $data->ftv_id
                    ); 
                ?>
            </td>
            <td><?php echo $data->ftv_id; ?></td>
            <td><?php echo $data->ftv_name; ?></td>
            <td><?php echo $data->ftv_detail; ?></td>
            <td>
                <?php
                $uri = "";
                echo anchor('festival/view_festival/'.$data->ftv_id.'/'.$uri, '<span class="icon-eye-open"></span>')  . '|' .
                anchor('festival/edit_festival/'.$data->ftv_id.'/'.$uri, '<span class="icon-edit"></span>') . '|' .
                anchor('festival/deleteFestivalById/' . $data->ftv_id . '/' . $uri, '<span class="icon-trash"></span>', 'title = "Delete" onclick="return confirm(\'Are you sure want to delete this record?\');" data-toggle="tooltip" id="tooltip"');
                ;
                ?>
            </td>            
        </tr>
        <?php 
		}
      	}
		else{
        	echo '<tr><td colspan="12"><div class="alert alert-info bs-alert-old-docs">No data match for search!	</div></td></tr>';
        }
         ?>	
       </table>
            <ul class="pagination">
                <?php echo $pagination; ?>
            </ul>

<!-- add new festival in search -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Festival</h4>
      </div>
      <div class="modal-body">
          <?php  echo form_open_multipart('festival/add_festival', 'class="form-horizontal add_location"'); ?>
            <div class="form-group">
                <label class="col-sm-4 control-label">Festival Name <span class="require">*</span> :</label>
                <div class="col-sm-7">
                    <?php
                        $festivalName = array('name' => 'festivalName','value'=> set_value('festivalName'),'class' => 'form-control');
                        echo form_input($festivalName);
                    ?>
                    <span style="color:red;"><?php echo form_error('festivalName'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Festival Detail <span class="require">*</span> :</label>
                <div class="col-sm-7">
                    <?php
                        $festivalDetail = array('name' => 'festivalDetail','value'=> set_value('festivalDetail'),'class' => 'form-control');
                        echo form_input($festivalDetail);
                    ?>
                    <span style="color:red;"><?php echo form_error('festivalDetail'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Festival Photo <span class="require">*</span> :</label>
                <div class="col-sm-7">
                    <?php 
                        $photos = array();
                            if($festivalPhotos->num_rows > 0){
                                $photos['0'] = "--- select ---";
                                foreach($festivalPhotos->result() as $value){
                                    $photos[$value->photo_id] = $value->pho_name;
                                }
                            }
                    echo form_dropdown('festivalPhotos', $photos,'', 'class="form-control"');  
                    ?>
                    <span style="color:red;"><?php echo form_error('festivalPhotos'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?php 
                        echo form_submit('addFestival', 'Add',"class='btn btn-primary check_value'");
                    ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <p style="display:none; color:red">Some Field is wrong!... Please check Data Again before you submit.</p>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
  </div>
</div>