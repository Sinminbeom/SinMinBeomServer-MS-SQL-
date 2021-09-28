<?php
    require_once __DIR__ . '/lib/mssql.php';
    require_once __DIR__ . '/lib/header.php';

    $BoardSeq = $_POST['BoardSeq'];
    $BoardCommentContent = $_POST['BoardCommentContent'];
    $UpCommentSeq = $_POST['UpCommentSeq'];
    $UserSeq = $_POST['UserSeq'];

    //json 으로 변경
    $json = array(
        'BoardSeq' => $BoardSeq,
        'BoardCommentContent' => $BoardCommentContent,
        'UpCommentSeq' => $UpCommentSeq,
    );

    //json -> string 으로 변경
    $json = json_encode($json);

    $result = mssql_dbconnet('CommentSave',$json,$UserSeq,'Save');

    echo $result;

?>