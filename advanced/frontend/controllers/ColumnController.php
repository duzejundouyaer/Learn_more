<?php

namespace frontend\controllers;

class ColumnController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;

    public function actionColumn()
    {
        return $this->render('column');
    }

}
