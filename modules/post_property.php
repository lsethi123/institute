<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
     require_once(LIB.'db.php');
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Sandip Karanjekar" />
    <meta name="developed by" content="Tech Schema" />
    <meta name="website" content="Property Vihar" />
    <title>Property - registration</title>
    <?php
         include_once(LAYOUT.'template'.DS.'layout'.DS.'javascript.php');
         include_once(LAYOUT.'template'.DS.'layout'.DS.'style_sheet.php');
    ?>
    <style type="text/css">
    .property_step{
        font-size: 20px;
        margin-left: 5px;
        color: #BCBCBC;
    }
    </style>
    <script type="text/javascript">
             $(document).ready(function() {
                         //date picker in jquery ui
                         $("#txt_dateofbirth").datepicker();
        
                        //login form toggle on radio button
                         $("input[name$='rdo_isUser']").click(function() {
                                                var visible = $(this).val();
                                                if(visible == "existing_user"){
                                                      $("#existing_user").show();
                                                      $("#frm_post_property :input").attr("disabled", true);
                                                }
                                                else{
                                                      $("#existing_user").hide();
                                                }
                          });
        
                          //ajax request for login and validate
                          $("#login_sub").click(function() {
                                                var action = $("#login").attr('action');
	                                          	var form_data = {
			                                                     username: $("#username").val(),
			                                                     password: $("#password").val(),
                                                                 is_ajax: 1
	                                                         	};
                                                                $.ajax({
		                                                                 type: "POST",
			                                                             url: action,
			                                                             data: form_data,
			                                                             success: function(response)
			                                                             {
				                                                            if(response == 'true')
                                                                            {
					                                                          $("#isUser").slideUp('slow', function() {
					                                                          });
                                                                               $("#sub_nav").load('follow_us.php');
                                                                               $("#frm_post_property :input").attr("disabled", false);
                                                                               location.reload();  
                                                                            }
				                                                            else
                                                                                if(response == 'blank')
					                                                               $("#message").html("<p>Username or password should not be blank.</p>");
                                                                                else
                                                                                   $("#message").html("<p>Username or password incorrect.</p>");      
                                                                          }
		                                                         });
                                               return false;
                                               });  
             });
             function limitText(limitField,limitCount,limitNum){if(limitField.value.length>limitNum){limitField.value=limitField.value.substring(0,limitNum);}else{limitCount.value=limitNum-limitField.value.length;}}
             
              //dynamic selection of state and city
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
                                       objCity1.html('<option value="">Loading...</option>');
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
                         
              //form for wizard - post property
             $(function(){
			            	$("#frm_post_property").formwizard({ 
				        	                  validationEnabled: true,
                                              validationOptions:{
                                                                 rules:{
                                                                          ddl_property_type: "required",
                                                                          txt_address: "required",
                                                                          ddl_total_floring: "required",
                                                                          ddl_age_of_construction: "required",
                                                                          ddl_floor_no: "required",
                                                                          ddl_bed_rooms: "required",
                                                                          ddl_bath_rooms: "required",
                                                                          txt_total_price:{
                                                                                   required: true,
                                                                                   number: true
                                                                          },
                                                                          txt_sft_area:{
                                                                                   required: true,
                                                                                   number: true
                                                                          },
                                                                          ddl_furnished: "required",
                                                                          ddl_ownership: "required",
                                                                          txt_description: "required",
                                                                          ddl_state: "required",
                                                                          ddl_city: "required",
                                                                          ddl_facing: "required",
                                                                          chk_amenities:{
                                                                                required: true,
                                                                                minlength: 2
                                                                          }
                                                                          
                                                                 },
                                                                 messages:{
                                                                           ddl_property_type: "Please select property type.",
                                                                           txt_address: "Please enter property address.",
                                                                           ddl_total_floring: "Please select total flooring in building.",
                                                                           ddl_age_of_construction: "Please select age of construction.",
                                                                           ddl_floor_no: "Please select floor number.",
                                                                           ddl_bed_rooms: "Please select bed rooms.",
                                                                           ddl_bath_rooms: "Please select bath rooms.",
                                                                           txt_total_price:{
                                                                                   required: "Please enter total price of property.",
                                                                                   number: "Invalid total price of property."
                                                                           },
                                                                           txt_sft_area:{
                                                                                   required: "Please enter area of property.",
                                                                                   number: "Invalid area of property."
                                                                           },
                                                                           ddl_furnished: "Please select about property furnishing.",
                                                                           ddl_ownership: "Please select ownership type.",
                                                                           txt_description: "Please enter the description.",
                                                                           ddl_state: "Please select state.",
                                                                           ddl_city: "Please select city.",
                                                                           ddl_facing: "Please select facing."
                                                                  }
                                              }
                           
				             });
	        });
            
            //show rate per sft
            $(function(){
                         $("#txt_total_price").change(function(){
                             var total_price=$(this).val();
                             var sft_area=$("#txt_sft_area").val();
                             if(sft_area > 0 && total_price > 0)
                             {
                                var rate=Math.round(total_price/sft_area);
                                $("#txt_rate").attr('disabled','disabled');
                                $("#txt_rate").val(rate + " sq.ft.");
                             }
                        });
            });
            $(function(){
                         $("#txt_sft_area").change(function(){
                             var sft_area=$(this).val();
                             var total_price=$("#txt_total_price").val();
                             if(sft_area > 0 && total_price > 0)
                             {
                                var rate=Math.round(total_price/sft_area);
                                $("#txt_rate").attr('disabled','disabled');
                                $("#txt_rate").val(rate + " sq.ft.");
                             }
                        });
            });
            $(function(){
                         if($('#new_isUser').is(':checked'))
                          {
                             $("#formWrapper").append($("#register .step"));
 				             $("#frm_post_property").formwizard("update_steps");
					         return false;
                          }
            });
            $(function(){
                         $("#next").click(function(){
					     $("#isUser").hide();
				     });

            });
