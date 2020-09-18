<!doctype html>
<?php
session_start();
$_SESSION["user"]=$_POST["user"];
?>
<html>
<head>
<meta charset="utf-8">
<title>跳转中。。。</title>
</head>

<body>
<?php
	$check = 0;
	if($_SESSION["user"]==""){
	echo "<script language='javascript'>alert('请通过正确途径登录本系统！');</script>";
	header("Refresh:0;url=index.html");
	exit;
}
?>
<?php
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

$result = mysqli_query($mysqli,"SELECT * FROM id WHERE id={$_SESSION['user']}");
$row = mysqli_fetch_array($result);
if($row == false){
	echo "<script language='javascript'>alert('该学号未录入系统，请重试！');</script>";
	header("Refresh:0;url=index.html");
	exit;
}
$mysqli->close();	
?>
<form name="formName" method="post" action="input.php">
	<input type="hidden" name="insure" value="876541841">
</form>
<script language="javascript">
document.formName.submit();
</script>
</body>
</html>