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
                                    ,	@Message	NVARCHAR(MAX)'
                            .'EXEC '.$procedure." '".$json."', 0, @Status OUTPUT, @Message OUTPUT".
                            '
                            SELECT      @Status		AS	asd
                                ,       @Message	AS	qwe';
            }

            // $query = 'select "123" AS hihi,"minbeom" AS byby';
            
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