</script>
</head>
<body>
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
               <h3>Post property Details </h3>
          </div>
          <div class="content-box-content">
               <?php
                    if (! isset($_SESSION['user']))
                   {
                   ?>
                     <div id="isUser">
                          <input type="radio" value="new_user" name="rdo_isUser" id="new_isUser" checked="checked"/>
                          <span>New user</span>
                          <input type="radio" value="existing_user" name="rdo_isUser" id="exist_isUser" />
                          <span>Existing user </span>
                          <div id="existing_user" style="display: none;">
                               <form action="auth.php" method="post" name="login" id="login">
                                      <table>
                                              <tr>
                                                   <td><label class="lable_name">Username :</label></td>
                                                   <td><input class="text_box" type="text" name="username" id="username"/></td>
                                                   <td><label class="lable_name">Password :</label></td>
                                                   <td><input class="text_box" type="password" name="password" id="password"/></td>
                                                   <td><input  type="submit" value="Submit" id="login_sub" class="myButton"/></td>
                                                   <td><input  type="reset" value="Clear" class="myButton"/></td>
                                              </tr>
                                      </table>                 
                               </form>
                               <div id="message">
                               </div>
                         </div>
                     </div>
                  <?php
                   } ?>
                                     
          </div>
          <form method="post" name="frm_post_property" id="frm_post_property" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div id="formWrapper">
                <span class="step" id="first">
                    <span class="property_step">First step >> Property details</span><br />
                    <table>
                            <tr>
                                 <td class="label_cell">
                                      <label class="lblStyle" for="rdo_property_for">Post property for<span class="star">*</span> : </label>
                                 </td>
                                 <td class="control_cell">
                                      	<input type="radio" value="0" name="rdo_property_for" checked="checked" />
                                        <span>Sell</span>
                                        <input type="radio" value="1" name="rdo_property_for"  />
                                        <span>Rent </span>
                                        <input type="radio" value="2" name="rdo_property_for"  />
                                        <span>PG </span>  
                                 </td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                       <label class="lblStyle" for="ddl_property_type">Property type<span class="star">*</span> : </label>  
                                </td>
                                <td class="control_cell">
                                        <select class="dropList" id="ddl_property_type" name="ddl_property_type">
                                                <option value="">Please select</option>
                                                <option value="New project">New project</option>
                                                <option value="Residential apartment">Residential apartment</option>
                                                <option value="Independent/Builder floor">Independent/Builder floor</option>
                                                <option value="Residential land">Residential land</option>
                                                <option value="All residential">All residential</option>
                                                <option value="Independent house/villa">Independent house/villa</option>
                                                <option value="Studio apartment">Studio apartment</option>
                                                <option value="Farm house">Farm house</option>
                                                <option value="Serviced apartment">Serviced apartment</option>
                                                <option value="Other">Other</option>
                                                <option value="All commerrcial">All commerrcial</option>
                                                <option value="Commercial shop">Commercial shop</option>
                                                <option value="Commercial showrooms">Commercial showrooms</option>
                                                <option value="Commerrcial office/space">Commerrcial office/space</option>
                                                <option value="Commercial land/industrial land">Commercial land/industrial land</option>
                                                <option value="Hotel/resorts">Hotel/resorts</option>
                                                <option value="Guest house/banquet-hall">Guest house/banquet-hall</option>
                                                <option value="Time share">Time share</option>
                                                <option value="Space in retail mall">Space in retail mall</option>
                                                <option value="Office in business park">Office in business park</option>
                                                <option value="Öffice in IT park">Öffice in IT park</option>
                                                <option value="Ware house">Ware house</option>
                                                <option value="Cold storage">Cold storage</option>
                                                <option value="Factory">Factory</option>
                                                <option value="Manufacturing">Manufacturing</option>
                                                <option value="Business center">Business center</option>
                                                <option value="New project">New project</option>
                                                <option value="Land">Land</option>
                                                <option value="Residential land">Residential land</option>
                                                <option value="Agricultural land">Agricultural land</option>
                                                <option value="Commercial/Industerial land">Commercial/Industerial land</option>
                                               <option value="Industerial land/plot">Industerial land/plot</option>
                                         </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="ddl_total_floring">Total flooring in building<span class="star">*</span> : </label>
                                </td>
                                <td>
                                     <select class="dropList" id="ddl_total_floring" name="ddl_total_floring">
                                      <option value="">Please select</option>
                                      <option value="Under construction">Under construction</option>
                                      <option value="Basement">Basement</option>
                                      <option value="Ground floor">Ground floor</option>
                                      <option value="Mezzanine floor">Mezzanine floor</option>
                                      <?php
                                      for($i=1;$i<=40;$i++)
                                      {
                                      ?>
                                         <option value="<?php echo $i?>"><?php echo $i?></option>
                                      <?php } ?>
                                      <option value="40+">40+</option>     
                                      </select>
                                 </td>
                            </tr>       
                            <tr>
                                 <td class="label_cell">
                                     <label class="lblStyle" for="ddl_age_of_construction">Age of construction<span class="star">*</span> : </label>
                                 </td>
                                 <td>
                                      <select class="dropList" id="ddl_age_of_construction" name="ddl_age_of_construction">
                                              <option value="">Please select</option>
                                              <option value="Under construction">Under construction</option>
                                              <option value="New-ready to move-in">New-ready to move-in</option>
                                              <option value="0-2 years old">0-2 years old</option>
                                              <option value="5-10 years old">5-10 years old</option>
                                              <option value="10-15 years old">10-15 years old</option>
                                              <option value="15-20 years old">15-20 years old</option>
                                              <option value="More than 20 years">More than 20 years</option>  
                                      </select>
                                 </td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="ddl_floor_no">Floor no.<span class="star">*</span> : </label>
                                </td>
                                <td>
                                     <select class="dropList" id="ddl_floor_no" name="ddl_floor_no">
                                      <option value="">Please select</option>
                                      <option value="Under construction">Under construction</option>
                                      <option value="Basement">Basement</option>
                                      <option value="Ground floor">Ground floor</option>
                                      <option value="Mezzanine floor">Mezzanine floor</option>
                                      <?php
                                      for($i=1;$i<=40;$i++)
                                      {
                                      ?>
                                         <option value="<?php echo $i?>"><?php echo $i?></option>
                                      <?php } ?>
                                      <option value="40+">40+</option>     
                                      </select>
                                 </td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="ddl_bed_rooms">Bed rooms<span class="star">*</span> : </label>
                                </td>
                                <td>
                                      <select class="dropList" id="ddl_bed_rooms" name="ddl_bed_rooms">
                                      <option value="">Please select</option>
                                      <?php
                                      for($i=1;$i<=10;$i++)
                                      {
                                      ?>
                                           <option value="<?php echo $i?>"><?php echo $i?></option>
                                      <?php } ?>
                                      <option value="10+">10+</option>     
                                      </select>
                                 </td>
                            </tr>   
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="ddl_bath_rooms">Bath rooms<span class="star">*</span> : </label>
                                </td>
                                <td>
                                      <select class="dropList" id="ddl_bath_rooms" name="ddl_bath_rooms">
                                      <option value="">Please select</option>
                                      <?php
                                      for($i=1;$i<=10;$i++)
                                      {
                                      ?>
                                           <option value="<?php echo $i?>"><?php echo $i?></option>
                                      <?php } ?>
                                      <option value="10+">10+</option>     
                                      </select>
                                 </td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="txt_sft_area">Property area<span class="star">*</span> : </label>
                                </td>
                                <td>
                                    <input type="text" name="txt_sft_area" id="txt_sft_area" class="inpText"/> 
                                </td>
                            </tr>
                            <tr>
                                 <td></td>
                                 <td><i>In square feet</i></td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="txt_total_price">Total price<span class="star">*</span> : </label>
                                </td>
                                <td>
                                    <input type="text" name="txt_total_price" id="txt_total_price" class="inpText"/>
                                </td>
                            </tr>
                            <tr>
                                 <td></td>
                                 <td><i>In lakhs</i></td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="txt_rate">Rate<span class="star">*</span> : </label>
                                </td>
                                <td>
                                    <input type="text" name="txt_rate" id="txt_rate" class="inpText" />
                                </td>
                            </tr>
                            <tr>
                                 <td class="label_cell">
                                      <label class="lblStyle" for="rdo_negotiable">Is price negotiable</label><span class="star">*</span> : </label>
                                 </td>
                                 <td class="control_cell">
                                      	<input type="radio" value="0" name="rdo_negotiable" checked="checked" />
                                        <span>Yes</span>
                                        <input type="radio" value="1" name="rdo_negotiable"  />
                                        <span>No </span>
                                 </td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                     <label class="lblStyle" for="ddl_furnished">Furnished<span class="star">*</span> : </label>
                                </td>
                                <td>
                                     <select class="dropList" id="ddl_furnished" name="ddl_furnished">
                                             <option value="">Please select</option>
                                             <option value="Unfurnished">Unfurnished</option>
                                             <option value="Semi-furnished">Semi-furnished</option>
                                             <option value="Furnished">Furnished</option>
                                     </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label_cell">
                                    <label class="lblStyle" for="ddl_ownership">Ownership type<span class="star">*</span> : </label>
                                </td>
                                <td>
                                    <select class="dropList" id="ddl_ownership" name="ddl_ownership">
                                      <option value="">Please select</option>
                                      <option value="Freehold">Freehold</option>
                                      <option value="Leasehold">Leasehold</option>
                                      <option value="Power of atorney">Power of atorney</option>
                                      <option value="Co-operative society">Co-operative society</option>
                                    </select>
                                </td>
                           </tr>
                           <tr>
                    	       <td class="label_cell">
                                   <label class="lblStyle" for="txt_description">Description<span class="star">*</span> : </label>
                               </td>
                               <td class="control_cell">
                                    <textarea cols="40" rows="6" style="resize:auto;" onkeydown="javascript:limitText(this.form.txt_description,this.form.charCounter,1000);" onkeyup="javascript:limitText(this.form.txt_description,this.form.charCounter,1000);" class="textarea auto" name="txt_description" id="txt_description"></textarea>
                               </td>
                            </tr>
                            <tr>
                                 <td></td>
                                 <td><span style="text-align: right;"><input type="text" style="background: white;border: 0px;" value="1000" size="2" name="charCounter" readonly="readonly"/><i>characters left.</i></span></td>
                            </tr>
                    </table>
					
					
				<br />
                    
                   
				</span>
				<span id="second" class="step">
					<span class="property_step">Second step >> Location & other details</span><br />
					<table>
                           <tr>
                                 <td class="label_cell">
                                      <label class="lblStyle" for="txt_address">Property address<span class="star">*</span> : </label>
                                 </td>
                                 <td class="control_cell">
                                      <textarea id="txt_address" cols="40" rows="6"  name="txt_address" class="txt_address">
                                      </textarea> 
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
                                                $data = $db->fetchQuery($sql_state);
        
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
                             <label class="lblStyle" for="ddl_facing">Facing<span class="star">*</span> : </label>
                         </td>
                         <td>
                              <select class="dropList" id="ddl_facing" name="ddl_facing">
                                      <option value="">Please select</option>
                                      <option value="East">East</option>
                                      <option value="North-East">North-East</option>
                                      <option value="North">North</option>
                                      <option value="North-west">North-west</option>
                                      <option value="West">West</option>
                                      <option value="South-west">South-west</option>
                                      <option value="South">South</option>
                              </select>
                         </td>
                    </tr>
                    <tr>
                         <td class="label_cell">
                             <label class="lblStyle" for="chk_amenities">Amenities<span class="star">*</span> : </label>
                         </td>
                         <td>
                                         <?php
                                                $sql_amenities = "SELECT `id_amn` AS `id`, `name_amn` AS `name` FROM `amenities_amn` WHERE `is_active` =1;";
                                                $data = $db->fetchQuery($sql_amenities);
                                                if(!empty($data)){
                                                    foreach ($data as $states=>$value) {
                                                          echo '<input type="checkbox" value="'.$value['id'].'" id="chk_amenities" name="chk_amenities"/><span>'.$value['name'].'</span><br/>';
                                                    }
                                                }
                                           ?>
                                          <label for="chk_amenities" class="error">Please select amenities.</label> 
                          </td>
                      </tr>
                      <tr>
                         <td class="label_cell">
                             <label class="lblStyle" for="ddl_landmark">Proximity Landmarks<span class="star">*</span> : </label>
                         </td>
                         <td>
                                        <?php
                                                $sql_amenities = "SELECT `id_lnd` AS `id`, `name_lnd` AS `name` FROM `landmarks_lnd` WHERE `is_active` =1;";
                                                $data = $db->fetchQuery($sql_amenities);
                                                if(!empty($data)){
                                                    foreach ($data as $states=>$value) {
                                                          echo '<span>'.$value['name'].'</span>';
                                                          ?>
                                                          <select name="<?php echo $value['name'];?>">
                                                                  <option value="">Select</option>
                                                                  <option value="0.5 Kms">0.5 Kms</option>
                                                                  <option value="1 Km">1 Km</option>
                                                                  <option value="2 Kms">2 Kms</option>
                                                                  <option value="3 Kms">3 Kms</option>
                                                                  <option value="4 Kms">4 Kms</option>
                                                                  <option value="5 Kms">5 Kms</option>
                                                                  <option value="6 Kms">6 Kms</option>
                                                                  <option value="7 Kms">7 Kms</option>
                                                                  <option value="8 Kms">8 Kms</option>
                                                                  <option value="9 Kms">9 Kms</option>
                                                                  <option value="10 Kms">10 Kms</option>
                                                          </select>
                                                          <span></span>
                                                          <?php 
                                                    }
                                                }
                                           ?>
                          </td>
                      </tr>
                      <tr>
                         <td class="label_cell">
                             <label class="lblStyle" for="file_image">Image upload<span class="star">*</span> : </label>
                         </td>
                         <td>
                             <input type="file" /><br />
                             <input type="file" /><br />
                             <input type="file" /><br />
                             <input type="file" /><br />
                         </td>
                      </tr>
                    </table>	 						
				</span>
              </div>
     			    <input value="Back" type="reset" id="back" class="myButton" />
					<input value="Next" type="submit" id="next" class="myButton"/>
			</form>

            <div id="register" style="display: none;">
                  <span id="third" class="step">
					<table class="form_table">
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_username">Select Profile <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="radio" value="0" name="member_type" checked="checked" />
                            <span>Individual</span>
                            <input type="radio" value="1" name="member_type"  />
                            <span>Agent </span>
                            <input type="radio" value="2" name="member_type" />
                            <span>Builder</span>
                        </td>
                    </tr>                
                
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
                            <label class="lblStyle" for="txt_dateofbirth">Date Of Birth  <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input id="txt_dateofbirth" type="text" name="txt_dateofbirth" class="inpText"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_gender">Gender <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="radio" value="male" name="gender" checked="checked" />
                            <span>Male</span>
                            <input type="radio" value="female" name="gender"  />
                            <span>Female </span>
                            
                        </td>
                       
                    </tr> 
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_mobile">Mobile No  <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_mobile" name="txt_mobile" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_landline,txt_area_code">Landline No  <span class="star">*</span> : </label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_area_code" name="txt_area_code" style="width:30px;" class="inpText"  />
                            <input type="text" id="txt_landline" name="txt_landline" class="inpText" style="width:160px;"/>
                        </td>
                    </tr>
                    <tr>
                    <td class="label_cell">
                            
                    </td>
                    <td class="control_cell">
                            <label class="lblStyle" style="font-size:10px;font-style: italic; " for="txt_area_code,txt_landline">Area Code &amp; Landline</label>
                        </td>
                    
                    </tr>

                </table>
				</span>	
            </div>
     </div>
     <div id="footer">
          <?php
                include_once(LAYOUT.'template'.DS.'layout'.DS.'footer.php');
          ?>
     </div>
</body>
</html>