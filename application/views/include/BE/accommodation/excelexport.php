<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=exceldata.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php
echo '<table width="900" cellpadding="0" cellspacing="0" border="1" style="text-align:center; margin-top: 5px;">
        <thead>
                <tr>
                    <th>N&ordm;</th>
                    <th>Accommodation Name</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Location</th>
                    <th>Purchase Price</th>
                    <th>Sale Price</th>
                    <th>Original Stock</th>
                    <th>Actual Stock</th>
                </tr>
                 
            </thead>
            <tbody>';
?>

        <?php
        // column id
        $id = 1;
        if ($this->uri->segment(3)) {
            $id = $this->uri->segment(3) + 1;
        } else {
            $id = 1;
        }
	foreach ($accommodation as $data):
                  echo '<tr><th>'.$id++.'</th>
                        <th>'.$data->acc_name.'</th>
                        <th>'.$data->start_date.'</th>
                        <th>'.$data->end_date.'</th>
                        <th>'.$data->lt_name.'</th>
                        <th>'.$data->acc_purchaseprice.'</th>
                        <th>'.$data->acc_saleprice.'</th>
                        <th>'.$data->acc_originalstock.'</th>
                        <th>'.$data->acc_actualstock.'</th></tr>';
            ?>
        <?php endforeach; 

         '<tbody></table>'; ?>
<?php
