<?php
if (!empty($_SERVER['HTTP_CLIENT_IP']))
{
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from remote address
else
{
    $ip_address = $_SERVER['REMOTE_ADDR'];
}
$date = new DateTime("now");
$sql = "INSERT INTO tblOnline VALUES(DEFAULT, '$ip_address')";
$mysqli = new mysqli("localhost", "id11184959_test_user", "_Bd29?$7~<9t89o[", "id11184959_test_db");
if($mysqli-> connect_errno){
    echo "<script>console.log('error')</script>";
    exit();
}
if($ip_address != "84.85.162.123"){
    if($mysqli->query($sql) === TRUE){
        echo "<script>console.log('Done')</script>";

    }else{
        echo "<script>console.log('Nope: " . $mysqli->error . "')</script>";

    }
}

$mysqli->close()
?>