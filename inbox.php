<?php
if(!isset($_COOKIE["account"])){
    header("Location: index.php");
    exit();
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <title>4th year project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="students statistics of university of Dhaka"/>
    <meta name="keywords" content="Dhaka university, standard, quality, problems, statistics, my districts, "/>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="scripts/message.js"></script>
</head>

<body background="images/bg.jpg">
<header>
    <h1>4th year project</h1>
    <a href="home.php">My Profile</a>
</header>
<?php
include_once "functions.php";
$db = mysqli_connect($DBHost,$DBUser , $DBPass, $DBName);
$sql = "select id from students WHERE email='{$_COOKIE["account"]}'";
$res = mysqli_query($db, $sql);
$user=mysqli_fetch_assoc($res);
$sql="select * from message where to_id='{$user['id']}'";
$res = mysqli_query($db, $sql);
$messages=mysqli_fetch_all($res);
if($messages){
    echo "<table border='1'>";
    echo "<tr><th>From</th><th>Message</th><th></th></tr>>";
    foreach ($messages as $message){
        $sql = "select `name` from students WHERE id='{$message[1]}'";
        $res = mysqli_query($db, $sql);
        $user=mysqli_fetch_assoc($res);
        echo "<tr><td>{$user['name']}</td><td>{$message[3]}</td><td><a href='javascript:send({$message[1]})'>reply</a> </td></tr>";
    }
    echo "</table>";
}
else{
    echo "no messages";
}
?>
</body>
</html>
