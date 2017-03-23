<?php
include_once "functions.php";
$app=isset($_GET['app']);
if(isset($_COOKIE["account"])){
    if($app) header("Location: home.php?app=android");
    else header("Location: home.php");
    exit();
}
if (isset($_POST['registration'])) {
    if (!isset($_POST['resident'])) $_POST['resident'] = 0;
    $db = mysqli_connect($DBHost,$DBUser , $DBPass, $DBName);
	$birthday = "";
	if($_POST['birthday_year']>1930&&$_POST['birthday_year']<2017&&$_POST['birthday_month']>0&&$_POST['birthday_month']<13&&$_POST['birthday_day']>0&&$_POST['birthday_day']<32)$birthday=$_POST['birthday_year'].'-'.$_POST['birthday_month'].'-'.$_POST['birthday_day'];
    $sql = "INSERT INTO `students` (`name`,`mobile`,`email`,`password`,`birthday`,`gender`,`hall`,`resident`,`subject`,`session`,`year`,`address`) 
      VALUES ('{$_POST['name']}','{$_POST['mobile']}','{$_POST['email']}','{$_POST['password']}','{$birthday}','{$_POST['gender']}',
	  '{$_POST['hall']}','{$_POST['resident']}','{$_POST['faculty']}".($_POST['department']<10?'0':'')."{$_POST['department']}',
	  '{$_POST['session']}','{$_POST['year']}{$_POST['semester']}','{$_POST['division']}".($_POST['district']<10?'0':'')."{$_POST['district']}".($_POST['thana']<10?'0':'')."{$_POST['thana']}".($_POST['area']<10?'0':'')."{$_POST['area']}')";
    $res = mysqli_query($db, $sql);
    if (mysqli_error($db)) {
        if($app){
            echo "5";
            exit();
        }else echo "<script>alert('Account already exist with this email')</script>";
    }
    else {
        setcookie("account", $_POST['email'], time() + 30 * 24 * 3600);
        setcookie($_POST['email'], md5($_POST['password']), time() + 30 * 24 * 3600);
        if($app) header("Location: home.php?app=android");
        else header("Location: home.php");
        exit();
    }
	mysqli_close($db);
}
if($app){
    echo "0";
    exit();
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <title>4th year project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="students statistics of university of Dhaka"/>
    <meta name="keywords" content="Dhaka university, quality, problems, statistics, my districts, "/>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body background="images/bg.jpg">
<header>
    <h1>4th year project</h1>
</header>
<form name="reg" action="" method="post">
    <table>
        <tr>
            <td><label for="name">Name:</label></td>
            <td><input name="name" type="text" placeholder="only alphabet and space 3-32" required
                       pattern="[a-z A-Z]{3,32}"/></td>
        </tr>
        <tr>
            <td><label for="department">Subject:</label></td>
            <td>
                <select name="faculty" required>
                    <option value="">Select Faculty</option>
                    <option value="0">Faculty of Arts</option>
                    <option value="1">Faculty of Biological Sciences</option>
                    <option value="2">Faculty of Business Studies</option>
                    <option value="3">Faculty of Earth & Environmental Sciences</option>
                    <option value="4">Faculty of Education</option>
                    <option value="5">Faculty of Engineering & Technology</option>
                    <option value="6">Faculty of Fine Art</option>
                    <option value="7">Faculty of Law</option>
                    <option value="8">Faculty of Medicine</option>
                    <option value="9">Faculty of Pharmacy</option>
                    <option value="10">Faculty of Postgraduate Medical Sciences & Research</option>
                    <option value="11">Faculty of Sciences</option>
                    <option value="12">Faculty of Social Sciences</option>
                    <option value="13">Institutes</option>
                </select><br/>
                <select name="department" style="display: none" required>
                    <option value="">Select Department</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="session">Admission:</label></td>
            <td>
                <select name="session" required>
                    <option value="">Admission Session</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="year">Current position:</label></td>
            <td>
                <select name="year" required>
                    <option value="">Year</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                    <option value="5">5th Year</option>
                    <option value="0">NA</option>
                </select>
                <select name="semester" required>
                    <option value="">Semester</option>
                    <option value="1">1st Semester</option>
                    <option value="2">2nd Semester</option>
                    <option value="3">3rd Semester</option>
                    <option value="0">NA</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="hall">Hall:</label></td>
            <td>
                <select name="hall" required><option value="">Select Hall</option></select>
                <input type="checkbox" name="resident" value="1">Resident
            </td>
        </tr>
        <tr>
            <td><label for="division">Address:</label></td>
            <td>
                <select name="division" required>
                    <option value="">Select Division</option>
                    <option value="0">BARISAL</option>
                    <option value="1">CHITTAGONG</option>
                    <option value="2">DHAKA</option>
                    <option value="3">KHULNA</option>
                    <option value="4">MYMENSINGH</option>
                    <option value="5">RAJSHAHI</option>
                    <option value="6">RANGPUR</option>
                    <option value="7">SYLHET</option>
                </select>
                <select name="district" style="display: none" required>
                    <option value="">Select district</option>
                </select><br/>
                <select name="thana" style="display: none" required>
                    <option value="">Select Thana</option>
                </select>
                <select name="area" style="display: none" required>
                    <option class="" value="">Select Area</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="gender">Gender:</label></td>
            <td><select name="gender" title="gender" required>
                    <option value="">Select one</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                    <option value="3">Other</option>
                </select></td>
        </tr>
        <tr>
            <td><label for="birthday_day">Birth date:</label></td>
            <td>
                <select name="birthday_year" title="Year">
                    <option value="1" selected="1">Year</option>
                </select>
                <select name="birthday_month" title="Month">
                    <option value="0" selected="1">Month</option>
                    <option value="1">Jan</option>
                    <option value="2">Feb</option>
                    <option value="3">Mar</option>
                    <option value="4">Apr</option>
                    <option value="5">May</option>
                    <option value="6">Jun</option>
                    <option value="7">Jul</option>
                    <option value="8">Aug</option>
                    <option value="9">Sept</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                    <option value="12">Dec</option>
                </select>
                <select name="birthday_day" title="Day">
                    <option value="0" selected="1">Day</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="mobile">Mobile no:</label></td>
            <td><input name="mobile" type="text" placeholder="mobile(optional)" pattern="01[5-9][0-9]{8}"/></td>
        </tr>
        <tr>
            <td><label for="email">Email:</label></td>
            <td><input name="email" type="email" placeholder="valid email" required/></td>
        </tr>
        <tr>
            <td><label for="password">Password:</label></td>
            <td><input name="password" type="password" placeholder="6-32 digits" required pattern=".{6,32}"/></td>
        </tr>
        <tr>
            <td><a href="index.php">already Registered?</a></td>
            <td><input name="registration" type="submit" value="registration"/></td>
        </tr>
    </table>
</form>
<script src="scripts/script.js"></script>
<script src="scripts/bday.js"></script>
</body>
</html>