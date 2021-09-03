<?php
    require_once __DIR__.'/vendor/autoload.php';
    require_once __DIR__.'/lib/google_drive.php';
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:  {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }

    try
    {
        $client = getClient();
        $service = new Google_Service_Drive($client);

        $file_name = $_FILES['image']['name'];
        $file_name = preg_replace("/\s+/", "", $file_name);
        
        $tmp_file= $_FILES['image']['tmp_name'];
        $file_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$file_name;
        //$r = move_uploaded_file($tmp_file, $file_path);
        // $tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
        // die($tmp_dir);
        $folder_id = '1aXQva8IcMGybJFP_ILN8Sskcku0A0eOJ';
        if(move_uploaded_file($tmp_file, $file_path))
        {
            //$success = array("url"=> "http://49.168.71.214:8000/uploads/".$file_name);

            $result = insertFile($service,$folder_id,$file_name,$file_path);
            $success = array("url"=> $result);
            echo json_encode($success);
        }
        else
        {
            $fail = array("fail"=> "Upload Fail");
            echo json_encode($fail);
        }
        


        
    }
    catch(Exception $e)
    {
        $fail = array("fail"=>$e->getMessage());
        echo json_encode($fail);
    }
?>