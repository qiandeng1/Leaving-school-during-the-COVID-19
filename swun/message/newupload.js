var ImageListurl = []; //当前储存图片地址
var dataArr = []; //预览存储图片数据
var Cid = "";//当前操作项ID
var Systemid = "";//编辑时对应IMG keyID
var OnloadCount;//计算进过处理后的图片个数
$(function () {
    Newupload.init();
});

var Newupload = {
    init: function () {
        this.Uploadimage();
    },
    ImageSize: function (path, obj, callback) {
        var img = new Image();
        img.src = path;
        img.onload = function () {
            var that = this;
            // 默认按比例压缩
            var w = that.width,
                h = that.height,
                scale = w / h;
            w = obj.width || w;
            h = obj.height || (w / scale);
            var quality = 0.5; // 默认图片质量为0.5
            //生成canvas
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            // 创建属性节点
            var anw = document.createAttribute("width");
            anw.nodeValue = w;
            var anh = document.createAttribute("height");
            anh.nodeValue = h;
            canvas.setAttributeNode(anw);
            canvas.setAttributeNode(anh);
            ctx.drawImage(that, 0, 0, w, h);
            // 图像质量
            if (obj.quality && obj.quality <= 1 && obj.quality > 0) {
                quality = obj.quality;
            }
            // quality值越小，所绘制出的图像越模糊
            var base64 = canvas.toDataURL('image/jpeg', quality);
            // 回调函数返回base64的值
            callback(base64);
        }
    },
    //将以base64的图片url数据转换为Blob
    ToBlob: function convertBase64UrlToBlob(urlData) {
        var arr = urlData.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], { type: mime });
    },
    Uploadimage: function () {

        $("#upload_button").click(function () {
            return $("#upload_img").click();
        });
        //图片查看
        $("#show_upload").delegate(".result_img img", "click", function () { //查看全图        
            var index = $(this).parents("li").index();
            Newupload.ShowPhotos(dataArr, index);
        })

        //删除
        $("#show_upload").delegate(".del_img", "click", function () { //删除图片 
            $("#upload_img").val("");
            $(this).parents("li").remove();
        })
        $("#upload_img").change(function () {
            var iLen = this.files.length;
            var indexlayer;
            OnloadCount = 0;//计算进过处理后的图片个数
            //图片选择去重 
            var removal = function (reader, indexfile, Iindex) {
                if (reader) {
                    if (dataArr.length != 0) {
                        var flag = false; //设置标志是否重复
                        for (var i = 0; i < dataArr.length; i++) {
                            if (dataArr[i].Name == indexfile.name) { //重复时不添加
                                flag = true;
                                layer.msg("文件已存在", { icon: 2 }, 500);
                            }
                        }
                        if (flag != true) { //当不重复时执行                    
                            readerload(indexfile);
                            ImageSizeC(reader, indexfile, Iindex)
                        }
                    } else {
                        readerload(indexfile);
                        ImageSizeC(reader, indexfile, Iindex);
                    }
                }

            }
            //存储预览
            var readerload = function (indexfile, callback) {
                indexlayer = layer.load(1, { shade: [0.3, '#fff'] });
                var loading = "../content/img/loading.jpg";

                resultHtml = '<li><div class="result_img" ><img class="thumbimg" src="' + loading + '" alt=""/><small class="del_img">×</small></div><div class="fileName"><span>' + indexfile.name + '</span></div></li>';

                $("#show_upload .upload_li").before(resultHtml); //插入页面                            

            };
            //大于2M，进行压缩上传
            var ImageSizeC = function (reader, indexfile, Iindex) {

                if (file.size / 1024 > 1024) {
                    var path //图片base64地址
                    reader.onload = function (e) {
                        path = this.result;
                        Newupload.ImageSize(path, indexfile, function (b64) {
                            indexlayer = layer.load(1, { shade: [0.3, '#fff'] });
                            dataArr.push({
                                Name: indexfile.name, //获取文件名
                                Url: b64 //readAsDataURL处理后储存地址
                            });
                            $("#show_upload li").eq(Iindex).children().children(".thumbimg").attr("src", b64)
                            if (b64) {
                                OnloadCount++;
                                if (OnloadCount == iLen) {
                                    layer.close(indexlayer); //关闭loading层
                                }
                            }
                        });
                    }
                } else { //小于等于1M 原图上传
                    reader.onload = function (e) {
                        dataArr.push({
                            Name: indexfile.name, //获取文件名
                            Url: this.result //readAsDataURL处理后储存地址
                        });
                        $("#show_upload li").eq(Iindex).children().children(".thumbimg").attr("src", this.result)
                        OnloadCount++;
                        if (OnloadCount == iLen) {
                            layer.close(indexlayer); //关闭loading层
                        }
                    }
                }

            }
            var count = (($("#show_upload li").length) - 1);//计算当前已有图片个数     
            for (var i = 0; i < iLen; i++) {
                var file = event.target.files[i];
                if (!$("#upload_img").val().match(/.jpg|.jpeg|.png|.bmp/i)) {　　 //判断所选文件格式
                    layer.msg("只能上传jpg、jpeg、png、bmp格式的文件", {
                        icon: 2
                    });
                    return false
                } else if (file.size / 1024 > 5120) {
                    layer.msg("文件大小不能超过5M", {
                        icon: 2
                    });
                    return false
                } else if ($(".thumbimg").length > 2) {
                    layer.msg("只能上传三个附件", {
                        icon: 2
                    });
                    return false
                }
                var reader = new FileReader();
                reader.readAsDataURL(file);
                removal(reader, file, count + i);
            }
        })
    },

    //预览
    ShowPhotos: function (urllist, index) {
        var imgElm = $(".thumbimg");
        var imgAll = [];
        if (imgElm.length > 0) {
            for (var i = 0; i < imgElm.length; i++) {
                var imgthmb = {
                    "alt": "",
                    "pid": i, //图片id
                    "src": $(imgElm[i]).attr("src"), //原图地址
                }
                imgAll.push(imgthmb);
            }
            layer.photos({
                photos: {
                    "title": "文件预览", //相册标题
                    "id": "photoImg", //相册id
                    "start": index, //初始显示的图片序号，默认0
                    "data": imgAll
                },
                anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
                , scrollbar: false
            });

        } else {
            layer.msg("暂无图片", { icon: 1, time: 1000 }, function () { });
        }

    },
}