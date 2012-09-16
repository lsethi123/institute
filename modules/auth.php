<?php
     session_start();
     $site_root=$_SERVER['DOCUMENT_ROOT'];
     require_once($site_root.'configuration.php');
     require_once(LIB.'db.php');
     if (! isset($_SESSION['user']))
     {
         $uname=$_REQUEST['username'];
         $pass=md5($_REQUEST['password']);
         if($uname!='' && $pass!='')
         {
            $sql = "SELECT * FROM `users_usr` WHERE username_usr=:uname and password_usr=:pass";
            $result=$db->fetchQueryPrepared($sql,array(':uname'=>$uname,':pass'=>$pass));
            foreach($result as $val)
            {
                $user=$val['name_usr'];
            }
            if(count($result)==1)
            {
              $_SESSION['user']=$user;
              echo $login="true";
              if(!isset($_REQUEST['is_ajax']))
                 header("Location:login.php?login=$login");
            }
            else
            {
              echo $login="false";
              if(!isset($_REQUEST['is_ajax']))
                 header("Location:login.php?login=$login");
            } 
       }
       else
           {
             echo $login="blank";
             if(!isset($_REQUEST['is_ajax']))
                 header("Location:login.php?login=$login");
           }
    }
    else
    {
         if(isset($_GET['login']))
         {
           $login = $_GET['login'];
           if($login=='logout')
           {
             session_destroy();
             header("Location:login.php?logout=true");
           }
         }
    }
?>