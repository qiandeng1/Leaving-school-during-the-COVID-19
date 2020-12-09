<!doctype html>
<?php
  session_start();//开启session会话
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="renderer" content="webkit">
    <link href="index.css" rel="stylesheet">
    <!--[if lt IE 9]><script r='m'>document.createElement("section")</script><![endif]--><script src="jquery-3.4.1.min.js"></script>
    <script src="validation.js"></script>
    <link href="layer.css" rel="stylesheet">
    <script src="layer.js"></script><link rel="stylesheet" href="layer1.css" id="layuicss-layer">
    <title>西南民族大学-疫情防控管理平台</title>
    <script type="text/javascript">
        /*解决苹果返回不刷新问题*/
        $(function () {
            var isPageHide = false;
            window.addEventListener('pageshow', function () {
                if (isPageHide) {
                    window.location.reload();
                }
            });
            window.addEventListener('pagehide', function () {
                isPageHide = true;
            });
        });
    </script>
</head>

<body>
<?php
	$id = $_SESSION['user'];
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
$sql = "SELECT * FROM messgae WHERE id='$id'";
$result = mysqli_query($mysqli,$sql);
if($row = mysqli_fetch_assoc($result))
{
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
$mysqli->close();	
?>  
<div id="form1">
    <h1>
        <span id="TopicName">学生请假记录</span>
    </h1>
    <div class="Table_list">
        <div class="textlist pad-bt0"></div>
                    <div class="textlist model-list">
                        <div class="row">
                            <div class="th_left phone">请假时间段：</div>
                            <div class="th_right phone">
                                <label><?php echo $beginDay; ?> <?php echo $beginTime; ?> 至 <?php echo $endItDay; ?> <?php echo $endItTime; ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="th_left phone">请假原因：</div>
                            <div class="th_right phone">
                                <label>病假</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="th_left phone">处理状态：</div>
                            <div class="th_right phone">
                                <label class="red">
                                                    <span>假期中</span>
                                                    <a href="404/404.html" class="btn btn-primary">下载请假单</a>

                                </label>

                            </div>

                        </div>

                    </div>

    </div>

</div>
<script>
    $(".model-list").on("click", function () {
        window.location.href = "/swun/message/message.php"});
</script>
        <link href="menustyle.css" rel="stylesheet">
        <script src="menu.js"></script>
        <div id="cd-nav" class="is-fixed">
            <a href="javascript:void(0)" class="cd-nav-trigger"><span></span></a>
            <nav id="cd-main-nav">
                <ul>
                        <li>
                            <a href="http://swun.loveviolet.cn/">
                                <img src="icon1.png"> 返回首页
                            </a>
                        </li>
                                        <li>
                        <a href="http://swun.loveviolet.cn/swun/404/404.html">
                            <img src="icon3.png"> 安全退出
                        </a>
                    </li>
                </ul>
            </nav>
        </div>


<!--第二版-->
</body>
</html>
