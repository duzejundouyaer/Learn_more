<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\data\Pagination;
use app\models\teacher;

/**
 * 名师点播
 * Teacher controller
 */
class TeacherController extends Controller
{

public $enableCsrfValidation = false; //禁止表单提交验证
public $layout = false;

/**
 *跳转添加页面
 * 
 */
	public function actionYe(){

		return $this->render('teacher');
	}



 /**
  * 添加直播
  * @inheritdoc
  */
    public function actionAdd()
    {
    	
    	$upload=new UploadedFile(); //实例化上传类
    	//print_r($upload);die;
        $name=$upload->getInstanceByName('photo'); //获取文件原名称
        $img=$_FILES['photo']; //获取上传文件参数
        //print_r($img);die;
		$tmp_img=$upload->tempName=$img['tmp_name']; //设置上传的文件的临时名称
		
		//创建目录
		$dir='upload/';
		$rand = md5(time() . mt_rand(0,10000));
		$name= $dir.$rand.'.'.'jpg';
		//print_r($name);die;
		$arr=$upload->saveAs($name,true); //保存文件
		 //var_dump($arr);
    	if($arr){
    		$photo=$name;
    		//print_r($photo);die;
    	//接值 用request
    		$add= yii::$app->request;
    		$res=$add->post();
    		$title=$res['title'];
    		$begintime=$res['begintime'];
    		$endtime=$res['endtime'];
    		$course=$res['course'];

    		$test= new teacher();
    		//print_r($test);die;
        			$test->title     =       $title;
        			$test->photo     =        $photo;
        			$test->begintime =   $begintime;
        			$test->endtime   =     $endtime;
        			$test->course    =      $course;
        			$res  =  $test->save();
        			if($res){

        				return $this->redirect("?r=teacher/show");

        			}else{

        				echo  "alert('失败')";
        			}
    	}else{
    		echo "失败失败";
    	}
    	//print_r($res);die;

    }


 /**
  *直播列表
  * 
  */

	public function actionShow(){

     /**
      * 查询
      */
      
		$test=new teacher();	//实例化model模型
		$arr=$test->find();
		//$countQuery = clone $arr;
		$pages = new Pagination([
		//'totalCount' => $countQuery->count(),
		'totalCount' => $arr->count(),
		'pageSize'   => 4  //每页显示条数
		]);
		$rel = $arr->offset($pages->offset)
			->limit($pages->limit)
			->all();
	return $this->render('show', [
		'rel' => $rel,
		'pages'  => $pages
	]);

	}   


	/**
	 *
	 * 删除
	 */

	public function actionDelete(){	
		//echo 1;die;
	//接删除id
		$id=$_GET['id'];
		//echo $id;die;
		
		$result=teacher::find()->where(['id'=>$id])->one();
		$reg = $result->delete();
		if($reg)
		{
			return 1;
		}

	}

}


?>