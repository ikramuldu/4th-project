<?php
include_once "functions.php";
$db = mysqli_connect($DBHost,$DBUser , $DBPass, $DBName);
$sql = "select id from students WHERE email='{$_POST['from']}'";
$res = mysqli_query($db, $sql);
if(mysqli_error($db)){
    echo 0;
    exit();
}
$user=mysqli_fetch_assoc($res);
$sql="insert into message (from_id,to_id,text) VALUES('{$user['id']}','{$_POST['to']}','{$_POST['message']}')";
$res = mysqli_query($db, $sql);
if(mysqli_error($db))echo 0;
else echo 1;
?>