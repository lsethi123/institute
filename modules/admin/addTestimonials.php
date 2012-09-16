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
    	var validator = $("#frm_add_testimonial").validate({
    		rules: {
    			txt_username: "required",
                txt_testimonial: "required"
    		},
    		messages: {
                txt_username: "Please enter username ",
                txt_testimonial: "Please enter testimonial "
    		}
    	});
    });
   function limitText(limitField,limitCount,limitNum){if(limitField.value.length>limitNum){limitField.value=limitField.value.substring(0,limitNum);}else{limitCount.value=limitNum-limitField.value.length;}} 
</script>
</head>
<body>
    <div id="header">
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'header.php');
        
        require_once(LIB . 'db.php');
        if (isset($_POST['submit'])) {
            $username = $_POST['txt_username'];
            $testimonial = $_POST['txt_testimonial'];
            if((!empty($username))&&(!empty($testimonial))){
              
                    $sql = "INSERT INTO `testimonials_tst`(`username_tst`,`testimonial_tst`,`is_active`,`created_by`,`created_at`)".
                        "VALUES (:username,:testimonial,1,0,now());";
                    $db->queryPrepared($sql,array(':username' => $username,':testimonial' => $testimonial))->rowCount();
                    $startup_scripts .= "showSucc('Testimonial added successfully');";
                
            }
            else{
                $startup_scripts .= "showError('Please enter appropriate values to continue');";
            }
        }
    ?>
    </div>
    <?php include_once(CONTENT.'follow_us.php'); ?>
    <?php include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'adminpanel.php'); ?>    
    <div class="content-box">
        <div class="content-box-header">
            <h3>Add Testimonial</h3>
        </div>
        <div class="content-box-content">
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
            <form method="post" name="frm_add_testimonial" id="frm_add_testimonial" accept="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="form_table">
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_username">Username <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_username" name="txt_username" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_testimonial">Testimonial <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                        <textarea cols="40" rows="6" style="resize:auto;" onkeydown="javascript:limitText(this.form.txt_testimonial,this.form.charCounter,1000);" onkeyup="javascript:limitText(this.form.txt_testimonial,this.form.charCounter,1000);" class="textarea auto" name="txt_testimonial" id="txt_testimonial"></textarea>
		<span style="text-align: right;"><input type="text" style="background: white;border: 0px;" value="1000" size="1" name="charCounter" readonly="readonly"/> chars left.
		</span>
		
                           
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                            &nbsp;
                        </td>
                        <td>
                            <input type="submit" id="frm_add_testimonials_submit" name="submit" class="myButton" />
                        </td>
                    </tr>
                </table>
            </form>
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