<?php
include_once 'functions.php';
$app=isset($_GET['app']);
if (isset($_POST['logout'])) {
    setcookie("account", "", time() - 1);
    if($app) echo "0";
    else header("Location: index.php");
    exit();
}
if (!isset($_COOKIE["account"])) {
    if($app) echo "4";
    else header("Location: index.php");
    exit();
}
$db = mysqli_connect($DBHost,$DBUser , $DBPass, $DBName);
$sql = "SELECT * FROM `students` WHERE `email`='{$_COOKIE["account"]}'";
$res = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($res);
if ($user['birthday']=='0000-00-00') $user['birthday'] = "N/A";
if (!$user['mobile']) $user['mobile'] = "N/A";
$user['gender'] = $user['gender'] == 1 ? 'Male' : ($user['gender'] == 2 ? 'Female' : 'Others');
$user['hall'] = $hall[$user['hall']] . ($user['resident'] ? '(Resident)' : '(Non-Resident)');
$user['faculty'] = array_keys($du)[(int)($user["subject"]/100)];
$user['department'] = $du[$user['faculty']][$user["subject"]%100];
$user['session'] = $user['session'] . '-' . ($user['session'] + 1);
$user['year'] = position($user['year']);
$user['address']=sprintf("%7d",$user['address']);
$user['division'] = array_keys($bd)[(int)$user['address'][0]];
$user['district'] = array_keys($bd[$user['division']])[(int)($user['address'][1].$user['address'][2])];
$user['thana'] = array_keys($bd[$user['division']][$user['district']])[(int)($user['address'][3].$user['address'][4])];
$user['area'] = $bd[$user['division']][$user['district']][$user['thana']][(int)($user['address'][5].$user['address'][6])];
if ($app) echo json_encode($user);
else echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\">
<head>
    <meta charset=\"UTF-8\"/>
    <title>4th year project</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"students statistics of university of Dhaka\"/>
    <meta name=\"keywords\" content=\"Dhaka university, standard, quality, problems, statistics, my districts, \"/>
    <link rel=\"shortcut icon\" href=\"images/favicon.ico\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">
</head>

<body background=\"images/bg.jpg\">
<header>
    <h1>4th year project</h1>
    <a href=\"search.php\">Search Students</a>
    <a href=\"inbox.php\">Inbox</a>
</header>
<table>
    <tr><td>Student ID:</td><td>{$user['id']}</td></tr>
    <tr><td>Name:</td><td>{$user['name']}</td></tr>
    <tr><td>Mobile:</td><td>{$user['mobile']}</td></tr>
    <tr><td>Email ID:</td><td>{$user['email']}</td></tr>
    <tr><td>Password:</td><td>********</td></tr>
    <tr><td>Birth Date:</td><td>{$user['birthday']}</td></tr>
    <tr><td>Gender:</td><td>{$user['gender']}</td></tr>
    <tr><td>Hall:</td><td>{$user['hall']}</td></tr>
    <tr><td>Subject:</td><td>{$user['faculty']}<br>{$user['department']}</td></tr>
    <tr><td>Admission:</td><td>{$user['session']}</td></tr>
    <tr><td>Current:</td><td>{$user['year']}</td></tr>
    <tr><td>Address:</td><td>{$user['district']}, {$user['thana']}, {$user['area']}</td></tr>
</table>
<footer>
    <form method=\"post\">
        <input type=\"submit\" name=\"logout\" value=\"log out\"/>
    </form>
</footer>
</body>
</html>";
?>

