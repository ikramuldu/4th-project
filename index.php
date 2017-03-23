<?php
include_once "functions.php";
$app=isset($_GET['app']);
if (isset($_COOKIE["account"])) {
    if($app) header("Location: home.php?app=android");
    else header("Location: home.php");
    exit();
}
$alert = "";
if (isset($_POST['login'])) {
    $db = mysqli_connect($DBHost,$DBUser , $DBPass, $DBName);
    $sql = "SELECT `password` FROM `students` WHERE `email`='{$_POST['email']}'";
    $res = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($res);
    mysqli_close($db);
    if ($user['password'] == $_POST["password"]) {
        setcookie("account", $_POST['email'], time() + 30 * 24 * 3600);
        setcookie($_POST['email'], md5($_POST['password']), time() + 30 * 24 * 3600);
        if($app) header("Location: home.php?app=android");
        else header("Location: home.php");
        exit();
    }
    $alert = "<script>alert('invalid Email or Password')</script>";
}
if ($app) {
    if ($alert == "") echo "0";//nothing
    else echo "1";//invalid pass
}
else echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <title>4th year project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="students statistics of university of Dhaka"/>
    <meta name="keywords" content="Dhaka university, standard, quality, problems, statistics, my districts, "/>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/style.css">'.
    $alert.
'</head>

<body background="images/bg.jpg">
<header>
    <h1>4th year project</h1>
</header>
<form action="" method="post">
    <table>
        <tr>
            <td><label for="email">Email:</label></td>
            <td><input name="email" type="email" placeholder="email id" required/></td>
        </tr>
        <tr>
            <td><label for="password">Password:</label></td>
            <td><input name="password" required="required" type="password" placeholder="password"/></td>
        </tr>
        <tr>
            <td><a href="registration.php">not registered?</a></td>
            <td><input name="login" type="submit" value="Login"/></td>
        </tr>
    </table>
</form>
</body>
</html>';
?>