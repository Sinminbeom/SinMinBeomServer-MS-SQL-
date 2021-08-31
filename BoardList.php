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

$serverName = "192.168.219.103";
$connectionOptions = array(
    "Database" => "MinBeom",
    "UID" => "sa",
    "PWD" => "tlsalsqja12!"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);


// try{

//     //기본 포트일 경우 ip addr 만  
//     $mssql_server="49.168.71.214:1433"; 
//     $mssql_ID="sa"; 
//     $mssql_PW="tlsalsqja12!"; 
//     $mssql_DB = "MinBeom"; 

//     //DB 에 접속 
//     $conn = mssql_connect($mssql_server,$mssql_ID,$mssql_PW); 

//     //접속이 안되면 로그 뿌리고 죽기 
//     if(!$conn) die("couldn't connect to SQL Server on $mssql_server"); 
    
//     //테스트로 데이터 날려볼 쿼리문 작성 
//     $query = "select * from Board"; 
    
//     //쿼리를 DB에 쏘기 뿌슝~~~ 
//     $results = mssql_query($query,$conn);

//     //결과를 화면에 찍어 볼까? 데이터가 많을지 몰라서 while 문 사용했음 ㅎㅎ 센스쟁이  
//     while($result = mssql_fetch_array($results,MSSQL_ASSOC)) 
//     { 
//         print_r($result); // 결과를 1 rows 씩 출력 
//         echo "<br/>"; // 1rows 후 한줄 엔터 효과 발동 
//     } 

//     // results 를 받았으면 DB에게 자유를 
//     mssql_free_result($results); 
//     mssql_close($conn); 
// }
// catch(Exception $e)
// {
//     echo $e->getMessage();
// }


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