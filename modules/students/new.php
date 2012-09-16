<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
     require_once(LIB.'db.php');
?>
<head>
    <meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="Sunil Gautam" />
    <title>New student | <?php echo INSTITUTE; ?></title>
    <?php
        include_once(LAYOUT.THEME.DS.'layout'.DS.'style_sheet.php');
        include_once(LAYOUT.THEME.DS.'layout'.DS.'javascript.php');
    ?>
    <script src="/themes/<?php echo THEME;?>/javascripts/ajaxupload.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                $( "#txt_dob" ).datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: 'c-40:c'
                });
            });
                   
            var validator = $("#frm_new_student").validate({
                rules: {
                    txt_fname: "required",
                    txt_lname: "required",
                    txt_pname: "required",
                    txt_poccupation: "required",
                    txt_dob:    {
                                    required: true
                                },
                    txt_address: "required",
                    ddl_std: "required",
                    ddl_medium: "required",
                    txt_email:  {
                                    email: true
                                }
                },
                messages: {
                    txt_fname: "Please enter first name",
                    txt_lname: "Please enter last name",
                    txt_pname: "Please enter parent name",
                    txt_poccupation: "Please enter parent occupation",
                    txt_dob:    {
                                    required: "Please enter dob (dd/mm/yyyy)"
                                },
                    txt_address: "Please enter address",
                    ddl_std: "Please select standard",
                    ddl_medium: "Please select medium",
                    txt_email:  {
                                    email: "Invalid email address"
                                }
                }
            });
            
            var thumbProfile = $('#upload-image-profile-thumb');

            new AjaxUpload('btnUploadProfile', {
                action: '<?php echo DOMAIN ?>modules/save_profile.php',
                name: 'img_upload',
                responseType: 'json',
                onSubmit: function(file, extension) {
                    if (! (extension && /^(jpg|png|jpeg|gif|JPG|JPEG)$/.test(extension))){ 
                        // extension is not allowed 
                        showError('Only JPG, PNG or GIF files are allowed');
                        return false;
                    }
                    $('.upload-image-profile-preview').addClass('big-loading').children('img').css('display','none');
                },
                onComplete: function(file, response) {
                    thumbProfile.load(function(){
                        $('.upload-image-profile-preview').removeClass('big-loading').children('img').css('display','block');
                        thumbProfile.unbind();
                    });
                    if(response.RESULT == 'SUCCESS') {
                        thumbProfile.attr('src', response.THUMB);
                        $('#image_path').val(response.RESOURCE);
                        $('#thumb_path').val(response.THUMB);
                    }
                    else {
                        $('.upload-image-profile-preview').removeClass('big-loading').children('img').css('display','block');
                        thumbProfile.unbind();
                    }
                }
            });
        });
    </script>
