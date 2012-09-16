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
	<title>Property</title>
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'style_sheet.php');
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'javascript.php');
    ?>
</head>
<body>
    <div id="header">
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'header.php');
    ?>
    </div>
    <?php include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'adminpanel.php'); ?>
    <div id="content" style="height: 750px;">
        
    </div>
    <div id="footer">
    <?php
        include_once(LAYOUT . 'template' . DS . 'layout' . DS . 'footer.php');
    ?>
</div>
</body>
</html>