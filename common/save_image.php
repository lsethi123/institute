<?php
/*********************************************************************************
* IF JSON RESPONSE IN NOT NEEDED THEN YOU HAVE TO SUPPRESSJSON BY
* SETTING $suppressJSON VAR BEFORE INCLUDING THIS FILE
* RESULT CAN BE CHECKED IN $response VAR FOR RESULT
* IF SUCCESS
* $response (
*               RESULT => SUCCESS
*           )
* IF ERROR
* $response (
*               RESULT => ERROR,
*               CODE => 1 error moving,2 filesize,3 filetype,4 emptyfilename,5 nodata
*           )
********************************************************************************/
    //sleep(3);
class save_image{    
    var $echo_type;
    var $auto_name;
    
    var $target_folder;
    var $output_path;
    var $initials;
    var $n_name;
    var $target_file;
    var $target_path;
    
    function init() {
        $this->echo_type = 'html';
        $this->auto_name = true;        
        $this->target_folder = PATH_DEFAULT;
        $this->output_path = PATH_OUT_DEFAULT;
        $this->initials = PATH_INIT_DEFAULT;
        $this->n_name = '';
        $this->target_file = '';
        $this->target_path = '';
        
    }
    
    function __construct(){
        $this->init();
    }
    
    function save_upload($FILE){
        if (!empty($_FILES)) {
            $file_name = $FILE['name'];
            $file_type = $FILE['type'];
            $file_size = $FILE['size'];        
        	$file_temp = $FILE['tmp_name'];
            
            //echo $file_type;
            $is_valid = true;
            if(!empty($file_name)){
                //IF MIME-TYPE IS THERE
                if(!empty($file_type)){
                    if( ($file_type == 'image/jpg') || ($file_type == 'image/jpeg') ||
                        ($file_type == 'image/gif') || ($file_type == 'image/png') ||
                        ($file_type == 'image/pjpeg') || ($file_type == 'image/x-png') ||
                        ($file_type == 'image/x-icon')
                      ){
                        $file_ext = substr($file_type, 6); //GET EXTENTION
                        switch ($file_ext) {
                            case "pjpeg":
                                $file_ext ='jpeg';
                                break;
                            case "x-png":
                                $file_ext ='png';
                                break;
                        }
                    }
                    else{
                        $is_valid = false;
                    }
                }
                else{
                    // Validate the file type
                	$file_types = array('jpg','jpeg','gif','png'); // FILE EXTENSIONS
                	$file_parts = pathinfo($file_name);
                	
                	if (in_array($file_parts['extension'],$file_types)) {
                		$file_ext = $file_parts['extension']; //GET EXTENTION
                	}
                    else{
                        $is_valid = false;
                    }
                }
                
                //CHECK FILE SIZE
                if($is_valid){
                    if(($file_size > 0) && ($file_size <= MAX_IMAGES_SIZE)){
                        if ($FILE['error'] == 0) {
                            //MOVE THE FILE TO THE TARGET UPLOAD FOLDER
                            
                            if($this->auto_name){
                                $this->target_file = $this->get_file_name($this->target_folder, $file_ext, $this->initials);
                            }
                            else{
                                $this->target_file = $this->n_name;
                            }
                            
                            $this->target_path = $this->target_folder . $this->target_file;                        
                            
                            if (move_uploaded_file($FILE['tmp_name'], $this->target_path)) {
                                //THE NEW PICTURE FILE MOVE WAS SUCCESSFUL
                                $response = array('RESULT' => 'SUCCESS' , 'RESOURCE' => $this->output_path . $this->target_file);
                            }
                            else {
                                //THE NEW PICTURE FILE MOVE FAILED, SO DELETE THE TEMPORARY FILE
                                $response = array('RESULT' => 'ERROR', 'CODE' => '1');
                                @unlink($FILE['tmp_name']);
                            }
                        }
                    }
                    else{
                        //DELETE FILE FROM TEMP
                        $response = array('RESULT' => 'ERROR', 'CODE' => '2');
                        @unlink($FILE['tmp_name']);
                    }
                }
                else{
                    //DELETE FILE FROM TEMP
                    $response = array('RESULT' => 'ERROR', 'CODE' => '3');
                    @unlink($FILE['tmp_name']);
                }
            }
            else{
                $response = array('RESULT' => 'ERROR', 'CODE' => '4');
            }
        }
        else{
            $response = array('RESULT' => 'ERROR', 'CODE' => '5');
        }
        
        return $response;
    }
    
    function get_file_name($target_folder, $file_ext, $initials = 'file'){
        //$check_name = $initials . time() . '_' . rand()*33 . '.' . $file_ext;
        $check_name = $initials . md5(uniqid()) . '.' . $file_ext;
        while(file_exists($target_folder . $check_name)){
            //$check_name = $initials . time() . '_' . rand()*33 . '.' . $file_ext;
            $check_name = $initials . md5(uniqid()) . '.' . $file_ext;
            //echo '#1|';
        }
        return $check_name;
    }
}
?>