</head>
<body>
    <div id="header" class="completeWidth">
        <?php include_once(LAYOUT . THEME . DS . 'layout' . DS . 'header.php'); ?>
        <?php
            require_once(COMMON . 'Utils.php');
            
            //VARIABLES
            function init_vars()
            {
                global $stud_id , $fname , $mname , $lname , $parent_name , $parent_occu , $gender, $dob , $address , $email;
                global $std , $phone , $mobile , $standard_adm , $medium , $fees_p , $image_path , $thumb_path , $sub1 , $mark1;
                global $sub2 , $mark2 , $sub3 , $mark3 , $sub4 , $mark4 , $sub5 , $mark5 , $sub6 , $mark6 , $sub7 , $mark7 ;

                $stud_id = '';
                $fname = '';
                $mname = '';
                $lname = '';
                $parent_name = '';
                $parent_occu = '';
                $gender = 'Male';
                $dob = '';
                $address = '';
                $email = '';
                $std = '';
                $phone = '';
                $mobile = '';
                $standard_adm = '';
                $medium = '';
                $fees_p= 'M';
                $image_path = '';
                $thumb_path = '/images/student/thumbnails/default-m.png';
                $sub1 = '';
                $mark1 = '';
                $sub2 = '';
                $mark2 = '';
                $sub3 = '';
                $mark3 = '';
                $sub4 = '';
                $mark4 = '';
                $sub5 = '';
                $mark5 = '';
                $sub6 = '';
                $mark6 = '';
                $sub7 = '';
                $mark7 = '';
            }
            
            init_vars();
            
            //LOAD STANDARDS
            $sql_standard = "SELECT `id_std`, `name_std` FROM `standards_std` WHERE  `is_used_std` = 1 AND `is_active` = 1;";
            $data_std = $db->fetchQuery($sql_standard ,false);
            
            //LOAD MEDIUMS
            $sql_medium = "SELECT `id_med`, `name_med` FROM `mediums_med` WHERE `is_active` = 1;";
            $data_medium = $db->fetchQuery($sql_medium ,false);
            
            //FORM PROCESSING
            if (isset($_POST['submit'])) {
                $fname = $_POST['txt_fname'];
                $mname = $_POST['txt_mname'];
                $lname = $_POST['txt_lname'];
                $parent_name = $_POST['txt_pname'];
                $parent_occu = $_POST['txt_poccupation'];
                $gender = $_POST['chk_gender'];
                $dob = $_POST['txt_dob'];
                $address = $_POST['txt_address'];
                $email = $_POST['txt_email'];
                $std = $_POST['txt_std'];
                $phone = $_POST['txt_phone'];
                $mobile = $_POST['txt_mob'];
                $standard_adm = $_POST['ddl_std'];
                $medium = $_POST['ddl_medium'];
                $fees_p = $_POST['chk_fp'];
                $image_path = $_POST['image_path'];
                $thumb_path = $_POST['thumb_path'];
                $sub1 = $_POST['txt_ar_s1'];
                $mark1 = $_POST['txt_ar_m1'];
                $sub2 = $_POST['txt_ar_s2'];
                $mark2 = $_POST['txt_ar_m2'];
                $sub3 = $_POST['txt_ar_s3'];
                $mark3 = $_POST['txt_ar_m3'];
                $sub4 = $_POST['txt_ar_s4'];
                $mark4 = $_POST['txt_ar_m4'];
                $sub5 = $_POST['txt_ar_s5'];
                $mark5 = $_POST['txt_ar_m5'];
                $sub6 = $_POST['txt_ar_s6'];
                $mark6 = $_POST['txt_ar_m6'];
                $sub7 = $_POST['txt_ar_s7'];
                $mark7 = $_POST['txt_ar_m7'];
                
                if(check_fields($fname, $lname, $parent_name, $parent_occu, $gender, $dob, $address, $standard_adm, $medium, $fees_p)){
                    if(checkDateFormate($dob)) {
                        $sql_student = "INSERT INTO `students_stu`
                                (`id_usr_stu`, `fname_stu`, `mname_stu`, `lname_stu`, `parent_stu`, `parent_occupation_stu`, `gender_stu`,
                                `dob_stu`, `address_stu`, `email_stu`, `id_adm_std_stu`, `id_curr_std_stu`, `id_med_stu`, `mobile_stu`, `std_stu`,
                                `landline_stu`, `fees_mode_stu`, `image_stu`, `thumb_stu`, `is_active`, `created_by`, `created_at`) VALUES
                                (0, :fname, :mname, :lname, :parent_name, :parent_occu, :gender, STR_TO_DATE(:dob, '%d/%m/%Y'), :address, :email, :standard_adm, :standard_adm,
                                :medium, :mobile, :std, :phone, :fees_p, :image_stu, :thumb_stu, 1, 0, now())";
                        $sql_student_array = array(
                                            ':fname' => $fname, ':mname' => $mname,
                                            ':lname' => $lname, ':parent_name' => $parent_name,
                                            ':parent_occu' => $parent_occu, ':gender' => $gender,
                                            ':dob' => $dob, ':address' => $address,
                                            ':email' => $email, ':standard_adm' => $standard_adm,
                                            ':medium' => $medium, ':mobile' => $mobile,
                                            ':std' => $std, ':phone' => $phone,
                                            ':fees_p' => $fees_p ,':image_stu' => $image_path,
                                            ':thumb_stu' => $thumb_path,
                                            );
                        
                        if($db->queryPrepared($sql_student, $sql_student_array, false, true, 'students_stu')){
                            $stud_id = $db->last_id;
                            $sql_spar = "INSERT INTO `previous_record_spr`
                                        (`stu_id`, `subject_spr`, `marks_spr`, `is_active`, `created_by`, `created_at`) VALUES
                                        (:stud_id, :sub1, :mark1, 1, 0, now()),
                                        (:stud_id, :sub2, :mark2, 1, 0, now()),
                                        (:stud_id, :sub3, :mark3, 1, 0, now()),
                                        (:stud_id, :sub4, :mark4, 1, 0, now()),
                                        (:stud_id, :sub5, :mark5, 1, 0, now()),
                                        (:stud_id, :sub6, :mark6, 1, 0, now()),
                                        (:stud_id, :sub7, :mark7, 1, 0, now());";
                            $sql_spar_array = array(
                                            ':stud_id' => $stud_id,
                                            ':sub1' => $sub1, ':mark1' => $mark1,
                                            ':sub2' => $sub2, ':mark2' => $mark2,
                                            ':sub3' => $sub3, ':mark3' => $mark3,
                                            ':sub4' => $sub4, ':mark4' => $mark4,
                                            ':sub5' => $sub5, ':mark5' => $mark5,
                                            ':sub6' => $sub6, ':mark6' => $mark6,
                                            ':sub7' => $sub7, ':mark7' => $mark7,
                                            );
                            if($db->queryPrepared($sql_spar, $sql_spar_array, false)){
                                $startup_scripts .= "showSucc('Student added successfully');";
                                init_vars();
                            }
                            else {
                                $startup_scripts .= "showError('Unable to add student');";
                            }
                        }
                        else {
                            $startup_scripts .= "showError('Unable to add student');";
                        }
                    }
                    else {
                        $startup_scripts .= "showError('Invalid dob should be in dd/mm/yyyy');";
                    }
                }
                else {
                    $startup_scripts .= "showError('Please enter all required fields');";
                }
            }
            
            function check_fields(&$fname, &$lname, &$parent_name, &$parent_occu, &$gender, &$dob, &$address, &$standard_adm, &$medium, &$fees_p){
                if (empty($fname) || empty($lname) || empty($parent_name) || empty($parent_occu) || empty($gender) || empty($dob) || empty($address) || empty($standard_adm) || empty($medium) || empty($fees_p)){
                    return false;
                }
                else {                  
                    return true;
                }
            }
            
            $db->closeCon();
        ?>
    </div>
    <?php include_once(LAYOUT . THEME . DS . 'layout' . DS . 'students' . DS . 'submenu.php'); ?>
    <div id="content">
        <div class="content-box">
            <div class="content-box-header">
                <h3>Add new student</h3>
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
                <form method="post" name="frm_new_student" id="frm_new_student" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table class="form_table">
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_fname">First Name <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_fname" name="txt_fname" class="inpText" value="<?php echo $fname; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_mname">Middle Name <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_mname" name="txt_mname" class="inpText" value="<?php echo $mname; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_lname">Last Name <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_lname" name="txt_lname" class="inpText" value="<?php echo $lname; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_pname">Parent Name <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_pname" name="txt_pname" class="inpText" value="<?php echo $parent_name; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_poccupation">Parent Occupation <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_poccupation" name="txt_poccupation" class="inpText" value="<?php echo $parent_occu; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="">Gender <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="radio" id="chk_gender_m" name="chk_gender" value="Male" <?php if($gender=='Male') echo 'checked="checked"'; ?> />
                                <label class="lblStyle" for="chk_gender_m">Male</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="chk_gender_f" name="chk_gender" value="Female" <?php if($gender=='Female') echo 'checked="checked"'; ?> />
                                <label class="lblStyle" for="chk_gender_f">Female</label>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_dob">DOB (dd/mm/yyyy) <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_dob" name="txt_dob" class="inpText" value="<?php echo $dob; ?>" />
                            </td>
                        </tr>
                        <tr valign="top">
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_address">Residential Address <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <textarea cols="40" rows="6" style="resize:auto; overflow: auto;" class="inpText" name="txt_address" id="txt_address"><?php echo $address; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_email">Email <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_email" name="txt_email" class="inpText" value="<?php echo $email; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_std">Phone No <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_std" name="txt_std" class="inpText" style="width: 40px;" value="<?php echo $std; ?>" />
                                <input type="text" id="txt_phone" name="txt_phone" class="inpText" style="width: 146px;" value="<?php echo $phone; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="txt_mob">Mobile <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="text" id="txt_mob" name="txt_mob" class="inpText" value="<?php echo $mobile; ?>" />
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="ddl_std">Admission For <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <select class="dropList" id="ddl_std" name="ddl_std">
                            	<option value="">---------------- Select ----------------</option>
                                <?php
                                    foreach($data_std as $val)
                                    {
                                ?>                                   
                                    <option value="<?php echo $val['id_std'];?>" <?php if($val['id_std']==$standard_adm) echo 'selected="selected"'; ?> ><?php echo $val['name_std'];?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="ddl_medium">Medium <span class="star">*</span> :</label>
                            </td>
                            <td class="control_cell">
                                <select class="dropList" id="ddl_medium" name="ddl_medium">
                            	<option value="">---------------- Select ----------------</option>
                                <?php
                                    foreach($data_medium as $val)
                                    {
                                ?>                                   
                                    <option value="<?php echo $val['id_med'];?>" <?php if($val['id_med']==$medium) echo 'selected="selected"'; ?> ><?php echo $val['name_med'];?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                <label class="lblStyle" for="">Fees Payable <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <input type="radio" id="chk_fp_l" name="chk_fp" value="L" <?php if($fees_p=='L') echo 'checked="checked"'; ?> />
                                <label class="lblStyle" for="chk_fp_l">Lumsum</label>
                                &nbsp;&nbsp;
                                <input type="radio" id="chk_fp_m" name="chk_fp" value="M" <?php if($fees_p=='M') echo 'checked="checked"'; ?> />
                                <label class="lblStyle" for="chk_fp_m">Monthly</label>
                                &nbsp;&nbsp;
                                <input type="radio" id="chk_fp_f" name="chk_fp" value="F" <?php if($fees_p=='F') echo 'checked="checked"'; ?> />
                                <label class="lblStyle" for="chk_fp_f">Full</label>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell" valign="top">
                                <label class="lblStyle" for="txt_ar_s1">Academic Record <span class="star">&nbsp;</span> :</label>
                            </td>
                            <td class="control_cell">
                                <table>
                                    <tr>
                                        <td align="center">
                                            <label class="lblStyle" for="txt_ar_s1">Subject</label>
                                        </td>
                                        <td align="center">
                                            <label class="lblStyle" for="txt_ar_m1">Marks</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="lblStyle" for="txt_ar_s1">1) </label>
                                            <input type="text" id="txt_ar_s1" name="txt_ar_s1" class="inpText" style="width: 120px;" value="" />
                                        </td>
                                        <td>
                                            <input type="text" id="txt_ar_m1" name="txt_ar_m1" class="inpText" style="width: 50px;" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="lblStyle" for="txt_ar_s2">2) </label>
                                            <input type="text" id="txt_ar_s2" name="txt_ar_s2" class="inpText" style="width: 120px;" value="" />
                                        </td>
                                        <td>
                                            <input type="text" id="txt_ar_m2" name="txt_ar_m2" class="inpText" style="width: 50px;" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="lblStyle" for="txt_ar_s3">3) </label>
                                            <input type="text" id="txt_ar_s3" name="txt_ar_s3" class="inpText" style="width: 120px;" value="" />
                                        </td>
                                        <td>
                                            <input type="text" id="txt_ar_m3" name="txt_ar_m3" class="inpText" style="width: 50px;" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="lblStyle" for="txt_ar_s4">4) </label>
                                            <input type="text" id="txt_ar_s4" name="txt_ar_s4" class="inpText" style="width: 120px;" value="" />
                                        </td>
                                        <td>
                                            <input type="text" id="txt_ar_m4" name="txt_ar_m4" class="inpText" style="width: 50px;" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="lblStyle" for="txt_ar_s5">5) </label>
                                            <input type="text" id="txt_ar_s5" name="txt_ar_s5" class="inpText" style="width: 120px;" value="" />
                                        </td>
                                        <td>
                                            <input type="text" id="txt_ar_m5" name="txt_ar_m5" class="inpText" style="width: 50px;" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="lblStyle" for="txt_ar_s6">6) </label>
                                            <input type="text" id="txt_ar_s6" name="txt_ar_s6" class="inpText" style="width: 120px;" value="" />
                                        </td>
                                        <td>
                                            <input type="text" id="txt_ar_m6" name="txt_ar_m6" class="inpText" style="width: 50px;" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="lblStyle" for="txt_ar_s7">7) </label>
                                            <input type="text" id="txt_ar_s7" name="txt_ar_s7" class="inpText" style="width: 120px;" value="" />
                                        </td>
                                        <td>
                                            <input type="text" id="txt_ar_m7" name="txt_ar_m7" class="inpText" style="width: 50px;" value="" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td class="label_cell">
                                &nbsp;
                            </td>
                            <td class="control_cell">
                                <input type="submit" id="frm_add_state_submit" name="submit" class="myButton" value="Save" />
                            </td>
                        </tr>
                    </table>
                    <div class="upload-image-sections">
                        <div class="upload-image-profile">
                            <div class="upload-section">
                                <div class="upload-image-profile-preview">
                    				<img id="upload-image-profile-thumb" width="100px" height="100px" src="<?php echo $thumb_path; ?>" />
                				</div>
                                <div class="upload-section-file">
            						<label>&nbsp;&nbsp; Upload Student Image &nbsp;&nbsp;</label>
                                    <input type="hidden" id="image_path" name="image_path" value="<?php echo $image_path; ?>" />
                                    <input type="hidden" id="thumb_path" name="thumb_path" value="<?php echo $thumb_path; ?>" />
            						<div class="myButton" id="btnUploadProfile">Choose Image</div>
                                    <label class="best-size">best size : 100px x 100px</label>
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