<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Sunil Gautam" />
    <meta name="developed by" content="Tech Schema" />
    <meta name="website" content="Property Vihar" />
    <title>Property - Add Location</title>
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'style_sheet.php');
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'javascript.php');
    ?>
    <script type="text/javascript">
    $(document).ready(function() { 
    	var validator = $("#frm_add_loc").validate({
    		rules: {
    			ddl_state: "required",
                ddl_city: "required",
                txt_loc: "required"
    		},
    		messages: {
                ddl_state: "Please enter state",
                ddl_city: "Please enter city",
                txt_loc: "Please enter location"
    		}
    	});
    });
    
    function getState(objState,objCity,objLoc){
        var objState1 = $(objState);
        var objCity1 = $(objCity);
        var objLoc1 = $(objLoc);
        var option1 = '<option value="">---------------- Select ----------------</option>';
        var option2 = '<option value="">---------------- Select ----------------</option>';
        var val1 = objState1.val();
        if(val1==null||val1==""||val1=="undefined"){
            objCity1.html(option2);
        }
        else{
            objCity1.html('<option value="">-------------- Loading... --------------</option>');
            $.ajax(
            {
                    url: "../../common/get_city.php",
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
        objLoc1.val('');
    }
    
    function getCity(objState,objCity,objLoc){
        var objState1 = $(objState);
        var objCity1 = $(objCity);
        var objLoc1 = $(objLoc);
        var option1 = '<option value="">---------------- Select ----------------</option>';
        var option2 = '<option value="">---------------- Select ----------------</option>';
        var val1 = objCity1.val();
        objLoc1.val('');
        if(val1==null||val1==""||val1=="undefined"){
            
        }
        else{
            
        }
    }
        
    function getStateId(){
        return $("#ddl_state").val();
    }
    
    function getCityId(){
        return $("#ddl_city").val();
    }
</script>
</head>
<body>
    <div id="header">
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'header.php');
        
        require_once(LIB . 'db.php');
        if (isset($_POST['submit'])){
            if(isset($_POST['ddl_state']) && !empty($_POST['ddl_state']) && isset($_POST['ddl_city']) && !empty($_POST['ddl_city']) && isset($_POST['txt_loc']) && !empty($_POST['txt_loc'])){
                $state_id = $_POST['ddl_state'];
                $city_id = $_POST['ddl_city'];
                $location = $_POST['txt_loc'];
                
                $sql = "SELECT 1 FROM `areas_are` WHERE `is_active` = 1 AND `id_cit_are` = :city_id AND `name_are` = :location;";
                if($db->queryPrepared($sql,array(':city_id' => $city_id, ':location' => $location))->rowCount()>0){
                    $startup_scripts .= "showWarn('Location already exists');";
                }
                else{
                    $sql = "INSERT INTO `areas_are`(`name_are`, `id_cit_are`, `is_active`, `created_by`, `created_at`)
                        VALUES (:location, :city_id, 1, 0, now());";
                    $db->queryPrepared($sql,array(':location' => $location, ':city_id' => $city_id));
                    $startup_scripts .= "showSucc('Location added successfully');";                    
                }
            }
            else{
                $startup_scripts .= "showError('Please fill all fields');";
            }
        }
        $sql_state = "SELECT  `id_sta` AS `id`, `name_sta` AS `name` FROM `states_sta` WHERE `is_active` =1;";
        $data = $db->fetchQuery($sql_state);
    ?>
    </div>
    <?php include_once(CONTENT.'follow_us.php'); ?>
    <?php include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'adminpanel.php'); ?>
    <div class="content-box">
        <div class="content-box-header">
            <h3>Add Location</h3>
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
            <form method="post" name="frm_add_loc" id="frm_add_loc" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="form_table">
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle">State<span class="star">*</span> :</label>
                        </td>
                        <td class="control_cell">
                            <select class="dropList" id="ddl_state" name="ddl_state" onchange="getState('#ddl_state','#ddl_city','#txt_loc');">
                            	<option value="">---------------- Select ----------------</option>
                                <?php
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
                            <select class="dropList" id="ddl_city" name="ddl_city" onchange="getCity('#ddl_state','#ddl_city','#txt_loc');">
                            	<option value="">---------------- Select ----------------</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td class="label_cell">
                            <label class="lblStyle" for="txt_loc">Location<span class="star">*</span> :</label>
                        </td>
                        <td class="control_cell">
                            <input type="text" id="txt_loc" name="txt_loc" class="inpText" />
                        </td>
                    </tr>
                    <tr>
                    	<td>
                            &nbsp;
                        </td>
                        <td>
                            <input value="Save" type="submit" id="frm_add_state_submit" name="submit" class="myButton" />
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