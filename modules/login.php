<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Sandip Karanjekar" />
	<title>Property</title>
    <?php
         include_once(LAYOUT.'template'.DS.'layout'.DS.'javascript.php');
         include_once(LAYOUT.'template'.DS.'layout'.DS.'style_sheet.php');
    ?>
    <style>
           .left{
                width: 610px;
                height: 250px;
                float: left;
                border: 2px solid #12617F;
                -moz-border-radius: 5px;
                border-radius: 5px;
           }
           .login{
                 width: 330px;
                 height: 250px;
                 float: left;
                 border: 2px solid #12617F;
                 -moz-border-radius: 5px;
                 border-radius: 5px;
           }
           
    </style>
</head>

<body>
       <div id="header">
          <?php
                 include_once(LAYOUT.'template'.DS.'layout'.DS.'header.php');
          ?>
       </div>
       <div id="content">
          <?php
                 include_once(CONTENT.'follow_us.php');
          ?>
          <div class="left">
                 <div style="float: left; width:404px;">
                      
                 </div>
                 
                 <div class="four"></div>
           </div>
          <div class="login">
               <h3 style="padding-left: 10px;">Login</h3>
               <?php 
                        if(isset($_SESSION['user']))
                        {
                            
                            echo '<h3 style="width:100px;padding-left: 10px;">Welcome</h3>&nbsp;&nbsp;<b style="float:left;padding-left: 10px;">'. $_SESSION['user'] . '</b>';
                            echo '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.DOMAIN.'modules/auth.php?login=logout">Logout</a>';
                        }
                        else
                        {
                            if(isset($_GET['login']))
                            {
                                $login =$_GET['login'];
                                if($login =='false')
                                   echo "Username or password incorrect";
                                else
                                {
                                    if($login=='blank')
                                       echo "Username or password should not blank";
                                }
                             }
                             ?>
                                      <form action="auth.php" method="post" name="login">
                                      <table>
                                              <tr>
                                                   <td><label class="lable_name">Username :</label></td>
                                                   <td><input class="text_box" type="text" name="username"/></td>
                                              </tr>
                                              <tr>
                                                   <td><label class="lable_name">Password :</label></td>
                                                   <td><input class="text_box" type="password" name="password"/></td>
                                              </tr>
                                      </table><br />
                                      <input  type="submit" value="Submit" class="myButton"/>
                                      <input  type="reset" value="Clear" class="myButton"/>
                                      </form>
                             <?php        
                          }
               ?>
          </div>
        </div>  
     <div id="footer">
          <?php
                include_once(LAYOUT.'template'.DS.'layout'.DS.'footer.php');
          ?>
     </div>
</body>
</html>