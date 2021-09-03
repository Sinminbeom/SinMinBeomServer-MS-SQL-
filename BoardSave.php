<?php

    require __DIR__ . '/lib/mssql.php';

    $boardtitle = $_POST['BoardTitle'];
    $boardcontent = $_POST['BoardContent'];
    $boardseq = $_POST['BoardSeq'];

    //utf8mb4

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

    //json 으로 변경
    $json = array(
        'BoardSeq' => $boardseq,
        'BoardTitle' => $boardtitle,
        'BoardContent' => $boardcontent//addslashes($boardcontent) emoji mysql일때
    );

    //json -> string 으로 변경
    $json = json_encode($json);//JSON_UNESCAPED_UNICODE //한글

    $result = mssql_dbconnet('BoardSave',$json);

    echo $result;

?>