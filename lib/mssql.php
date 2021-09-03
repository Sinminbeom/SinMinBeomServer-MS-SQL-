<?php
    function mssql_dbconnet($procedure,$json){
        $serverName = '192.168.219.103';
        $connectionOptions = array(
            'Database' => 'MinBeom',
            'UID' => 'sa',
            'PWD' => 'tlsalsqja12!'
        );
    
        $conn = sqlsrv_connect($serverName, $connectionOptions);

        if ($conn)
        {
            $rows = array();

            $query = 'EXEC '.$procedure." '".$json."'";

            if(($result = sqlsrv_query($conn,$query)) !== false)
            {
                while($r = sqlsrv_fetch_object($result)) 
                {
                    $rows[] = $r;
                }
            }

            sqlsrv_free_stmt($result);
            sqlsrv_close($conn);

        }
        else
        {
            die(print_r(sqlsrv_errors(), true));
        }

        return json_encode($rows);
    }

?>
