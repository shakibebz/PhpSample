
<?php
header('Content-type: application/json');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $server__response__success = array(
        "code"=>http_response_code(200),
        "status"=>true,
        "message"=>"Request Accepted"
    );
    echo json_encode($server__response__success);
} else {
    http_response_code(404);
    $server__response__error = array(
        "code"=>http_response_code(404),
        "status"=>false,
        "message"=>"Bad Request"
    );
    echo json_encode($server__response__error);
}