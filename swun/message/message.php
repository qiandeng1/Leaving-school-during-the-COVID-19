<!doctype html>
<?php
  session_start();//开启session会话
?>
<html xmlns="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="renderer" content="webkit">
    <link href="index.css" rel="stylesheet">
    <!--[if lt IE 9]><script r='m'>document.createElement("section")</script><![endif]-->
	<script src="jquery-3.4.1.min.js"></script>
    <script src="validation.js"></script>
    <link href="layer.css" rel="stylesheet">
    <script src="layer.js"></script><link rel="stylesheet" href="layer.css" id="layuicss-layer">
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
<link rel="stylesheet" href="laydate.css" id="layuicss-laydate"></head>
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
<script src="laydate.js"></script>
<link href="uploadedit.css" rel="stylesheet">
<script src="DailyLeave.js"></script>
<style>
    .row-title {
        font-size: 16px;
        padding: 5px 15px;
    }

    @media screen and (max-width: 960px) {
        input[type='time'] {
            margin: 0 !important;
            width: 100% !important;
            border-radius: 4px;
            outline: none;
            height: 32px;
            line-height: 32px;
            border: 1px solid #ddd;
            padding: 0 5px;
            font-family: "microsoft yahei";
        }
    }
</style>
    <h1>
        <span id="TopicName">学生请假记录详情</span>
    </h1>
    <div class="Table_list">
        <div class="textlist pad-bt0"></div>
        <div class="textlist">
            <div class="row ">
                <pre cssclass="PutThing"></pre>
            </div>
        </div>
                <div class="textlist">
                                <div class="row">
                                    <div class="th_left phone">2020-09-01</div>
                                    <div class="th_right phone">【学生申请】- <?php echo $name;?>(<?php echo $id;?>)发起申请</div>
                                </div>
                                <div class="row">
                                    <div class="th_left phone">2020-09-02</div>
                                    <div class="th_right phone">【辅导员】- 同意</div>
                                </div>
                                <div class="row">
                                    <div class="th_left phone">2020-09-02</div>
                                    <div class="th_right phone">【学院】- 同意</div>
                                </div>

                </div>

        <div class="textlist">
            <div class="row">
                <div class="th_left phone">学号：</div>
                <div class="th_right phone">
                    <label><?php echo $id;?></label>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">姓名：</div>
                <div class="th_right phone">
                    <label><?php echo $name;?></label>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">性别：</div>
                <div class="th_right phone">
                    <input id="Sex" name="Sex" type="hidden" value="男">
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">学历：</div>
                <div class="th_right phone">
                    <label>本科</label>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">学院：</div>
                <div class="th_right phone">
                    <label><?php echo $academy;?></label>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">专业：</div>
                <div class="th_right phone">
                    <label><?php echo $subject;?></label>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">年级：</div>
                <div class="th_right phone">
                    <label>2018</label>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">班级：</div>
                <div class="th_right phone">
                    <label><?php echo $class;?></label>
                </div>
            </div>
        </div>
        <div class="textlist">
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>请假开始时间：</div>
                <div class="th_right phone">
                    <input type="date" name="beginDay" value="<?php echo $beginDay;?>">
                    <input type="time" name="beginTime" value="<?php echo $beginTime;?>">
                </div>
            </div>
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>请假结束时间：</div>
                <div class="th_right phone">
                    <input type="date" name="beginDay" value="<?php echo $endItDay;?>">
                    <input type="time" name="beginTime" value="<?php echo $endItTime;?>">
                </div>
            </div>
            <div class="row">
                <div class="th_left phone">请假时长：</div>
                <div class="th_right phone">
                    <label id="LeaveCount" class="red">
						<?php 
						$dayans = substr($endItDay, -2) - substr($beginDay, -2);
						$trueday = substr($endItDay, -2) - substr($beginDay, -2) - intval(1);
						$timeans = intval($endItTime) - intval($beginTime);
						$truetime = intval(24) - intval($beginTime) + intval($endItTime);
						if($timeans < 0)
						{
							if($trueday > 0){
								echo "{$trueday}天";
							}
							echo "{$truetime}小时";
						}
						else
						{
							if($dayans > 0){
								echo "{$dayans}天";
							}
							echo "{$timeans}小时";
						}
						?></label>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>请假原因：</div>
                <div class="th_right phone radio_list required validate">
                            <input value="01011001" name="LeaveReason" type="radio" checked="checked" id="01011001"> <label for="01011001">&nbsp;病假</label>
                            <input value="01011002" name="LeaveReason" type="radio" id="01011002"> <label for="01011002">&nbsp;事假</label>
                            <input value="01011003" name="LeaveReason" type="radio" id="01011003"> <label for="01011003">&nbsp;求职</label>
                            <input value="01011004" name="LeaveReason" type="radio" id="01011004"> <label for="01011004">&nbsp;培训</label>
                            <input value="01011005" name="LeaveReason" type="radio" id="01011005"> <label for="01011005">&nbsp;实习</label>
                            <input value="01011006" name="LeaveReason" type="radio" id="01011006"> <label for="01011006">&nbsp;实践</label>
                            <input value="01011007" name="LeaveReason" type="radio" id="01011007"> <label for="01011007">&nbsp;回家</label>
                            <input value="01011008" name="LeaveReason" type="radio" id="01011008"> <label for="01011008">&nbsp;校外住宿</label>
                            <input value="01011009" name="LeaveReason" type="radio" id="01011009"> <label for="01011009">&nbsp;其他</label>

                </div>
            </div>
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>详细说明：</div>
                <div class="th_right phone">
                    <textarea vtype="LeaveReasonDetail" class="validate required input-style" cols="20" data-val="true" data-val-length="字段 LeaveReasonDetail 必须是最大长度为 100 的字符串。" data-val-length-max="100" id="LeaveReasonDetail" name="LeaveReasonDetail" rows="2" style="width:100%;height:100px;resize:none; "></textarea>
                </div>
            </div>
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>本人电话：</div>
                <div class="th_right phone">
                	<input type="text" name="tel" value="<?php echo $tel;?>">
                </div>
            </div>
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>外出地点：</div>
                <div class="th_right phone">
                    <input vtype="OutAddressStreet" class="validate required input-style" data-val="true" data-val-length="字段 OutAddressStreet 必须是最大长度为 100 的字符串。" data-val-length-max="100" id="OutAddressStreet" name="OutAddressStreet" type="text" value="双流区第一人民医院">
                </div>
            </div>
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>外出联系人：</div>
                <div class="th_right phone">
                    <input type="text" name="tel" value="<?php echo $name;?>">
                </div>
            </div>
            <div class="row">
                <div class="th_left phone"><span class="red">*</span>联系人电话：</div>
                <div class="th_right phone">
                    <input type="text" name="tel" value="<?php echo $tel;?>">
                </div>
            </div>
        </div>
        <div class="textlist">
            <div class="content_table row" style="clear:both;width: 100%; text-align: left;  line-height: 30px; overflow: hidden;">
                <input id="upload_img" type="file" style="height:0;width:0;float:left;" accept="image/*">
                <p class="red" style="font-size:10px;">
                    只能上传jpg、jpeg、png、bmp格式的文件
                </p>
                <ul id="show_upload" class="">
                    
                </ul>
            </div>
        </div>

    </div>

<script src="newupload.js"></script>

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
</body></html>