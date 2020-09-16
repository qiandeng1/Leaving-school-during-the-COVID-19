<!doctype html>
<?php
  session_start();//开启session会话
  $PHPid = session_id();
?>
<html>
<head>
<meta charset="utf-8">
<title>时间输入</title>
<link href="index.css" rel="stylesheet" type="text/css">
</head>

<body>

	<h1>学生请假数据登记</h1>
	<div class="message">
	<form action="text.php" method="post">
		<br>
		<input type="hidden" name="PHPid" value="<?php echo $PHPid; ?>">
		姓名：<input type="text" name="name" placeholder="张三"><br>
		学号：<input type="text" name="id" placeholder="201812345678"><br>
		学院：<input type="text" name="academy" placeholder="电子信息工程学院"><br>
		专业：<input type="text" name="subject" placeholder="电子信息大类"><br>
		班级：<input type="text" name="class" placeholder="电子信息类1801"><br>
		电话：<input type="text" name="tel" placeholder="12345678910"><br>		
		开始日期：<input type="date" name="beginDay" value="2020-09-01"> 开始日期：<input type="time" name="beginTime" value="00:00"><br>
		结束时间：<input type="date" name="endItDay" value="2020-09-02"> 结束日期：<input type="time" name="endItTime" value="00:00"><br>
		
	<input type="submit">
	</form> 
	</div>

<p>如果您点击提交，系统会自动生成请假页面。</p>

</body>
</html>
