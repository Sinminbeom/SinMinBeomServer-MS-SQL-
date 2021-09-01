<?php

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

$serverName = '192.168.219.103';
$connectionOptions = array(
    'Database' => 'MinBeom',
    'UID' => 'sa',
    'PWD' => 'tlsalsqja12!'
);

//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
$query = "EXEC BoardQuery";

if ($conn){

    $rows = array();
    if(($result = sqlsrv_query($conn,$query)) !== false){
        while($r = sqlsrv_fetch_object($result)) {
            $rows[] = $r;
        }
    }
    sqlsrv_free_stmt($result);
    sqlsrv_close($conn);

    echo json_encode($rows);

}else{
    die(print_r(sqlsrv_errors(), true));
}





// try
// {
//     $db = mysqli_connect("localhost", "root", "root", "minbeom");
//     mysqli_query($db,"set names utf8mb4");

//     $result = mysqli_query($db, 'SELECT B.UserName,B.Image,A.* FROM BoardTable AS A JOIN User AS B ON A.userseq = B.userseq');
    
//     $rows = array();

//     while($r = mysqli_fetch_assoc($result)) {
//         $rows[] = $r;
//     }
//     echo json_encode($rows);
// }
// catch(Exception $e)
// {
//     echo $e->getMessage();
// }
    
?>