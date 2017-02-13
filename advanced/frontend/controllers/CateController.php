<?php

namespace frontend\controllers;
use Yii;

use yii\web\Controller;
use frontend\models\UploadForm;
use common\libraries\Uploadfile;
use yii\web\UploadedFile;
use frontend\models\Type;
class CateController extends Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
    //分类列表
    public function actionCate()
    {
        $type=new Type();
        $info=$type::find()->asArray()->all();
        $data=$this->recursion($info);
        return $this->render('cate',['data'=>$data]);
    }
    //添加分类
    public function actionAddcate()
    {
        $request=Yii::$app->request;
        $model = new UploadForm();
        if($request->isPost) {
            //print_r($_FILES['type_img']);die;
            $data = Yii::$app->request->post();
            $upload=new UploadedFile(); //实例化上传类
            //print_r($upload);die;
            $upload->getInstanceByName('type_img'); //获取文件原名称
            $img=$_FILES['type_img']; //获取上传文件参数
            //print_r($img);die;
            $upload->tempName=$img['tmp_name']; //设置上传的文件的临时名称
            //创建目录
            $dir='typez/upload/';
            $rand = md5(time() . mt_rand(0,10000));
            $name= $dir.$rand.'.'.'jpg';
            //print_r($name);die;
            $arr=$upload->saveAs($name,true); //保存文件
            if($arr){
                $article = new Type();
                $article->type_name = $data['type_name'];
                $article->parent_id = $data['parent_id'];
                $article->type_is_show = $data['type_is_show'];
                $article->type_sort = $data['sort'];
                $article->type_img = $name;
                $res=$article->save();
                if ($res) {
                    //Yii::$app->getSession()->setFlash('errors', '保存成功');
                    return $this->redirect("?r=cate/cate");
                } else {
                    //Yii::$app->getSession()->setFlash('error', '保存失败');
                    return $this->redirect("?r=cate/addcate");
                }
            }else{
                echo "文件上传错误";
            }

        }else{
            $type=new Type();
            $info=$type::find()->asArray()->all();
            $data=$this->recursion($info);
            return $this->render('addcate',['type'=>$data,'model'=>$model]);
        }

    }
    //删除分类
    public function actionDetele(){
        $id = Yii::$app->request->post('id');
        $one=Type::find()->select('type_id')->where(['type_id'=>$id])->asArray()->one();
//        print_r($one);die;
        $type=new Type();
        $resone=$type::find()->where(['parent_id'=>$one['type_id']])->asArray()->all();
        if($resone){
            $info=[
                'code'=>1002,
                'arr'=>"有子级分类，无法删除！"
            ];
            return json_encode($info);
        }else{
            //删除一条
            $res = Type::findOne($id)->delete();
            if($res){
                $info=[
                    'code'=>1000,
                    'arr'=>"删除成功"
                ];
                return json_encode($info);
            }else{
                $info=[
                    'code'=>1001,
                    'arr'=>"删除失败！"
                ];
                return json_encode($info);
            }
        }
    }
    //修改分类
    public function actionCateedit(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $data = $request->post();
            //print_r($data);
            $article = Type::findOne($data['tid']);
            $article->type_name = $data['type_name'];
            $article->parent_id = $data['parent_id'];
            $article->type_is_show = $data['type_is_show'];
            $article->type_sort = $data['sort'];
            $res=$article->save();
            if($res){
                //Yii::$app->getSession()->setFlash('errors', '保存成功');
                return $this->redirect("?r=cate/cate");
            } else {
                //Yii::$app->getSession()->setFlash('error', '保存失败');
                return $this->redirect("?r=cate/cate");
            }
        }else{
            $tid = $request->get('tid');
            $one=Type::find()->where(['type_id'=>$tid])->asArray()->one();
            $type=new Type();
            $info=$type::find()->asArray()->all();
            $data=$this->recursion($info);
            return $this->render('cateedit',['one'=>$one,'type'=>$data]);
        }
    }
//是否显示点改
    public function actionShowupdate(){
        $tid = Yii::$app->request->post('tid');
        $is_show = Yii::$app->request->post('is_show');
        $article = Type::findOne($tid);
        $article->type_is_show = $is_show;
        $res=$article->save();
        if($res){
            $info=[
                'code'=>1000,
                'arr'=>"修改成功！"
            ];
            return json_encode($info);
        }else{
            $info=[
                'code'=>1001,
                'arr'=>"修改失败！"
            ];
            return json_encode($info);
        }
    }
//    public function actionUpload()
//    {
//        $model = new UploadForm();
//        if (Yii::$app->request->isPost) {
//            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
//            if ($model->upload()) {
//                // 文件上传成功
//                return;
//            }
//        }
//
//        return $this->render('upload', ['model' => $model]);
//    }
// //图片上传
    public function actionUploadone()
    {
        $uploaddir     = 'upload/';
        $filename      = date("Ymdhis").rand(100,999);
        $uploadfile    = $uploaddir . $filename.substr($_FILES['Filedata']["name"],strrpos($_FILES['Filedata']["name"],"."));
        $temploadfile  = $_FILES['Filedata']['tmp_name'];
        move_uploaded_file($temploadfile , $uploadfile);

        //返回数据  在页面上js做处理
        $filedata = array(
            'result' => 'true',
            'name' => $_FILES['Filedata']["name"],
            'filepath' => $uploadfile,
        );
        echo json_encode($filedata);
        exit;
    }
    public function recursion($data,$path=0,$flag=1){
        static $arr=array();
        foreach($data as $key=>$val){
            if($val['parent_id']==$path){
                $val['flag']=$flag;
                $arr[]=$val;
                $this->recursion($data,$val['type_id'],$flag+1);
            }
        }
        return $arr;
    }

}
