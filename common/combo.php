<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
     include_once(WEB_ROOT . LIB . 'adminsession.php');
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Sunil Gautam" />
    <meta name="developed by" content="Tech Schema" />
    <meta name="website" content="Property Vihar" />
    <title>Property - Add State</title>
    <?php
        include_once(WEB_ROOT . LAYOUT . 'template' . DS . 'layout' . DS . 'style_sheet.php');
        include_once(WEB_ROOT . LAYOUT . 'template' . DS . 'layout' . DS . 'javascript.php');
    ?>
    <script src="http://localhost/jquery-autocomplete/lib/jquery.autocomplete.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="http://localhost/jquery-autocomplete/lib/jquery.js"></script>
    <script type='text/javascript' src='http://localhost/jquery-autocomplete/lib/jquery.bgiframe.min.js'></script>
    <script type='text/javascript' src='http://localhost/jquery-autocomplete/lib/jquery.ajaxQueue.js'></script>
    <script type='text/javascript' src='http://localhost/jquery-autocomplete/lib/thickbox-compressed.js'></script>
    <script type='text/javascript' src='http://localhost/jquery-autocomplete/lib/jquery.autocomplete.js'></script>
    
    <link rel="stylesheet" type="text/css" href="http://localhost/jquery-autocomplete/demo/main.css" />
    <link rel="stylesheet" type="text/css" href="http://localhost/jquery-autocomplete/jquery.autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="http://localhost/jquery-autocomplete/lib/thickbox.css" />
    <script type="text/javascript">
    $(document).ready(
        $("#singleBirdRemote").autocomplete("search.php", {
    		width: 260,
    		selectFirst: false
    	});
    )
    
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
        objLoc1.val('');
    }
    
    function getCity(objState,objCity,objLoc){
        var objState1 = $(objState);
        var objCity1 = $(objCity);
        var objLoc1 = $(objLoc);
        var option1 = '<option value="">---------------- Select ----------------</option>';
        var option2 = '<option value="">---------------- Select ----------------</option>';
        objCity1.val('');
    }
    
    function getLoc(objState,objCity,objLoc){
        
    }
</script>
</head>
<body>
    <div id="header">
    </div>
    <select class="dropList" id="ddl_state" name="ddl_state" onchange="getState('#ddl_state','#ddl_city','#txt_loc');">
    	<option value="">---------------- Select ----------------</option>
        <option value="1">Maharashtra</option>
    </select>
    <br />
    <select class="dropList" id="ddl_city" name="ddl_city">
    	<option value="">---------------- Select ----------------</option>
    </select>
    <br />
    <input type="text" id="singleBirdRemote" name="singleBirdRemote" class="inpText" />
    <div id="footer">
    <?php
        include_once(WEB_ROOT . LAYOUT . 'template' . DS . 'layout' . DS . 'adminfooter.php');
    ?>
</div>
</body>
</html>