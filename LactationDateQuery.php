<?php
    require_once __DIR__ . '/lib/mssql.php';
    require_once __DIR__ . '/lib/header.php';

    $LactationDate = $_POST['LactationDate'];
    $UserSeq = $_POST['UserSeq'];

    //json 으로 변경
    $json = array(
        'LactationDate' => $LactationDate,
    );

    //json -> string 으로 변경
    $json = json_encode($json);
    $result = mssql_dbconnet('LactationDateQuery',$json,$UserSeq,'Query');

    echo $result;
    
?>