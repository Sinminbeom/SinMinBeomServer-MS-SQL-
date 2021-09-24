<?php
    require_once __DIR__ . '/lib/mssql.php';
    require_once __DIR__ . '/lib/header.php';

    $BoardSeq = $_POST['BoardSeq'];
    $Comment = $_POST['Comment'];
    $UpCommentSeq = $_POST['UpCommentSeq'];
    $UserSeq = $_POST['UserSeq'];


    $json = array("BoardSeq"=> $BoardSeq,"Comment"=> addslashes($Comment),"UpCommentSeq"=> $UpCommentSeq, "NickName"=> addslashes($NickName));
    $json1 = json_encode($json,JSON_UNESCAPED_UNICODE);
    
    // $start = "CALL SetCalendar('[".$json1."]')";

    $result = mysqli_query($db, "CALL SetComment('[".$json1."]')");    
    $success = array("result"=> true,"BoardSeq"=> $BoardSeq,"Comment"=> addslashes($Comment),"UpCommentSeq"=> $UpCommentSeq, "NickName"=> addslashes($NickName));
    $fail = array("result"=> false,"message" => mysqli_error($db));

    if($result){
         echo json_encode($success);
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