<!doctype html>
<?php
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<title>跳转中...</title>
</head>

<body>
	<?php
	$id = $_SESSION['user'];
	$thisid = $_POST["id"];
    $mysql_conf = array(
    'host'    => 'localhost',   // IP : 端口
    'db'      => 'message',   // 要连接的数据库
    'db_user' => 'message',   // 数据库用户名
    'db_pwd'  => 'root',   // 密码
    );

$mysqli = new mysqli($mysql_conf['host'], $mysql_conf['db_user'], $mysql_conf['db_pwd'], $mysql_conf['db']);
if ($mysqli -> connect_errno) {
    die("could not connect to the database:\n" . $mysqli->connect_error);//诊断连接错误
}
	
//写入数据
$sql = "SELECT * FROM id WHERE id='$thisid'";
$result = mysqli_query($mysqli,$sql); 
if($row = mysqli_fetch_assoc($result)){
	$NOWid = $row['id'];
}
	
if($thisid == $NOWid) {
	echo "已有原数据，删除中。。。";
	$data = "DELETE FROM message WHERE id='$thisid'";
	if ($mysqli->query($data) === TRUE) {
		echo "原纪录成功删除";
	} 
	else {
		echo "Error";
	}
	$sql = "INSERT INTO messgae (name, id, academy, subject, class, beginDay, beginTime, endItDay, endItTime, tel) VALUES ('$_POST[name]', '$_POST[id]', '$_POST[academy]', '$_POST[subject]', '$_POST[class]', '$_POST[beginDay]', '$_POST[beginTime]', '$_POST[endItDay]', '$_POST[endItTime]', '$_POST[tel]');";
	if ($mysqli->query($sql) === TRUE) {
		echo "新记录插入成功";
	} 
	else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
else{
	$sql = "INSERT INTO message (name, id, academy, subject, class, beginDay, beginTime, endItDay, endItTime, tel) VALUES('$_POST[name]','$_POST[id]','$_POST[academy]','$_POST[subject]','$_POST[class]','$_POST[beginDay]','$_POST[beginTime]','$_POST[endItDay]','$_POST[endItTime]','$_POST[tel]')";
	if ($mysqli->query($sql) === TRUE) {
		echo "新记录插入成功";
	} 
	else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
$mysqli->close();
?>
<script>
	window.location.href = "/swun/index.php";
</script>
</body>
</html>