<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
     require_once(LIB.'db.php');
?>
<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="Sunil Gautam" />
    <title>Settings | <?php echo INSTITUTE; ?></title>
    <?php
        include_once(LAYOUT.THEME.DS.'layout'.DS.'style_sheet.php');
        include_once(LAYOUT.THEME.DS.'layout'.DS.'javascript.php');
    ?>
    <script src="/themes/<?php echo THEME;?>/javascripts/ajaxupload.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() { 
            var validator = $("#frm_settings").validate({
                rules: {
                    txt_i_name: "required",
                    txt_address: "required",
                    txt_cont1: "required",
                    txt_email:  {
                                    required: true,
                                    email: true
                                },
                    txt_owner: "required"
                },
                messages: {
                    txt_i_name: "Please enter institute name",
                    txt_address: "Please enter address",
                    txt_cont1: "Please enter contact",
                    txt_email:  {
                                    required: "Please enter email address",
                                    email: "Invalid email address"
                                },
                    txt_owner: "Please enter owner name"
                }
            });

            var thumbLogo = $('#upload-image-logo-thumb');

            new AjaxUpload('btnUploadLogo', {
                action: '<?php echo DOMAIN ?>modules/save_logo.php',
                name: 'img_upload',
                responseType: 'json',
                onSubmit: function(file, extension) {
                    if (! (extension && /^(jpg|png|jpeg|gif|JPG|JPEG)$/.test(extension))){ 
                        // extension is not allowed 
                        showError('Only JPG, PNG or GIF files are allowed');
                        return false;
                    }
                    $('.upload-image-logo-preview').addClass('big-loading').children('img').css('display','none');
                },
                onComplete: function(file, response) {
                    thumbLogo.load(function(){
                        $('.upload-image-logo-preview').removeClass('big-loading').children('img').css('display','block');
                        thumbLogo.unbind();
                    });
                    if(response.RESULT == 'SUCCESS') {
                        var loadPath = response.RESOURCE + '?r=' + Math.random(); 
                        thumbLogo.attr('src', loadPath);
                        changeLogo(loadPath);
                    }
                    else {
                        $('.upload-image-logo-preview').removeClass('big-loading').children('img').css('display','block');
                        thumbLogo.unbind();
                    }
                }
            });
        });
        
        function changeLogo(path){
            $('.Logo').css('background-image', 'url("' + path + '")');
        }
    </script>
