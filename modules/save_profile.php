<?php
    $site_root=$_SERVER['DOCUMENT_ROOT'];
    require_once($site_root.'configuration.php');
	include_once(COMMON . DS . 'class.upload.php');
    include_once(COMMON . DS . 'save_image.php');
    
    if (!empty($_FILES)) {
        $s_obj = new save_image();
        //SETTINGS
        $s_obj->initials = 'stud_';
        $s_obj->target_folder = WEB_ROOT . 'images' . DS . 'student' . DS;
        $s_obj->output_path = '/images/student/';
        
        $response = $s_obj->save_upload($_FILES['img_upload']);
        
        if($response['RESULT'] == 'SUCCESS'){
            $handle = new Upload($s_obj->target_path);        
            if ($handle->uploaded) {
                $handle->file_new_name_body   = 'thumb_' . md5(uniqid());
                $handle->image_resize          = true;
                //$handle->image_ratio_fill      = true;
                $handle->image_ratio_crop      = true;
                $handle->image_y               = 100;
                $handle->image_x               = 100;
                
                $handle->Process($s_obj->target_folder . 'thumbnails/');
                if(!$handle->processed){
                    $response['RESULT'] = 'ERROR';
                    $response['CODE'] = $handle->error;
                }
                else{
                    $response['THUMB'] = $s_obj->output_path . 'thumbnails/' . $handle->file_dst_name;
                }
            }
        }
    }
    else {
        $response = array('RESULT' => 'ERROR', 'CODE' => '5');
    }
    
    echo json_encode($response);
?>