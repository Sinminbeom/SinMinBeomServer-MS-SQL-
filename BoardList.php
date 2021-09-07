<?php
    require __DIR__ . '/lib/mssql.php';
    require __DIR__ . '/lib/header.php';


    $result = mssql_dbconnet('BoardQuery','','Query');

    echo $result;
    
?>