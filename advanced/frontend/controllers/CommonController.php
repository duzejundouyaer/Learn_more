<?php

namespace frontend\controllers;

class CommonController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;

	//管理员修改密码
    public function init()
    {
       $session=\Yii::$app->session;
       $admin_session = $session['admin_name'];
       if(!isset($admin_session)){
			echo "<script>alert('请先登录');location.href='?r=login/login'</script>";die;
		}
    }

}
