<?php

namespace frontend\controllers;

class CateController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
  //分类
    public function actionCate()
    {
        return $this->render('cate');
    }
    //修改分类
    public function actionCateedit()
    {
    	return $this->render('cateedit');
    }

}
