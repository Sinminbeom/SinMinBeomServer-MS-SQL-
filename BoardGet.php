<?php

$BoardSeq = $_GET["boardseq"];

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
//MS-SQL 서버연결주소
$ServerName = '192.168.219.103';

//MS-SQL 접속정보
$ConnectionOptions = array(
    'Database' => 'MinBeom',
    'UID' => 'sa',
    'PWD' => 'tlsalsqja12!'
);

//MS-SQL 연결
$Conn = sqlsrv_connect($ServerName, $ConnectionOptions);

//MS-SQL JSON파라미터 정의
$Json = array(
    'BoardSeq' => $BoardSeq
);

//json -> string 으로 변환
// $Json = json_encode($Json,JSON_UNESCAPED_UNICODE);
$Json = json_encode($Json);

//MS-SQL 실행문
$Query = "EXEC BoardQuery "."'".$Json."'";

if ($Conn){

    $Rows = array();
    if(($Result = sqlsrv_query($Conn,$Query)) !== false){
        while($R = sqlsrv_fetch_object($Result)) {
            $Rows[] = $R;
        }
    }
    sqlsrv_free_stmt($result);
    sqlsrv_close($Conn);

    echo json_encode($Rows);

}else{
    die(print_r(sqlsrv_errors(), true));
}
?>