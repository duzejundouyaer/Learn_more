<?php

namespace frontend\controllers;

class LoginController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
	//登录界面
    public function actionLogin()
    {
        return $this->render('login');
    }

}
