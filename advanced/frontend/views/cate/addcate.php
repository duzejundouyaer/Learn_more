<?php
use yii\widgets\ActiveForm;
?>
<?php //$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?//= $form->field($model, 'imageFile')->fileInput() ?>
<!--<button>Submit</button>-->
<?php //ActiveForm::end() ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="css/pintuer.css">
<link rel="stylesheet" href="css/admin.css">
    <style>
        .main{ width:610px; height:0px auto; border:1px solid #e1e1e1; font-size:12px; padding:10px;}
        .main p{ line-height:10px; width:500px; float:right; text-indent:20px;}
        .uploadPut{ width:100%; clear:both;}
        ul,li{ margin:0px; padding:0px; list-style:none}
        .uploadPut li{width:120px; padding:10px; text-align:center; border:1px solid #ccc; overflow:hidden; background-color:#e1e1e1; line-height:25px; float:left; margin:5px}
        .uploadPut img{ width:120px; height:90px;}
    </style>
</head>
<body>
<div class="panel admin-panel margin-top">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加分类</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="?r=cate/addcate" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>分类标题：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="type_name" value="" data-validate="required:请输入分类标题"  />
          <div class="tips"></div>
        </div>
      </div>
        <div class="form-group">
            <div class="label">
                <label>上级分类：</label>
            </div>
            <div class="field">
                <select name="parent_id" class="input w50">
                    <?php foreach($type as $key=>$val){?>
                        <option value="<?php echo $val['type_id']?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;',$val['flag'])?>
                            <?php echo $val['type_name']?></option>
                    <?php }?>
                </select>
                <div class="tips">不选择上级分类默认为一级分类</div>
            </div>
        </div>
<!--        <div class="form-group">-->
<!--            <div class="label">-->
<!--                <label>分类图标：</label>-->
<!--            </div>-->
<!--            <div class="field">-->
<!--                <div class="main">-->
<!--                    --><?php
//                    //获取项目跟路径
//                    $baseURL = 'http://' . $_SERVER ['SERVER_NAME'] . (($_SERVER ['SERVER_PORT'] == 80) ? '' : ':' . $_SERVER ['SERVER_PORT']) . ((($path = str_ireplace('\\', '/', dirname ( $_SERVER ['SCRIPT_NAME'] ))) == '/') ? '' : $path);
////echo $baseURL;die;
//
//                    //设置swfupload参数
//                    $flashvars = 'uploadURL=' . urlencode($baseURL . '/index.php?r=cate/uploadone');   						   #上传提交地址
//                    $flashvars.= '&buttonImageURL=' . urlencode($baseURL . '/images/upload.png');        	   #按钮背景图片
//                    $flashvars.= '&btnWidth=95';                                                               #按钮宽度
//                    $flashvars.= '&btnHeight=35';                                                              #按钮高度
//                    $flashvars.= '&fileNumber=20';                                                             #每次最多上传20个文件
//                    $flashvars.= '&fileSize=200';                                        					   #单个文件上传大小为20M
//                    $flashvars.= '&bgColor=#ffffff';                                                           #背景颜色
//                    $flashvars.= '&fileTypesDescription=Images';                                               #选择文件类型
//                    $flashvars.= '&fileType=*.jpg;*.png;*.gif;*.jpeg';                                         #选择文件后缀名
//
//                    ?>
<!--                    <object style="float: left;" width="95" height="35" data="images/upload.swf" type="application/x-shockwave-flash">-->
<!--                        <param value="transparent" name="wmode">-->
<!--                        <param value="images/upload.swf" name="movie">-->
<!--                        <param value="high" name="quality">-->
<!--                        <param value="false" name="menu">-->
<!--                        <param value="always" name="allowScriptAccess">-->
<!--                        <param value="--><?php //echo $flashvars;?><!--" name="flashvars">-->
<!--                    </object>-->
<!--                    <div class="uploadPut">-->
<!--                        <ul id="uploadPut">-->
<!---->
<!--                        </ul>-->
<!--                        <div style="clear: both;"></div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--                <div class="tips"></div>-->
<!--            </div>-->
<!--        </div>-->
      <div class="form-group">
        <div class="label">
          <label>是否显示：</label>
        </div>
        <div class="field">
          <input type="radio" class="radio" name="type_is_show" value="1" checked="checked"/>显示&nbsp;&nbsp;&nbsp;
          <input type="radio" class="radio" name="type_is_show" value="0"/>不显示&nbsp;&nbsp;&nbsp;
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>排序：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="sort" value="1"  data-validate="required:请输入分类标题,number:排序必须为数字" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
<script src="js/jquery.js"></script>
<script src="js/pintuer.js"></script>
<script>
    /*上传错误信息提示*/
    function showmessage(message){alert(message);}
    /*显示文件名称*/
    function setfilename(ID,filename){
        ID = replaceStr(ID);
        var htmls = '<li id="'+ID+'"><p>'+filename+'</p><p class="load">0%</p></li>';
        $("#uploadPut").append(htmls);
    }
    /*显示上传进度*/
    function setfileload(ID,load){
        ID = replaceStr(ID);
        $("#"+ID+" .load").html(load);
    }
    /*返回服务上传的数据*/
    function setfilepath(ID,data){
        ID = replaceStr(ID);
        var s = eval('('+data+')');
        if(s.result=="true"){
            $("#"+ID).html("<img id='"+s.id+"' src='"+s.filepath+"'/><br/>"+s.name);
        }else{
            $("#"+ID).html(s.name+"上传失败");
        }
    }
    /*替换特殊字符*/
    function replaceStr(ID){
        var reg = new RegExp("[=,/,\,?,%,#,&,(,),!,+,-,},{,:,>,<]","g"); //创建正则RegExp对象
        var ID = ID.replace(reg,"");
        return ID;
    }
</script>
</html>