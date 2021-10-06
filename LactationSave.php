<?php
    require_once __DIR__ . '/lib/mssql.php';
    require_once __DIR__ . '/lib/header.php';

    $Lactations = $_POST['Lactations'];
    $UserSeq = $_POST['UserSeq'];

    $result = mssql_dbconnet('LactationSave',$Lactations,$UserSeq,'Save');

    echo $result;
    
?>