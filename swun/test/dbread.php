<!doctype html>
<?php
  session_start();//开启session会话
?>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
	<?php
	$PHPid = session_id();
    $mysql_conf = array(
    'host'    => 'localhost',   // IP : 端口
    'db'      => 'test',   // 要连接的数据库
    'db_user' => 'root',   // 数据库用户名
    'db_pwd'  => 'root',   // 密码
    );

$mysqli = new mysqli($mysql_conf['host'], $mysql_conf['db_user'], $mysql_conf['db_pwd'], $mysql_conf['db']);
if ($mysqli -> connect_errno) {
    die("could not connect to the database:\n" . $mysqli->connect_error);//诊断连接错误
}

$result = mysqli_query($mysqli,"SELECT * FROM message
WHERE PHPid='$PHPid'");

while($row = mysqli_fetch_array($result))
{
    echo $row['name'] . " " . $row['subject'];
    echo "<br>";
}
	
$mysqli->close();
?>
	
</body>
</html>