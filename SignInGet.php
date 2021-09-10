<?php
    require_once __DIR__ . '/lib/mssql.php';
    require_once __DIR__ . '/lib/header.php';
    
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];

    //json 으로 변경
    $json = array(
        'UserName' => $UserName,
        'Password' => $Password
    );

    //json -> string 으로 변경
    $json = json_encode($json);

    $result = mssql_dbconnet('SignInGet',$json,'Save');
    
    echo $result;   

?>