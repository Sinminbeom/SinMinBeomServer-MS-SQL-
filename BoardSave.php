<?php
    require_once __DIR__ . '/lib/mssql.php';
    require_once __DIR__ . '/lib/header.php';

    $boardtitle = $_POST['BoardTitle'];
    $boardcontent = $_POST['BoardContent'];
    $boardseq = $_POST['BoardSeq'];
    $username = $_POST['UserName'];

    //json 으로 변경
    $json = array(
        'BoardSeq' => $boardseq,
        'BoardTitle' => $boardtitle,
        'BoardContent' => $boardcontent
    );

    //json -> string 으로 변경
    $json = json_encode($json);

    $json = str_replace('&amp;','&',$json);

    $result = mssql_dbconnet('BoardSave',$json,$username,'Query');

    echo $result;

?>