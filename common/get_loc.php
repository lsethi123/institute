<?php
    //Check Query String
    if(isset($_GET['sid']) && !empty($_GET['sid']) && isset($_GET['cid']) && !empty($_GET['cid']) && isset($_GET['term']) && !empty($_GET['term'])){
         $site_root=$_SERVER['DOCUMENT_ROOT'];
         require_once($site_root.'configuration.php');         
         require_once(WEB_ROOT . LIB . 'db.php');
    
        $state_id = $_GET['sid'];
        $city_id = $_GET['cid'];
        $search = $_GET['term'];
        $search .= '%';
        
        $sql1 =  "SELECT  `name_are` AS `value` FROM  `areas_are` ar 
                INNER JOIN  `cities_cit` ct ON ct.`id_cit` = ar.`id_cit_are`  
                INNER JOIN  `states_sta` st ON st.`id_sta` = ct.`id_sta_cit` 
                WHERE ar.`is_active` =1 AND st.`id_sta` = :state_id AND ct.`id_cit` = :city_id
                AND ar.`name_are` LIKE :search;";
        
        $data = $db->fetchQueryPrepared($sql1,array(':state_id' => $state_id,':city_id' => $city_id,':search' => $search));
        
        header('Content-type: application/json');
        echo json_encode($data);
    }
?>