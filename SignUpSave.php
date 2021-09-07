<?php
    require __DIR__ . '/lib/header.php';
    require __DIR__ . '/lib/mssql.php';
    

    $username = $_POST['UserName'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];


    //json 으로 변경
    $json = array(
        'UserName' => $username,
        'Email' => $email,
        'Password' => $password
    );

    //json -> string 으로 변경
    $json = json_encode($json);

    $result = mssql_dbconnet('SignUpSave',$json,'Save');
    
    echo $result;

?>