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
            
        });
    </script>
</head>
<body>
    <div id="header" class="completeWidth">
        <?php include_once(LAYOUT . THEME . DS . 'layout' . DS . 'header.php'); ?>
        <?php
            require_once(COMMON . 'Utils.php');
            
            //LOAD STANDARDS
            $sql_student = "SELECT `id_stu`, `id_usr_stu`, `fname_stu`, `mname_stu`, `lname_stu`, CONCAT(`fname_stu`, ' ', `lname_stu`) fullname , `parent_stu`, `parent_occupation_stu`, `gender_stu`, `dob_stu`, `address_stu`, `email_stu`, `id_adm_std_stu`, `id_curr_std_stu`, `id_med_stu`, `mobile_stu`, `std_stu`, `landline_stu`, `fees_mode_stu`, `image_stu`, `thumb_stu` FROM `students_stu` WHERE `is_active` = 1;";
            $data_student = $db->fetchQuery($sql_student);
        ?>
    </div>
    <?php include_once(LAYOUT . THEME . DS . 'layout' . DS . 'students' . DS . 'submenu.php'); ?>
    <div id="content">
        <div class="content-box">
            <div class="content-box-header">
                <h3>Students</h3>
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
                <table class="GridClass" style="width: 100%;">
					<tr class="GridHead">
						<th>
							Student
						</th>
					</tr>
                    <?php
                        foreach($data_student as $val)
                        {
                    ?>
                    <tr class="GridRow">
						<td>
                            <?php echo $val['fullname'];?>
                        </td>
					</tr>
                    <?php
                        }
                    ?>
				</table>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once(LAYOUT.THEME.DS.'layout'.DS.'footer.php'); ?>
    </div>
</body>
</html>