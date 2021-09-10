<?php
    function mssql_dbconnet($procedure,$json,$type){
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

            if($type == 'Query')
            {
                $query = 'EXEC '.$procedure." '".$json."'";
            }
            else if ($type == 'Save')
            {
                $query =    'DECLARE	@Status		INT
                                    ,	@Message	NVARCHAR(MAX)
                            '
                            .'EXEC '.$procedure." '".$json."', 0, @Status OUTPUT, @Message OUTPUT".
                            "
                            SELECT      @Status		AS	Status
                                ,       @Message	AS	Message";
            }
            $result = sqlsrv_query($conn,$query);
            if($result != false)
            {
                while($r = sqlsrv_fetch_object($result)) 
                {
                    $rows[] = $r;
                }

                do 
                {
                    while ($r = sqlsrv_fetch_object($result)) 
                    {
                        $rows[] = $r;
                    }
                } 
                while (sqlsrv_next_result($result));

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
