<div class="footer-wrapper keepCenter">
    <div id="fmain">
        <div class="fmenu">
            <ul>
                <li><a href="<?php echo DOMAIN;?>index.php">Home</a><span>|</span></li>
                <li><a href="<?php echo DOMAIN;?>modules/students.php">Students</a><span>|</span></li>
                <li><a href="<?php echo DOMAIN;?>modules/settings.php">Settings</a></li>
            </ul>
            <div class="cleaner"></div>
            <div class="copy-right">
                <center class="copyright">Copyright &copy; 2012 all rights reserved</center>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
    <?php
        if(!empty($startup_scripts)){
            echo $startup_scripts;
        }
    ?>
//]]>
</script>