<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
     require_once(LIB . 'db.php');
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Sunil Gautam" />
    <meta name="developed by" content="Tech Schema" />
    <meta name="website" content="Property Vihar" />
	<title>Property</title>
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'style_sheet.php');
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'javascript.php');
    ?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
     <script type="text/javascript">
       $(document).ready(function() { 
    	var validator = $("#frm_add_city").validate({
    		rules: {
    			cityTxt1: "required",
                stateName: "required"
    		},
    		messages: {
                cityTxt1: "Please enter city name",
                stateName: "Please select state"
    		}
            
    	});
    });
    </script>
<script type="text/javascript">
  var latitude = '';
  var longitude = '';
  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(28.38,77.12);
    var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
  }
  
  function updateMarkerPosition(latLng) 
  {
         document.getElementById('hiddenLoc').value =  latLng.lat() + "|" + latLng.lng();
         var retVal= document.getElementById('hiddenLoc').value;
         // alert(retVal);
         var data = retVal.split("|");
          latitude = data[0];
          longitude = data[1];
         document.getElementById('hiddenLat').value = latitude;
         document.getElementById('hiddenLan').value = longitude;
          
  }

  function codeAddress() 
  {
    var address = document.getElementById("cityTxt1").value;
    if(address!=""){
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK)
           {
               map.setCenter(results[0].geometry.location);
               var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                title: 'Position Your Property Location',
                map: map,
                draggable: true,
                icon: 'prop.gif'
               });
            
            updateMarkerPosition(results[0].geometry.location);
            
            google.maps.event.addListener(marker, 'drag', function() {
            updateMarkerPosition(marker.getPosition());
            });
          }
           else
           {
            alert("Geocode was not successful for the following reason: " + status);
           }
        });        
    }
  }
</script>
</head>
<body onload="initialize()" >
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'header.php');
        if (isset($_POST['submit']))
        {
          $city_name = $_POST['cityTxt1'];
          $state_name = $_POST['stateName'];
          $lang = $_POST['hiddenLat'];
          $long = $_POST['hiddenLan'];
          if($city_name== '' && $state_name == '')
          {
            $startup_scripts .= "showError('Please Enter All The Fields');";
          }
          else
          {
              if(!empty($city_name))
              {
                   if(empty($state_name))
                   {
                    $startup_scripts .= "showError('Please enter State name');"; 
                   }
                   else{
                    $sql = "SELECT 1 FROM `cities_cit` WHERE `name_cit` = :city_name;";
                    if($db->queryPrepared($sql,array(':city_name' => $city_name))->rowCount()>0)
                    {
                        $startup_scripts .= "showWarn('city already exists');";
                    }
                    else
                    {
                        $sql = "INSERT INTO `cities_cit`(`name_cit`,`id_sta_cit`,`latitude_cit`,`longitude_cit`,`is_active`,`created_by`,`created_at`)".
                            "VALUES (:city_name,:state_name,:lang,:long,1,0,now())";
                        $db->queryPrepared($sql,array(':city_name' => $city_name,':state_name' => $state_name,':lang' => $lang,':long' => $long))->rowCount();
                        $startup_scripts .= "showSucc('city added successfully')";
                    }
                 }
              }
             else
             {                 
                $startup_scripts .= "showError('Please enter city name');";
             }  
          }  
       }    
    ?>
    <?php include_once(CONTENT.'follow_us.php'); ?>
    <?php include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'adminpanel.php'); ?>
    <div class="content-box">
        <div class="content-box-header">
            <h3>Add City</h3>
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
         <form method="post" name="frm_add_city" id="frm_add_city" accept="<?php echo $_SERVER['PHP_SELF']; ?>">
          <table class="form_table" style="float: left;">
	       <tr>
		          <td class="label_cell">ADD STATE:</td>
                  <td class="control_cell">
                
                    <?php
                             $sql1 = "select  id_sta,name_sta from states_sta";
                             $result_states = $db->queryPrepared($sql1,array());;                             
                    ?>
                           <select size="1" class="dropList" id="stateName" name="stateName" style="width: 210px;">
                           <option value="">---------------- Select ----------------</option>
                           <?php foreach($result_states as $val)
                                 {
                                   ?>                                   
                                   <option value="<?php echo $val['id_sta'];?>" ><?php echo $val['name_sta'];?></option>                                
                            <?php }?>
                             </select>
                             
                  </td>
	       </tr>
	       <tr>
                  <td class="label_cell">ADD CITY:</td>
       	            <td class="control_cell">
                        <input type="text" id="cityTxt1" name="cityTxt1" class="inpText" size="30" onblur="codeAddress();" />
                    </td>
	       </tr>
    	<tr>
            	<td>&nbsp;</td>
            	<td><input type="submit" value="Save" name="submit" class="myButton" /></td>
       </tr>
     </table>
             <div class="gmap">
                <div id="mapCanvas"></div>
                    <input type="hidden" id="hiddenLoc" value="" />
                    <input type="hidden" id="hiddenLat" name="hiddenLat" value=""/>
                    <input type="hidden" id="hiddenLan" name="hiddenLan" value=""/>
                    
             </div>
     </form>
</div>
    <br />
    <br />
    <br />
    <br />
    <br />
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
    <div id="footer">
    <?php include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'footer.php'); ?>
</div>
</body>
</html>