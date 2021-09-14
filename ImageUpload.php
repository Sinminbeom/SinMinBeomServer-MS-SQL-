<?php
    require_once __DIR__.'/vendor/autoload.php';
    require_once __DIR__.'/lib/google_drive.php';
    require_once __DIR__.'/lib/header.php';

    try
    {
        $client = getClient();
        $service = new Google_Service_Drive($client);

        $file_name = $_FILES['image']['name'];
        $file_name = preg_replace("/\s+/", "", $file_name);
        
        $tmp_file= $_FILES['image']['tmp_name'];
        $file_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$file_name; // uploads 폴더 권한, tmp 폴더 권한 755로 되있어야함
 
        $folder_id = '1aXQva8IcMGybJFP_ILN8Sskcku0A0eOJ';

        $result = insertFile($service,$folder_id,$file_name,$tmp_file);
        $success = array("url"=> $result);
        echo json_encode($success);

        // $moved = move_uploaded_file($tmp_file, $file_path);
        // if($moved)
        // {
        //     //$success = array("url"=> "http://49.168.71.214:8000/uploads/".$file_name);

        //     $result = insertFile($service,$folder_id,$file_name,$file_path);
        //     $success = array("url"=> $result);
        //     echo json_encode($success);
        // }
        // else
        // {
        //     $fail = array("fail"=> $_FILES["image"]);
        //     echo json_encode($fail);
        // }
        


        
    }
    catch(Exception $e)
    {
        $fail = array("fail"=>$e->getMessage());
        echo json_encode($fail);
    }
?>