<div class="follow_us" id="sub_nav">
                <?php
                    session_start();
                    $site_root=$_SERVER['DOCUMENT_ROOT'];
                    require_once($site_root.'configuration.php');
                    if(isset($_SESSION['user']))
                    {
                      echo 'Welcome '.$_SESSION['user'].'&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.DOMAIN.'modules/auth.php?login=logout">Logout</a>&nbsp;&nbsp;|&nbsp;&nbsp;<span>';
                    }
                    else
                    {
                      echo 'Welcome Guest!'; 
                    ?>
                      <a href="<?php echo DOMAIN;?>modules/login.php">Login</a>  or
                      <a href="<?php echo DOMAIN;?>modules/register.php">Register</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <?php
                    }
               ?>
               <a href="http://#">Vaastu</a>&nbsp;&nbsp;|&nbsp;&nbsp;
               <a target="_blank" href="http://igrmaharashtra.gov.in/">Ready Reckoner Rate</a>&nbsp;&nbsp;|&nbsp;&nbsp;
               <a href="http://#">Loan</a>
               <div style="width: 250px; float: right;text-align: center;">
                    Follow us on :
                    <img src="/images/social_nw/twitter.png" width="25" height="25" />
	                <img src="/images/social_nw/facebook.png" width="25" height="25" />
                    <img src="/images/social_nw/linkedin.png" width="25" height="25" />
		            <img src="/images/social_nw/google_plus.png" width="25" height="25" />
               </div>
</div>