</head>
<body>
    <div id="header" class="completeWidth">
        <?php include_once(LAYOUT.THEME.DS.'layout'.DS.'header.php'); ?>
        <?php
            $default_logo_path = '/themes/' . THEME . '/images/ilogo.png';
            
            //VARIABLES
            $i_name = '';
            $address = '';
            $cont1 = '';
            $cont2 = '';
            $cont3 = '';
            $cont4 = '';
            $fax1 = '';
            $fax2 = '';
            $fax3 = '';
            $fax4 = '';
            $email = '';
            $owner = '';
            
            //FORM PROCESSING
            if (isset($_POST['submit'])) {
                $i_name = $_POST['txt_i_name'];
                $address = $_POST['txt_address'];
                $cont1 = $_POST['txt_cont1'];
                $cont2 = $_POST['txt_cont2'];
                $cont3 = $_POST['txt_cont3'];
                $cont4 = $_POST['txt_cont4'];
                $fax1 = $_POST['txt_fax1'];
                $fax2 = $_POST['txt_fax2'];
                $fax3 = $_POST['txt_fax3'];
                $fax4 = $_POST['txt_fax4'];
                $email = $_POST['txt_email'];
                $owner = $_POST['txt_owner'];
                
                if(check_fields($i_name, $address, $cont1, $cont2, $cont3, $cont4, $fax1, $fax2, $fax3, $fax4, $email, $owner)){
                    $sql = "UPDATE `institute_configs_icf` SET
                            `name_icf` = :i_name, `address_icf` = :address, `contact1_icf` = :cont1,
                            `contact2_icf` = :cont2 , `contact3_icf` = :cont3, `contact4_icf` = :cont4,
                            `fax1_icf` = :fax1,`fax2_icf` = :fax2,`fax3_icf` = :fax3,
                            `fax4_icf` = :fax4, `email_icf` = :email, `owner_icf` = :owner,
                            `created_at` = now();";
                    $sql_array = array(
                                        ':i_name' => $i_name, ':address' => $address,
                                        ':cont1' => $cont1, ':cont2' => $cont2,
                                        ':cont3' => $cont3, ':cont4' => $cont4,
                                        ':fax1' => $fax1, ':fax2' => $fax2,
                                        ':fax3' => $fax3, ':fax4' => $fax4,
                                        ':email' => $email, ':owner' => $owner
                                        );
                    
                    if($db->queryPrepared($sql, $sql_array)){
                        $startup_scripts .= "showSucc('Updated successfully');";
                    }
                    else {
                        $startup_scripts .= "showError('Unable to update');";
                    }
                }
                else{
                    $startup_scripts .= "showError('Please enter all required fields');";
                }
            }
            
            //LOAD EXISTING DATA
            $sql_state = "SELECT `id_icf`, `name_icf`, `address_icf`, `contact1_icf`, `contact2_icf`, `contact3_icf`, `contact4_icf`,
                        `fax1_icf`, `fax2_icf`, `fax3_icf`, `fax4_icf`, `email_icf`, `owner_icf` FROM `institute_configs_icf` LIMIT 1;";
            $data = $db->fetchQuery($sql_state);
            if(count($data) > 0){
                $i_name = $data[0]['name_icf'];
                $address = $data[0]['address_icf'];
                $cont1 = $data[0]['contact1_icf'];
                $cont2 = $data[0]['contact2_icf'];
                $cont3 = $data[0]['contact3_icf'];
                $cont4 = $data[0]['contact4_icf'];
                $fax1 = $data[0]['fax1_icf'];
                $fax2 = $data[0]['fax2_icf'];
                $fax3 = $data[0]['fax3_icf'];
                $fax4 = $data[0]['fax4_icf'];
                $email = $data[0]['email_icf'];
                $owner = $data[0]['owner_icf'];
            }
            
            function check_fields(&$i_name, &$address, &$cont1, &$cont2, &$cont3, &$cont4, &$fax1, &$fax2, &$fax3, &$fax4, &$email, &$owner){
                if (empty($i_name) || empty($address) || empty($cont1) || empty($email) || empty($owner)){
                    return false;
                }
                else {                  
                    return true;
                }
            }
        ?>
    </div>
    <div id="content">
        <div class="content-box">
            <div class="content-box-header">
                <h3>Settings</h3>
            </div>
            <div class="content-box-content">
                <div id="misc">
                    <div id="errorDiv" class="showInfo">
                    </div>
                    <div id="warnDiv" class="showInfo">
                    </div>
                    <div id="infoDiv" class="showInfo">
                    </div>
                    <div id="succDiv" class="showInfo">
                    </div>
                </div>
                <form method="post" name="frm_settings" id="frm_settings" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table class="form_table">
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_i_name">Institute Name <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_i_name" name="txt_i_name" class="inpText" value="<?php echo $i_name; ?>" />
                            </td>
                        </tr>
                        <tr valign="top">
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_address">Address <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <textarea cols="40" rows="6" style="resize:auto; overflow: auto;" class="inpText" name="txt_address" id="txt_address"><?php echo $address; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_cont1">Contact1 <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_cont1" name="txt_cont1" class="inpText" value="<?php echo $cont1; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_cont2">Contact2 <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_cont2" name="txt_cont2" class="inpText" value="<?php echo $cont2; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_cont3">Contact3 <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_cont3" name="txt_cont3" class="inpText" value="<?php echo $cont3; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_cont4">Contact4 <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_cont4" name="txt_cont4" class="inpText" value="<?php echo $cont4; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_fax1">Fax1 <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_fax1" name="txt_fax1" class="inpText" value="<?php echo $fax1; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_fax2">Fax2 <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_fax2" name="txt_fax2" class="inpText" value="<?php echo $fax2; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_fax3">Fax3 <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_fax3" name="txt_fax3" class="inpText" value="<?php echo $fax3; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_fax4">Fax4 <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_fax4" name="txt_fax4" class="inpText" value="<?php echo $fax4; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_email">Email <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_email" name="txt_email" class="inpText" value="<?php echo $email; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_owner">Owner <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_owner" name="txt_owner" class="inpText" value="<?php echo $owner; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                &nbsp;
                            </td>
                            <td class="control_cell">
                                <input type="submit" id="frm_add_state_submit" name="submit" class="myButton" value="Update" />
                            </td>
                        </tr>
                    </table>
                    <div class="upload-image-sections">
                        <div class="upload-image-logo">
                            <div class="upload-section">
                                <div class="upload-image-logo-preview">
                    				<img id="upload-image-logo-thumb" width="120px" height="100px" src="<?php echo $default_logo_path; ?>" />
                				</div>
                                <div class="upload-section-file">
            						<label>Upload Your Institute Logo</label>
            						<div class="myButton" id="btnUploadLogo">Choose Logo</div>
                                    <label class="best-size">best size : 100px x 120px</label>
                    			</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once(LAYOUT.THEME.DS.'layout'.DS.'footer.php'); ?>
    </div>
</body>
</html>