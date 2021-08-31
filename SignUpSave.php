<?php

$UserName = $_POST['UserName'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];


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
    $db = mysqli_connect("localhost", "root", "root", "minbeom");
    mysqli_query($db,"set names utf8mb4");

    if($db){
        $status = "Fail";
    }
    else{
        $status = "success";
    }

    $json = array("UserName"=> $UserName,"Email"=> $Email,"Password"=> $Password);
    //[{"boardTitle":"2020-01-01","boardContent":"fdsfds"}] addslashes($detail)
    $json1 = json_encode($json,JSON_UNESCAPED_UNICODE);
    
 
    //
    // $start = "CALL SetCalendar('[".$json1."]')";
    // echo 'console.log('.$start.')';
    //
    //CALL SetCalendar('[{"start":"2020-01-02","title":"1213"}]',@Status,@Msg,@Message);
    $result = mysqli_query($db, "CALL SetSignUp('[".$json1."]')");    
    $success = array("result"=> true);
    $fail = array("result"=> false, "message" =>mysqli_error($db));

    if($result){
        $rows = array();

        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        echo json_encode($rows);
    }
    else{
        echo json_encode($fail);
    }

}
catch(Exception $e)
{
    echo $e->getMessage();
}
?>