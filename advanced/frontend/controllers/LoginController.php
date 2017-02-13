<?php

namespace frontend\controllers;
use Yii;
use frontend\models\StudyAdmin;
use common\code\ValidateCode;
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
    //检测管理员登录
    public function actionCheck()
    {
      $session = Yii::$app->session;
    	$request=Yii::$app->request;
    	if($request->isPost)
    	{
            $post=$request->post();
            $code = $session['code'];
            $name = $post['name'];
            $pwd = $post['password'];
            $nowCode = $post['code'];
            // $pwd = md5($post['password']);
           // $pwd = Yii::$app->security->generatePasswordHash($post['password']);
            if($code!=$nowCode)
            {
                 echo "<script>alert('验证码错误');location.href='?r=login/login'</script>";
            }else
            {
                $res = StudyAdmin::checkAdmin($name,$pwd);
                if($res!='no')
                {
                  $time= date('Y-m-d H:i:s',time());
                  $time = strtotime($time);
                  $ip = $_SERVER['REMOTE_ADDR'];
                  $db = \Yii::$app->db->createCommand();
                  $reg = $db->update('study_admin' , ['admin_time'=>$time,'admin_ip'=>$ip], ['admin_id'=>$res['admin_id']])->execute();
                   if($res['status']=='0')
                   {
                       $session['admin_name'] = $name;
                       echo "<script>alert('登录成功');location.href='?r=index/index'</script>";
                   }elseif($res['status'] == '1')
                   {
                       $session['teacher_name'] = $name;
                       echo "<script>alert('登录成功');location.href='?r=index/index'</script>";
                   }else
                   {
                    echo "<script>alert('服务器错误');location.href='?r=login/login'</script>";
                   }
                      
                 // $result = StudyAdmin::saveInfo($name,$time,$ip);
                }else
                {
                    echo "<script>alert('账号或用户名错误');location.href='?r=login/login'</script>";
                }

            }
           
    	}else
    	{
    		return $this->render('login');
    	}
    	
    }
    /**
     * 验证码
     */
    public function actionCode()
    {
      //session_start();
      $session = Yii::$app->session;
    	$code = new ValidateCode();
    	$code->doimg();
    	$session['code'] = $code->getCode();
    }
    /**
     * 管理员退出登录
     */
    public function actionLogin_out()
    {
       $session=Yii::$app->session;
        if($session->remove('admin_name'))
        {
           $this->render('login');
        }
    }
}
