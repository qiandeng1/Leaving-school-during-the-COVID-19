$(function () {
    Index.init();
});
var Index = {
    init: function () {
        Index.verifyRepeatability();
        Index.laydate();
        Index.delApply();
    },
    verifyRepeatability: function () {
        options = {
            Newrule: function (t, vtype, text, value) {
                var validaresult = true;
                var tip;
                if (vtype == "LeaveBeginTime") {
                    var ConfigReturnDate = $("#LeaveBeginTime").val().replace(/-/g, "/");
                    var ConfigEndReturnDate = $("#LeaveEndTime").val().replace(/-/g, "/");
                    if (new Date(ConfigEndReturnDate) < new Date(ConfigReturnDate)) {
                        tip = layer.tips("不能大于" + ConfigEndReturnDate, t, {
                            tips: [1, '#2E8CFF'],
                            time: 1000
                        });
                        return false;
                    }
                    else {
                        layer.close(tip);
                    }
                }
                if (vtype == "LeaveEndTime") {
                    var ConfigReturnDate = $("#LeaveBeginTime").val().replace(/-/g, "/");
                    var ConfigEndReturnDate = $("#LeaveEndTime").val().replace(/-/g, "/");
                    if (new Date(ConfigEndReturnDate) < new Date(ConfigReturnDate)) {
                        tip = layer.tips("不能大于" + ConfigReturnDate, t, {
                            tips: [1, '#2E8CFF'],
                            time: 1000
                        });
                        return false;
                    }
                    else {
                        layer.close(tip);
                    }
                }
                if (vtype == "IsFile") {
                    var IsFile = $("#IsFile").val();
                    if (IsFile == "3" && $(".thumbimg").length == 0) {
                        $("#upload_img").focus();
                        tip = layer.tips("请上传附件图片", ".upload_li", {
                            tips: [1, '#2E8CFF'],
                            time: 1000
                        });
                        return false;
                    }
                    else {
                        layer.close(tip);
                    }
                }

                var days = parseInt($("#LeaveDays").val());
                var hours = parseInt($("#LeaveHours").val());
                var minutes = parseInt($("#LeaveMinutes").val());
                if (days < 1 && hours < 1 && minutes < 1) {
                    layer.alert("请假结束时间必须大于开始时间");
                    return false;
                }
                return validaresult;
            },
            callback: function () {
                $('.save_form').attr('disabled', "disabled");
                $(".save_form").text("提交中...");
                //图片数据 
                var imgData = new Array();
                var imgElms = $("#show_upload li").not(".upload_li");
                for (var i = 0; i < imgElms.length; i++) {
                    var obj = new Object();
                    obj.Name = $($("#show_upload li").not(".upload_li")[i]).find(".fileName").text();
                    obj.Status = $($("#show_upload li").not(".upload_li")[i]).attr('data-status');
                    if (obj.Status == "1") {
                        obj.FileData = $($("#show_upload li").not(".upload_li")[i]).attr('data-url');
                    }
                    else {
                        obj.FileData = $($("#show_upload li").not(".upload_li")[i]).find(".thumbimg").attr('src');
                    }
                    imgData.push(obj);
                }
                if (imgData.length > 0) {
                    $("#ImgData").val(JSON.stringify(imgData));
                }

                $("#form1").submit();
                return false;
            }
        };
        $("#form1").validation(options);

    },
    delApply: function () {
        $(".del_form").on("click", function () {
            var url = $(this).attr("data-url") + "?id=" + $("#Id").val();
            layer.confirm("你确定要撤销该申请吗？", {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {
                        window.location.href = data;
                    },
                    error: function (a, b) {
                        console.info(a, b);
                    }
                });
            }, function () {
                layer.closeAll();
            })
        });
    },
    laydate: function () {
        var that = this;
        var wd = $(window).width();
        if (wd > 1080) {
            $("#LeaveBeginTime").attr("type", "text");
            //$("#LeaveBeginTime").attr("readonly", "readonly");
            $("#LeaveEndTime").attr("type", "text");
            //$("#LeaveEndTime").attr("readonly", "readonly");
            $("#LeaveBeginTimeHour").attr("type", "text");
            //$("#LeaveBeginTimeHour").attr("readonly", "readonly");
            $("#LeaveEndTimeHour").attr("type", "text");
            //$("#LeaveEndTimeHour").attr("readonly", "readonly");
            laydate.render({
                elem: "#LeaveBeginTime",
                trigger: 'click',
                format: 'yyyy-MM-dd',
                type: 'date', //采用click弹出
                done: function (value, date, endDate) {

                    //计算时间差
                    if ($("#LeaveEndTime").val()) {
                        var s = new Date(value.replace(/-/g, "/") + ($("#LeaveBeginTimeHour").val().length > 0 ? (" " + $("#LeaveBeginTimeHour").val() + ":00") : " 00:00:00"));
                        var e = new Date($("#LeaveEndTime").val().replace(/-/g, "/") + ($("#LeaveEndTimeHour").val().length > 0 ? (" " + $("#LeaveEndTimeHour").val() + ":00") : " 00:00:00"));
                        var time = that.SecondToDate((e.getTime() - s.getTime()) / 1000);
                        $("#LeaveCount").html(time);
                    }
                    else {
                        $("#LeaveCount").html("");
                    }
                }
            });
            laydate.render({
                elem: "#LeaveEndTime",
                trigger: 'click',
                format: 'yyyy-MM-dd',
                type: 'date', //采用click弹出
                done: function (value, date, endDate) {
                    //计算时间差
                    if ($("#LeaveBeginTime").val()) {
                        var s = new Date(value.replace(/-/g, "/") + ($("#LeaveEndTimeHour").val().length > 0 ? (" " + $("#LeaveEndTimeHour").val() + ":00") : " 00:00:00"));
                        var e = new Date($("#LeaveBeginTime").val().replace(/-/g, "/") + ($("#LeaveBeginTimeHour").val().length > 0 ? (" " + $("#LeaveBeginTimeHour").val() + ":00") : " 00:00:00"));
                        var time = that.SecondToDate((s.getTime() - e.getTime()) / 1000);
                        $("#LeaveCount").html(time);
                    }
                    else {
                        $("#LeaveCount").html("");
                    }
                }
            });
            laydate.render({
                elem: "#LeaveBeginTimeHour",
                trigger: 'click',
                format: 'HH:mm',
                type: 'time', //采用click弹出
                done: function (value, date, endDate) {
                    //计算时间差
                    if ($("#LeaveBeginTime").val() && $("#LeaveEndTime").val()) {
                        var s = new Date($("#LeaveBeginTime").val().replace(/-/g, "/") + (value.length > 0 ? " " + value + ":00" : " 00:00:00"));
                        var e = new Date($("#LeaveEndTime").val().replace(/-/g, "/") + ($("#LeaveEndTimeHour").val().length > 0 ? (" " + $("#LeaveEndTimeHour").val() + ":00") : " 00:00:00"));
                        var time = that.SecondToDate((e.getTime() - s.getTime()) / 1000);
                        $("#LeaveCount").html(time);
                    }
                    else {
                        $("#LeaveCount").html("");
                    }
                }
            });
            laydate.render({
                elem: "#LeaveEndTimeHour",
                trigger: 'click',
                format: 'HH:mm',
                type: 'time', //采用click弹出
                done: function (value, date, endDate) {
                    //计算时间差
                    if ($("#LeaveBeginTime").val() && $("#LeaveEndTime").val()) {
                        var s = new Date($("#LeaveEndTime").val().replace(/-/g, "/") + (value.length > 0 ? " " + value + ":00" : " 00:00:00"));
                        var e = new Date($("#LeaveBeginTime").val().replace(/-/g, "/") + ($("#LeaveBeginTimeHour").val().length > 0 ? (" " + $("#LeaveBeginTimeHour").val() + ":00") : " 00:00:00"));
                        var time = that.SecondToDate((s.getTime() - e.getTime()) / 1000);
                        $("#LeaveCount").html(time);
                    }
                    else {
                        $("#LeaveCount").html("");
                    }
                }
            });
        }
        else {
            $("#LeaveBeginTime").on("change", function () { //计算时间差
                if ($("#LeaveEndTime").val()) {
                    var s = new Date($(this).val().replace(/-/g, "/") + ($("#LeaveBeginTimeHour").val().length > 0 ? (" " + $("#LeaveBeginTimeHour").val() + ":00") : " 00:00:00"));
                    var e = new Date($("#LeaveEndTime").val().replace(/-/g, "/") + ($("#LeaveEndTimeHour").val().length > 0 ? (" " + $("#LeaveEndTimeHour").val() + ":00") : " 00:00:00"));
                    var time = that.SecondToDate((e.getTime() - s.getTime()) / 1000);
                    $("#LeaveCount").html(time);
                }
                else {
                    $("#LeaveCount").html("");
                }
            });
            $("#LeaveEndTime").on("change", function () {
                //计算时间差
                if ($("#LeaveBeginTime").val()) {
                    var s = new Date($(this).val().replace(/-/g, "/") + ($("#LeaveEndTimeHour").val().length > 0 ? (" " + $("#LeaveEndTimeHour").val() + ":00") : " 00:00:00"));
                    var e = new Date($("#LeaveBeginTime").val().replace(/-/g, "/") + ($("#LeaveBeginTimeHour").val().length > 0 ? (" " + $("#LeaveBeginTimeHour").val() + ":00") : " 00:00:00"));
                    var time = that.SecondToDate((s.getTime() - e.getTime()) / 1000);
                    $("#LeaveCount").html(time);
                }
                else {
                    $("#LeaveCount").html("");
                }
            });
            $("#LeaveBeginTimeHour").on("change", function () { //计算时间差
                //计算时间差
                var value = $("#LeaveBeginTimeHour").val();
                if ($("#LeaveEndTime").val()) {
                    var s = new Date($("#LeaveBeginTime").val().replace(/-/g, "/") + ($(this).val().length > 0 ? " " + value + ":00" : " 00:00:00"));
                    var e = new Date($("#LeaveEndTime").val().replace(/-/g, "/") + ($("#LeaveEndTimeHour").val().length > 0 ? (" " + $("#LeaveEndTimeHour").val() + ":00") : " 00:00:00"));
                    var time = that.SecondToDate((e.getTime() - s.getTime()) / 1000);
                    $("#LeaveCount").html(time);
                }
                else {
                    $("#LeaveCount").html("");
                }
            });
            $("#LeaveEndTimeHour").on("change", function () {
               
                //计算时间差
                var value = $("#LeaveEndTimeHour").val();
                if ($("#LeaveBeginTime").val()) {
                    var s = new Date($("#LeaveEndTime").val().replace(/-/g, "/") + ($(this).val().length > 0 ? " " + value + ":00" : " 00:00:00"));
                    var e = new Date($("#LeaveBeginTime").val().replace(/-/g, "/") + ($("#LeaveBeginTimeHour").val().length > 0 ? (" " + $("#LeaveBeginTimeHour").val() + ":00") : " 00:00:00"));
                   
                    var time = that.SecondToDate((s.getTime() - e.getTime()) / 1000);
                    $("#LeaveCount").html(time);
                }
                else {
                    $("#LeaveCount").html("");
                }
            });
        }
    },
    SecondToDate: function (msd) {
        var time = msd
        var min = 0;
        var hour = 0;
        var day = 0;
        var sec = 0;
        //计算出相差天数
        day = Math.floor(msd / (24 * 3600));
        //计算出小时数
        var leave1 = msd % (24 * 3600);  //计算天数后剩余的毫秒数
        hour = Math.floor(leave1 / (3600));
        //计算相差分钟数
        var leave2 = leave1 % (3600);        //计算小时数后剩余的毫秒数
        min = Math.floor(leave2 / (60));
        if (null != time && "" != time) {
            if (time > 60 && time < 60 * 60) {
                $("#LeaveMinutes").val(min);
            }
            else if (time >= 60 * 60 && time < 60 * 60 * 24) {
                $("#LeaveDays").val("0");
                $("#LeaveHours").val(hour);
                $("#LeaveMinutes").val(min);


            } else if (time >= 60 * 60 * 24) {
                $("#LeaveDays").val(day);
                $("#LeaveHours").val(hour);
                $("#LeaveMinutes").val(min);
            }
            else {
                $("#LeaveDays").val("0");
                $("#LeaveHours").val("0");
                $("#LeaveMinutes").val("0");
            }
        }
        time = (0 !== day ? day + "天" : "") + (0 !== hour ? hour + "小时" : "") + (0 !== min ? min + "分" : "");
        return time;
    }
}

////判定是否显示隐藏域input 
function ChangeInputBoxStatus(elm) {
    var firstElm = $(elm)[0];
    if (firstElm) {
        if (firstElm.checked) {
            if (firstElm.type == "radio") {
                $(elm).parents(".radio_list").children(".next_inputbox").hide()
            }
            $(elm).parent(".item").next(".next_inputbox").show();
        }
        else {
            $(elm).parent(".item").next(".next_inputbox").hide();
            $(elm).parent(".item").next(".next_inputbox").find("input[type=text]").val("")
        }
        if (firstElm.type == "radio") {
            $(elm).parents(".th_right").find("input[type='text']").val("")
        }
    }
}