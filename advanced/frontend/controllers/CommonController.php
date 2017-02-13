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
       $session=\Yii::$app->session;  //开启session
       $admin_session = $session['admin_name'];   //获取管理员session名称
       if(!isset($admin_session)){     //检测该原理元session是否存在
			echo "<script>alert('请先登录');location.href='?r=login/login'</script>";die;
		}
    }

}
