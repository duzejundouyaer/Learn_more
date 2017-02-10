<?php    use yii\helpers\Url;?>
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
<script src="js/jquery.js"></script>
<script src="js/pintuer.js"></script>
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong></div>
  <div class="padding border-bottom">
    <button type="button" class="button border-yellow" onclick="window.location.href='?r=cate/addcate'">
        <span class="icon-plus-square-o"></span>
        添加分类
    </button>
  </div>
  <table class="table table-hover text-center">
    <tr>
      <th width="5%">ID</th>
      <th width="15%">名称</th>
      <th width="10%">是否显示</th>
      <th width="10%">操作</th>
    </tr>
      <?php foreach($data as $key=>$val){ ?>
    <tr>
      <td><?php echo $val['type_id']?></td>
      <td>
          <?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$val['flag'])?>
          <?php echo $val['type_name']?>
      </td>
      <td><?php echo $val['type_is_show']?></td>
      <td>
          <div class="button-group">
              <a class="button border-main" href="<?=Url::toRoute(['cate/cateedit'])?>">
                  <span class="icon-edit"></span> 修改
              </a>
              <a class="button border-red" href="javascript:void(0)" onclick="return del(<?php echo $val['type_id']?>)">
                  <span class="icon-trash-o"></span> 删除
              </a>
          </div>
      </td>
    </tr>
      <?php }?>
  </table>
</div>
<script type="text/javascript">
function del(id){
	if(confirm("您确定要删除吗?")){
        $.ajax({
            type: "POST",
            url: "?r=cate/detele",
            data: {id:id},
            dataType:"json",
            success: function(msg){
                alert(msg.code);
            }
        });
	}
}
</script>
</body>
</html>