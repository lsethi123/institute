<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Rahul Mishra" />
    <meta name="developed by" content="Tech Schema" />
    <meta name="website" content="Property Vihar" />
    <title>Property - Add State</title>
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'style_sheet.php');
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'javascript.php');
    ?>
    <script type="text/javascript">
    $(document).ready(function() { 
    	var validator = $("#frm_add_landmark").validate({
    		rules: {
    			txt_landmark: "required"
    		},
    		messages: {
                txt_landmark: "Please enter landmark"
    		}
    	});
    });
</script>
</head>
<body>
    <div id="header">
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'header.php');
        
        require_once(LIB . 'db.php');
        if (isset($_POST['submit'])) {
            $landmark_name = $_POST['txt_landmark'];
            if(!empty($landmark_name)){
                
                    $sql = "INSERT INTO `landmarks_lnd`(`name_lnd`,`is_active`,`created_by`,`created_at`)".
                        "VALUES (:landmark_name,1,0,now());";
                    $db->queryPrepared($sql,array(':landmark_name' => $landmark_name))->rowCount();
                    $startup_scripts .= "showSucc('Landmark added successfully');";
                
            }
            else{
                $startup_scripts .= "showError('Please enter landmark');";
            }
        }
    ?>
    </div>
    <div id="misc" class="keepCenter">
        <div id="errorDiv" class="showInfo">
        </div>
        <div id="warnDiv" class="showInfo">
        </div>
        <div id="infoDiv" class="showInfo">
        </div>
        <div id="succDiv" class="showInfo">
        </div>
    </div>
    <?php include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'adminpanel.php'); ?>
    <div class="content-box">
        <div class="content-box-header">
            <h3>Add Landmark</h3>
        </div>
        <div class="content-box-content">
            <form method="post" name="frm_add_landmark" id="frm_add_landmark" accept="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="form_table">
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_landmark">Landmark <span class="star">*</span> :</label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_landmark" name="txt_landmark" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td>
                            &nbsp;
                        </td>
                        <td>
                            <input type="submit" id="frm_add_lanmark_submit" name="submit" class="myButton" />
                        </td>
                    </tr>
                </table>
            </form>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            
        </div>
    </div>
    <div id="footer">
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'footer.php');
    ?>
</div>
</body>
</html>