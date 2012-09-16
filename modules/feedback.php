<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
     require_once(LIB.'db.php');
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Rahul Mishra" />
    <meta name="developed by" content="Tech Schema" />
    <meta name="website" content="Property Vihar" />
    <title>Property - Add State</title>
    <?php
         include_once(LAYOUT.'template'.DS.'layout'.DS.'javascript.php');
         include_once(LAYOUT.'template'.DS.'layout'.DS.'style_sheet.php');
    ?>
    <script type="text/javascript">
    $(document).ready(function() { 
    	var validator = $("#frm_add_feedback").validate({
    		rules: {
    			txt_username: "required",
               txt_email: {
				required: true,
				email: true
			},
                txt_message: "required",
    		},
    		messages: {
                txt_username: "Please enter username ",
                txt_email: "Please enter valid email ",
                txt_message: "Please enter messages "
    		}
    	});
    });
   function limitText(limitField,limitCount,limitNum){if(limitField.value.length>limitNum){limitField.value=limitField.value.substring(0,limitNum);}else{limitCount.value=limitNum-limitField.value.length;}} 
</script>
</head>
<body>
    <?php
        $startup_scripts="";
        if (isset($_POST['submit'])) {
            $username = $_POST['txt_username'];
            $email = $_POST['txt_email'];
            $message = $_POST['txt_message'];
            if((!empty($username))&&(!empty($email))&&(!empty($message))){
              
                    $sql = "INSERT INTO `feedbacks_fdb`(`name_fdb`,`email_fdb`,`message_fdb`,`is_active`,`created_by`,`created_at`)".
                        "VALUES (:username,:email,:message,1,0,now());";
                    $db->queryPrepared($sql,array(':username' => $username,':email' => $email,':message' => $message))->rowCount();
                    $startup_scripts .= "showSucc('Thank you for submiting your valuable feedback,we will get back to you.');";
            }
            else{
                $startup_scripts .= "showError('Please enter appropriate values to continue');";
            }
        }
    ?>
    <div id="header">
         <?php
                 include_once(LAYOUT.'template'.DS.'layout'.DS.'header.php');
         ?>
    </div>

    <div class="content-box">
        <?php
                 include_once(CONTENT.'follow_us.php');
        ?>
        <div class="content-box-header">
            <h3>Enter Feedback </h3>
        </div>
        <div class="content-box-content">
            <form method="post" name="frm_add_feedback" id="frm_add_feedback" accept="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="form_table">
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_username">Name <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_username" name="txt_username" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_email">Email <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_email" name="txt_email" class="inpText" />
                        </td>
                    </tr>

                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_message">Message <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                        <textarea cols="40" rows="6" style="resize:auto;" onkeydown="javascript:limitText(this.form.txt_message,this.form.charCounter,1000);" onkeyup="javascript:limitText(this.form.txt_message,this.form.charCounter,1000);" class="textarea auto" name="txt_message" id="txt_message"></textarea>
		<span style="text-align: right;"><input type="text" style="background: white;border: 0px;" value="1000" size="1" name="charCounter" readonly="readonly"/> chars left.
		</span>
		
                           
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                            &nbsp;
                        </td>
                        <td>
                            <input type="submit" id="frm_add_feedback_submit" name="submit" class="myButton" />
                        </td>
                    </tr>
                </table>
            </form>
          
        </div>
    </div>
    <div id="footer">
    <?php
                include_once(LAYOUT.'template'.DS.'layout'.DS.'footer.php');
    ?>
</div>
</body>
</html>