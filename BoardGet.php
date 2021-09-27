<?php
    require __DIR__ . '/lib/mssql.php';
    require __DIR__ . '/lib/header.php';

    $boardseq = $_GET["boardseq"];

    //json 으로 변경
    $json = array(
        'BoardSeq' => $boardseq
    );

    //json -> string 으로 변경
    $json = json_encode($json);

    $result = mssql_dbconnet('BoardQuery',$json,'','Query');

    echo $result;

?>