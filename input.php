<!doctype html>
<?php
session_start();
error_reporting(0);
?>
<ht
<html>
<head>
<meta charset="utf-8">
<title>时间输入</title>
<link href="index.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
	$id = $_SESSION['user'];
	if($_POST[insure]!="876541841"){
		echo "<script language='javascript'>alert('请通过正确途径登录本系统！');</script>";
		header("Refresh:0;url=index.html");
		exit;
	}
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
$result = mysqli_query($mysqli,"SELECT * FROM message WHERE id='$id'");
$row = mysqli_fetch_array($result);
if($row != false){
	$name = $row['name'];
	$academy = $row['academy'];
	$subject = $row['subject'];
	$class = $row['class'];
	$beginDay = $row['beginDay'];
	$beginTime = $row['beginTime'];
	$endItDay = $row['endItDay'];
	$endItTime = $row['endItTime'];
	$tel = $row['tel'];
}
else{
	$name = null;
	$academy = null;
	$subject = null;
	$class = null;
	$beginDay = null;
	$beginTime = null;
	$endItDay = null;
	$endItTime = null;
	$tel = null;
}
?>
	<h1>学生请假数据登记</h1>
	<div class="message">
	<form action="text.php" method="post">
		<br>
		姓名：<input type="text" name="name" value="<?php echo "$name"; ?>"><br>
		学号：<input type="text" value="<?php echo $id; ?>"  disabled><br>
			 <input type="hidden" name="id" value="<?php echo "$id"; ?>">
		学院：<input type="text" name="academy" value="<?php echo "$academy"; ?>"><br>
		专业：<input type="text" name="subject" value="<?php echo "$subject"; ?>"><br>
		班级：<input type="text" name="class" value="<?php echo "$class"; ?>"><br>
		电话：<input type="text" name="tel" value="<?php echo "$tel"; ?>"><br>		
		开始日期：<input type="date" name="beginDay" value="2020-09-01"> 开始日期：<input type="time" name="beginTime" value="00:00"><br>
		结束时间：<input type="date" name="endItDay" value="2020-09-02"> 结束日期：<input type="time" name="endItTime" value="00:00"><br>
		
	<input type="submit">
	</form> 
	</div>

<p>如果您点击提交，系统会自动生成请假页面。</p>

</body>
</html>
