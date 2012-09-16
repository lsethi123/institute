<?php
    //Check Query String
    if(isset($_GET['id']) && !empty($_GET['id'])){
         $site_root=$_SERVER['DOCUMENT_ROOT'];
         require_once($site_root.'configuration.php');         
         require_once(LIB . 'db.php');
    
        $state_id = $_GET['id'];
        $sql = "SELECT `id_cit` AS `id`, `name_cit` AS `name` FROM `cities_cit` WHERE `is_active` = 1 AND `id_sta_cit` = :state_id;";
        $data = $db->fetchQueryPrepared($sql,array(':state_id' => $state_id));
        header('Content-type: application/json');
        echo json_encode($data);
    }
    else {
        echo "Error";
    }
?>