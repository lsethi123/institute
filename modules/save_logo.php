<?php
    $site_root=$_SERVER['DOCUMENT_ROOT'];
    require_once($site_root.'configuration.php');
	include_once(COMMON . DS . 'class.upload.php');
    include_once(COMMON . DS . 'save_image.php');
    
    if (!empty($_FILES)) {
        $s_obj = new save_image();
        //SETTINGS
        $s_obj->auto_name = false;
        $s_obj->n_name = 'ilogo.png';        
        $s_obj->target_folder = LAYOUT . THEME . '/images/';
        $s_obj->output_path = '/themes/' . THEME . '/images/';        
        
        $response = $s_obj->save_upload($_FILES['img_upload']);
        
        if($response['RESULT'] == 'SUCCESS'){
            $handle = new Upload($s_obj->target_path);        
            if ($handle->uploaded) {
                $handle->file_new_name_body   = 'ilogo';
                $handle->file_new_name_ext    = 'png';
                $handle->file_overwrite       = true;
                $handle->file_auto_rename     = false;
                $handle->image_resize         = true;
                //$handle->image_ratio_fill      = true;
                $handle->image_ratio_crop      = true;
                $handle->image_y               = 100;
                $handle->image_x               = 120;
                $handle->Process($s_obj->target_folder);
                if(!$handle->processed){
                    $response['RESULT'] = 'ERROR';
                    $response['CODE'] = $handle->error;
                }
                else{
                    $response['THUMB'] = $s_obj->output_path . $handle->file_dst_name;
                }
            }
        }
    }
    else {
        $response = array('RESULT' => 'ERROR', 'CODE' => '5');
    }
    
    echo json_encode($response);
?>