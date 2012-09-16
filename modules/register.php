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
    <title>Property - Registration</title>
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'style_sheet.php');
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'javascript.php');
    ?>   
    <script type="text/javascript">
 $(document).ready(function() {
    var validator = $("#frm_add_registration").validate({
    		rules: {
    			txt_username: "required",
                txt_name: "required",
                txt_email: {
                				required: true,
                				email: true
                			},
                txt_password: {
                            required:true,
                            minlength:6
                            },
                
                txt_confirm_password: {
                            required:true,
                            equalTo:"#txt_password"
                            },
                
                txt_dateofbirth:"required",
                txt_mobile:{
                            required:true,
                            rangelength:[10,10],
                            number:true                            
                            },
                txt_landline:{
                            required:true,                            
                            number:true                            
                            },
                txt_area_code:{
                            required:true,                           
                            number:true                            
                            },
                ddl_state: "required",
                captcha:"required",
                ddl_city: "required" ,
                member_type: "required" ,
                gender:"required"              
    		},
    		messages: {
    		    txt_name: "Please enter valid name",
                txt_username: "Please enter valid username",
                txt_email: "Please enter valid email",
                txt_password: {required :"Please enter password",minlength:"Password must be greater than 6 digit"},
                txt_confirm_password: {required:"Please enter confirm password",equalTo:"Password and confirm password must be same"},
                txt_dateofbirth:"Please enter date of birth",
                txt_mobile:{required :"Please enter mobile no ",rangelength:"invalid mobile no" ,number:"invalid mobile no "},
                txt_landline:{required :"Please enter landline no ",number:"invalid landline no "},
                txt_area_code:{required :"Please enter area code",number:"invalid area code"},
                ddl_state: "Please enter state",
                ddl_city: "Please enter city",
                member_type: "Please select user type",
                gender: "Please select gender",
                captcha:"Please enter appropriate Chaptcha to continue",
    		}
    	});
    $("#txt_dateofbirth").datepicker();
});
    
    function getState(objState,objCity){
        var objState1 = $(objState);
        var objCity1 = $(objCity);
        var option1 = '<option value="">Please select</option>';
        var option2 = '<option value="">Please select</option>';
        var val1 = objState1.val();
        if(val1==null||val1==""||val1=="undefined"){
            objCity1.html(option2);
        }
        else{
            objCity1.html('<option value="">Loading... </option>');
            $.ajax(
            {
                    url: "../common/get_city.php",
                    cache: false,
                    data: "id="+val1,
                    success: function(data){
                        option = option1;
                        for(var i = 0; i < data.length; i++){
                            option +='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                        }
                        objCity1.html(option);
                    }
            });
        }
    }
</script>
</head>
<body>
    <div id="header">
     <?php
                 include_once(LAYOUT.'template'.DS.'layout'.DS.'header.php');
     ?>
    <?php
        $username = "";$email = "";$gender =""; $user_type="";$name ="";$password = ""; $dateofbirth = ""; $mobile = ""; $landline ="";$area_code = "";  $city ="";
        if (isset($_POST['submit'])) {
            $username = $_POST['txt_username'];
            $email = $_POST['txt_email'];
            $name = $_POST['txt_name'];
            $password = md5($_POST['txt_password']);
            $dateofbirth = $_POST['txt_dateofbirth'];
            $mobile = $_POST['txt_mobile'];
            $landline = $_POST['txt_landline'];
            $area_code = $_POST['txt_area_code'];
            $city = $_POST['ddl_state'];
            $gender = $_POST['gender'];
            $user_type = $_POST['member_type'];
           // if (empty($_SESSION['captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['captcha']) {
            //     $startup_scripts .= "showError('Please enter appropriate Chaptcha to continue');";
           // }else 
            if(!empty($email)){
                $sql = "SELECT 1 FROM `users_usr` WHERE `email_usr` = :email;";
                if($db->queryPrepared($sql,array(':email' => $email))->rowCount()>0){
                    $startup_scripts .= "showError('Email already exists');";
                } 
               else  if(!empty($username)){
                $sql = "SELECT 1 FROM `users_usr` WHERE `username_usr` = :username;";
                if($db->queryPrepared($sql,array(':username' => $username))->rowCount()>0){
                    $startup_scripts .= "showError('Username already exists');";
                } 
              
              else  if((!empty($username))&&(!empty($email))&&(!empty($name))){
              
                    $sql = "INSERT INTO `users_usr`(`username_usr`,`password_usr`,`name_usr`,`id_cit_usr`,`dob_usr`,`gender_usr`,`email_usr`,`mobile_usr`,`std_usr`,`landline_usr`,`type_usr`,`logo_usr`,`website_usr`,`about_usr`,`is_active`,`created_by`,`created_at`)".
                        "VALUES (:username,:password,:name,5,:dateofbirth,:gender,:email,:mobile,:area_code,:landline,:user_type,'hello','hiii','howzu',1,0,now());";
                    $db->queryPrepared($sql,array(':username' => $username,':password' => $password,':name' => $name,':dateofbirth' => $dateofbirth,':gender' => $gender,':email' => $email,':mobile' => $mobile,':area_code' => $area_code,':landline' => $landline,':user_type' => $user_type))->rowCount();
                    $username = "";$email = "";$gender =""; $user_type="";$name ="";$password = ""; $dateofbirth = ""; $mobile = ""; $landline ="";$area_code = "";  $city ="";
                    

                    
                    $startup_scripts .= "showSucc('User has been registered  successfully');";
                
            }
            }
            }
            else{
                $startup_scripts .= "showError('Please enter appropriate values to continue');";
            }
            
        }
       
    ?>
    </div>
    <?php include_once(CONTENT.'follow_us.php'); ?>
    <div class="content-box">
        <div class="content-box-header">
            <h3>Enter Registration Details </h3>
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
            <form method="post" name="frm_add_registration"  enctype="multipart/form-data" id="frm_add_registration" accept="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="form_table">
                <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_username">Select Profile <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="radio" value="Individual" checked="checked" name="member_type" <?php if($user_type=="Individual") print "checked='checked'";?>  />
                            <span>Individual</span>
                            <input type="radio" value="Agent" name="member_type" <?php if($user_type=="Agent") print "checked='checked'";?>  />
                            <span>Agent </span>
                            <input type="radio" value="Builder" name="member_type" <?php if($user_type=="Builder") print "checked='checked'";?>  />
                            <span>Builder</span>

                        </td>
                       
                    </tr>                
                
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_name">Name <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_name" name="txt_name" value="<?php $username ?>" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_email">Email <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_email" name="txt_email" value="<?php $email ?>" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_username">Username <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_username" name="txt_username" value="<?php $name ?>" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_password">Password <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="password" id="txt_password" name="txt_password" class="inpText" />
                        </td>
                    </tr>

                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_confirm_password">Confirm Password <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="password" id="txt_confirm_password" name="txt_confirm_password" class="inpText" />
                        </td>
                    </tr>


                    
                     <tr>
                    	<td class="label_cell">
                            <label class="lblStyle">State<span class="star">*</span> :</label>
                        </td>
                        <td class="control_cell">
                            <select class="dropList" id="ddl_state" name="ddl_state" onchange="getState('#ddl_state','#ddl_city');">
                            	<option value="">Please select</option>
                                
                                <?php
                                 $sql_state = "SELECT  `id_sta` AS `id`, `name_sta` AS `name` FROM `states_sta` WHERE `is_active` =1;";
                                    $data = $db->fetchQueryPrepared($sql_state,array());
                                    if(!empty($data)){
                                        foreach ($data as $states=>$value) {
                                            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle">City<span class="star">*</span> :</label>
                        </td>
                        <td class="control_cell">
                            <select class="dropList" id="ddl_city" name="ddl_city">
                            	<option value="">Please select</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_dateofbirth">Date Of Birth  <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input id="txt_dateofbirth" type="text" name="txt_dateofbirth"  value="<?php $dateofbirth?>" class="inpText"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_gender">Gender <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="radio" value="male" name="gender" <?php if($gender=="male") print "checked='checked'";?>  checked="checked"/>
                            <span>Male</span>
                            <input type="radio" value="female" name="gender" <?php if($gender=="female") print "checked='checked'";?>  />
                            <span>Female </span>
                        </td>
                       
                    </tr> 
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_mobile">Mobile No  <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_mobile" name="txt_mobile" value="<?php $mobile?>" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_landline,txt_area_code">Landline No  <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_area_code" name="txt_area_code" value="<?php $area_code?>" style="width:30px;" class="inpText"  />
                            <input type="text" id="txt_landline" name="txt_landline" value="<?php $landline?>" class="inpText" style="width:160px;"/>
                        </td>
                    </tr>
                    <tr>
                    <td class="label_cell">
                            
                    </td>
                    <td class="control_cell">
                            <label class="lblStyle" style="font-size:10px;font-style: italic; " for="txt_area_code,txt_landline">Area Code &amp; Landline</label>
                        </td>
                    
                    </tr>
                    <tr> 
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_captcha">Enter the word<span class="star">*</span> : </label>
                        </td>
                    <td>
                    <img src="../common/captcha/captcha.php" id="captcha" />
                    	<a onclick="document.getElementById('captcha').src='../common/captcha/captcha.php?'+Math.random();document.getElementById('captcha-form').focus();" id="change-image" style="cursor: pointer;">
                            <img src="../themes/template/images/refresh.png" border="0" align="bottom" />
                        </a>
                        <br/>
                        <br/>
                        <input type="text" name="captcha" id="captcha-form"/></td>
                    </tr>
                    
                    <tr>
                    	<td>
                            &nbsp;
                        </td>
                        <td>
                            <input type="submit" id="frm_add_registration_submit" name="submit" class="myButton" />
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
        include_once(LAYOUT.'template'.DS.'layout'.DS.'footer.php');
    ?>
</div>
</body>
</html>