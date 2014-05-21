<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <script type="text/javascript">

            function printPage(id) {
                //alert('successfully');
                var html = "<fieldset>";
                html += document.getElementById(id).innerHTML;
                html += "</fieldset>";

                var printWin = window.open('', '', 'left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status =0');
                printWin.document.write(html);
                printWin.document.close();
                printWin.focus();
                printWin.print();
                printWin.close();

                var html = "<html>";
                html += "<head>";
                // html+="<style type='text/css'>.mytable{border:1px solid #ccc;}.mytable tr{background-color:#008000;color:#FFF;}</style>";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/bootstrap.css' media='print' />";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/bootstrap-responsive.css' media='print' />";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/style.css' media='print' />";
                html += "<link rel='Stylesheet' type='text/css' href='<?php echo base_url(); ?>bootstrap/css/demo_table_jui.css' media='print' />";
                html += "</head>";
                html += document.getElementById(id).innerHTML;
                html += "</html>";

            }
        </script>
    </head>
    <body>
         <fieldset id="report" style="border:1px solid #239DA9 ;margin: 0 auto;width:96%;height: auto; padding:20px;border-radius:5px;">
                <div>
                    <?php echo '<br/><div style="float:right;color:#239DA9;width:40%;text-align:right; margin-right: 15%; margin-top:2%;"><span>Print Date:</span>' . '<span style="color:#3488CC;"> ' . date("D/M/Y") . '</span><br/>';
                    ?>
                    Print &nsp;
                   <img src="<?php echo base_url(); ?>assets/img/FE/printer.gif" align="center" onClick="return printPage('report');" id="image"  alt="image" title="Print"/>
               </div>
               <div style=" height: 50px;  margin:10px;">
                <img src="<?php echo base_url(); ?>assets/img/FE/cg-logo.png" align="center"   alt="logo" />
              </div>
        <div>
        <?php
              echo '<h1 style="color: #239DA9;
                    font-family: verdana;
                    font-size: 20px;
                    font-weight: bold;
    text-align: center;"> E-ticket Masterbookingform.com</h1></div>';
                ?>
                <div>
                    <img src="<?php echo base_url(); ?>assets/img/FE/etichet/booking_type.PNG" align="center"   alt="E-ticket" style="margin-left:100px;"/><br/>
                   <p style="margin-left:120px;"> - Hello <br/>
                    - Hello everybody<p>
                </div>
                <div>
                    <img src="<?php echo base_url(); ?>assets/img/FE/etichet/booking_information.PNG" align="center"   alt="E-ticket" style="margin-left:100px;"/><br/>
                <p style="margin-left:120px;"> - Hello <br/>
                    - Hello everybody</p>
                </div>
              </fieldset>
    
    </body>

     