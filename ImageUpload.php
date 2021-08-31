<?php

    
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

    require_once __DIR__.'/vendor/autoload.php';
    
    function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes(Google_Service_Drive::DRIVE);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    function insertFile($service, $parentId, $filename, $file_path) {
        $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => $filename,'parents' => array($parentId))); //
        $content = file_get_contents($file_path);
        $file = $service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'image/jpeg',
            'uploadType' => 'media',
            'fields' => '*')); //모두 file 속성들 가져오기
        //printf("File ID: %s\n", $file->id);
        return 'https://drive.google.com/uc?export=view&id='.$file->id;
        
        
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