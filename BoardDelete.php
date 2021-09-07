<?php
    require_once __DIR__.'/lib/header.php';
    require_once __DIR__.'/lib/mssql.php';

    $boardseq = $_POST['BoardSeq'];

    //json 으로 변경
    $json = array(
        'BoardSeq' => $boardseq
    );

    //json -> string 으로 변경
    $json = json_encode($json);

    $result = mssql_dbconnet('BoardDelete',$json,'Query'); //Save
    
    echo $result;

?>