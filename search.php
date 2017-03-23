<?php
if (!isset($_COOKIE["account"])) {
    header("Location: index.php");
    exit();
}
include_once 'functions.php';
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
</head>

<body background="images/bg.jpg">
<header>
    <h1>4th year project</h1>
    <a href="home.php">My Profile</a>
</header>
<nav>
    <form name="search" action="" method="get">
        <input name="name" type="text" placeholder="any name"/>
        <input name="email" type="email" placeholder="email"/>
        <select name="faculty" style="width: 10%">
            <option value="">Faculty</option>
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
        </select>
        <select name="department" style="display: none;width: 10%">
            <option value="">Department</option>
        </select>
        <select name="session">
            <option value="">Session</option>
        </select>
        <select name="year">
            <option value="">Year</option>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
            <option value="5">5th Year</option>
        </select>
        <select name="semester" style="display: none">
            <option value="">Semester</option>
            <option value="1">1st Semester</option>
            <option value="2">2nd Semester</option>
            <option value="3">3rd Semester</option>
        </select>
        <select name="hall" style="width: 10%">
            <option value="">Hall</option>
        </select>
        <input type="checkbox" name="resident" value="1">Resident
        <select name="division">
            <option value="">Division</option>
            <option value="0">BARISAL</option>
            <option value="1">CHITTAGONG</option>
            <option value="2">DHAKA</option>
            <option value="3">KHULNA</option>
            <option value="4">MYMENSINGH</option>
            <option value="5">RAJSHAHI</option>
            <option value="6">RANGPUR</option>
            <option value="7">SYLHET</option>
        </select>
        <select name="district" style="display: none">
            <option value="">District</option>
        </select>
        <select name="thana" style="display: none">
            <option value="">Thana</option>
        </select>
        <select name="area" style="display: none">
            <option class="" value="">Area</option>
        </select>
        <input name="q" type="submit" value="search"/>
    </form>
</nav>
<?php
if (isset($_GET['q'])) {
    $sql = "SELECT * FROM students WHERE";
    if ($_GET['name'] != '') $sql .= " name LIKE '%{$_GET['name']}%' AND ";
    if ($_GET['email'] != '') $sql .= " email='{$_GET['email']}' AND ";
    if ($_GET['session'] != '') $sql .= " session='{$_GET['session']}' AND ";
    if ($_GET['hall'] != '') $sql .= " hall='{$_GET['hall']}' AND ";
    if (isset($_GET['resident'])) $sql .= " resident='{$_GET['resident']}' AND ";
    if ($_GET['faculty'] != '')
        if ($_GET['department'] != '') $sql .= " subject='{$_GET['faculty']}" . ($_GET['department'] < 10 ? '0' : '') . "{$_GET['department']}' AND ";
        else $sql .= " subject BETWEEN '{$_GET['faculty']}00' AND '{$_GET['faculty']}99' AND ";
    if ($_GET['year'] != '')
        if ($_GET['semester']) $sql .= " year='{$_GET['year']}{$_GET['semester']}' AND ";
        else $sql .= " year BETWEEN '{$_GET['year']}0' AND '{$_GET['year']}9' AND ";
    if ($_GET['division'] != '') {
        $address = $_GET['division'] . ($_GET['district'] != '' && $_GET['district'] < 10 ? '0' : '') . $_GET['district'] .
            ($_GET['thana'] != '' && $_GET['thana'] < 10 ? '0' : '') . $_GET['thana'] . ($_GET['area'] != '' && $_GET['area'] < 10 ? '0' : '') . $_GET['area'];
        if (strlen($address) == 7) $sql .= " address='{$address}' AND ";
        else {
            $a1 = str_pad($address, 7, '0');
            $a2 = str_pad($address, 7, '9');
            $sql .= " address BETWEEN '{$a1}' AND '{$a2}' AND ";
        }
    }
    if (strlen($sql) > 30) {
        $db = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);
        $sql = substr($sql, 0, strlen($sql) - 5);
        echo $sql."<br>";
        $res = mysqli_query($db, $sql);
        echo mysqli_error($db);
        $users = mysqli_fetch_all($res);
        if ($users) {
            echo "<table border='1'>";
            echo "<tr>
                        <th class='id'>ID</th>
                        <th class='name'>Name</th>
                        <th class='email'>Email</th>
                        <th class='mobile'>Mobile</th>
                        <th class='birthday'>Birthday</th>
                        <th class='gender'>Gender</th>
                        <th class='hall'>Hall</th>
                        <th class='session'>Session</th>
                        <th class='faculty'>Facylty</th>
                        <th class='department'>Department</th>
                        <th class='year'>Year</th>
                        <th class='division'>Division</th>
                        <th class='district'>District</th>
                        <th class='thana'>Thana</th>
                        <th class='area'>Area</th>
                        <th class='message'></th>
                     </tr>";
            $gender = ['', 'Male', 'Female', 'Other'];
            foreach ($users as $user) {
                if ($_COOKIE["account"] == $user[3]) continue;
                $user[13] = array_keys($du)[(int)($user[9] / 100)];
                $user[14] = $du[$user[13]][$user[9] % 100];
                $user[10] .= "-" . ($user[10] + 1);
                $user[11] = position($user[11]);
                $user[12] = sprintf("%7d", $user[12]);
                $user[15] = array_keys($bd)[(int)$user[12][0]];
                $user[16] = array_keys($bd[$user[15]])[(int)($user[12][1] . $user[12][2])];
                $user[17] = array_keys($bd[$user[15]][$user[16]])[(int)($user[12][3] . $user[12][4])];
                $user[18] = $bd[$user[15]][$user[16]][$user[17]][(int)($user[12][5] . $user[12][6])];
                echo "<tr>
                        <td class='id'>{$user[0]}</td>
                        <td class='name'>{$user[1]}</td>
                        <td class='email'>{$user[3]}</td>
                        <td class='mobile'>{$user[2]}</td>
                        <td class='birthday'>{$user[5]}</td>
                        <td class='gender'>{$gender[$user[6]]}</td>
                        <td class='hall'>{$hall[$user[7]]}</td>
                        <td class='session'>{$user[10]}</td>
                        <td class='faculty'>{$user[13]}</td>
                        <td class='department'>{$user[14]}</td>
                        <td class='year'>{$user[11]}</td>
                        <td class='division'>{$user[15]}</td>
                        <td class='district'>{$user[16]}</td>
                        <td class='thana'>{$user[17]}</td>
                        <td class='area'>{$user[18]}</td>
                        <td class='message'><a href='javascript:send({$user[0]})'>message</a> </td>
                     </tr>";
            }
            echo "</table>";
        } else echo "No result found";
    } else echo "<p>select at least on option</p>";
}
?>
<script src="scripts/script.js"></script>
<script src="scripts/message.js"></script>
</body>
</html>